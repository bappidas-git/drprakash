/* ============================================================
   Online Xpress — Tracking
   Calls php/track-api.php for each AWB and renders a result
   card with stepper + detailed scan timeline.
   ============================================================ */
(function () {
  'use strict';

  var TRACKING_API_BASE = 'php/track-api.php';

  var STEPS = ['Order Booked', 'Picked Up', 'In Transit', 'Out for Delivery', 'Delivered'];
  var STATUS_INDEX = {
    'order booked': 0, 'booked': 0,
    'picked up': 1, 'pickup': 1,
    'in transit': 2,
    'out for delivery': 3,
    'delivered': 4,
    'rto': 2
  };
  var BADGE_CLASS = {
    'order booked': 'booked', 'booked': 'booked',
    'picked up': 'picked', 'pickup': 'picked',
    'in transit': 'transit',
    'out for delivery': 'out',
    'delivered': 'delivered',
    'rto': 'rto',
    'ndr': 'rto'
  };

  var inputView  = document.getElementById('trackInput');
  var resultsView = document.getElementById('trackResults');
  var resultList  = document.getElementById('resultList');
  var resultCount = document.getElementById('resultCount');
  var form        = document.getElementById('trackForm');
  var awbInput    = document.getElementById('awbInput');
  var btn         = document.getElementById('trackBtn');
  var msg         = document.getElementById('trackMsg');
  var backBtn     = document.getElementById('trackBack');

  if (!form) return;

  /* --- parse input: split on newline/comma, trim, dedupe --- */
  function parseAwbs(raw) {
    var seen = {}, out = [];
    raw.split(/[\n,]+/).forEach(function (t) {
      var v = t.trim();
      if (v && !seen[v]) { seen[v] = 1; out.push(v); }
    });
    return out;
  }

  /* --- fetch one AWB from the PHP API --- */
  function fetchTracking(awb) {
    return fetch(TRACKING_API_BASE + '?awb=' + encodeURIComponent(awb))
      .then(function (r) {
        if (!r.ok && r.status !== 404) throw new Error('http ' + r.status);
        return r.json();
      });
  }

  /* --- submit --- */
  form.addEventListener('submit', function (e) {
    e.preventDefault();
    msg.innerHTML = '';
    var awbs = parseAwbs(awbInput.value);
    if (!awbs.length) {
      msg.innerHTML = '<div class="track-msg error">Please enter at least one Airway Bill Number.</div>';
      awbInput.focus();
      return;
    }
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner"></span> Tracking…';

    Promise.all(awbs.map(function (awb) {
      return fetchTracking(awb).catch(function () { return { awb: awb, error: true }; });
    })).then(function (results) {
      btn.disabled = false;
      btn.textContent = 'Track now';
      renderResults(results);
    });
  });

  if (backBtn) backBtn.addEventListener('click', function () {
    resultsView.hidden = true;
    inputView.hidden = false;
    resultList.innerHTML = '';
    window.scrollTo({ top: 0, behavior: 'smooth' });
    awbInput.focus();
  });

  /* --- render --- */
  function renderResults(results) {
    inputView.hidden = true;
    resultsView.hidden = false;
    resultCount.textContent = results.length + (results.length === 1 ? ' shipment' : ' shipments');
    resultList.innerHTML = results.map(renderCard).join('');
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }

  function esc(s) {
    return String(s == null ? '' : s).replace(/[&<>"]/g, function (c) {
      return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c];
    });
  }

  function renderCard(d) {
    if (d.notFound) {
      return '<div class="result-card"><div class="track-msg error" style="margin:0;border-radius:0">' +
        'No shipment found for AWB <b>' + esc(d.awb) + '</b>. Please check the number and try again.</div></div>';
    }
    if (d.error) {
      return '<div class="result-card"><div class="track-msg error" style="margin:0;border-radius:0">' +
        'Couldn’t fetch tracking for AWB <b>' + esc(d.awb) + '</b>. Please try again shortly.</div></div>';
    }

    var rawStatus = d.status || '';
    var statusKey = rawStatus.toLowerCase().split(' - ')[0].trim(); // strip NDR reason suffix
    var isRto = statusKey === 'rto';
    var isNdr = statusKey === 'ndr';
    var idx = STATUS_INDEX[statusKey] != null ? STATUS_INDEX[statusKey] : 0;
    var badgeCls = BADGE_CLASS[statusKey] || 'booked';

    /* stepper */
    var stepper = STEPS.map(function (label, i) {
      var cls;
      if (i < idx) cls = 'done';
      else if (i === idx) cls = (isRto || isNdr) ? 'done' : 'current';
      else cls = '';
      var icon = cls === 'done'
        ? '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M20 6L9 17l-5-5"/></svg>'
        : '<span style="width:8px;height:8px;border-radius:50%;background:currentColor;display:block"></span>';
      return '<div class="step ' + cls + '"><div class="dot">' + icon + '</div><div class="lbl">' + label + '</div></div>';
    }).join('');

    /* RTO / NDR flag banners */
    var rtoFlag = isRto
      ? '<div class="rto-flag"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 7v6h6M3 13a9 9 0 1018-6"/></svg>This shipment is being returned to origin (RTO).</div>'
      : '';
    var ndrFlag = isNdr
      ? '<div class="rto-flag"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>Delivery attempt failed' + (d.ndrReason ? ': ' + esc(d.ndrReason) : '') + (d.ndrDate ? ' on ' + esc(d.ndrDate) : '') + '.</div>'
      : '';

    /* scan history */
    var events = (d.events || []).slice().sort(function (a, b) {
      return new Date(b.timestamp) - new Date(a.timestamp);
    });
    var scans = events.map(function (ev) {
      return '<div class="scan"><div class="sdot"></div><div class="scan-body">' +
        '<div class="st">' + esc(ev.status) + '</div>' +
        '<div class="loc">' + esc(ev.description || '') + (ev.location ? ' · ' + esc(ev.location) : '') + '</div>' +
        '<div class="ts">' + fmtDate(ev.timestamp) + '</div></div></div>';
    }).join('');

    /* extra detail row */
    var extras = '';
    if (d.consignee) extras += '<div class="meta"><span>Consignee</span><b>' + esc(d.consignee) + '</b></div>';
    if (d.bookingDate) extras += '<div class="meta"><span>Booking Date</span><b>' + esc(d.bookingDate) + '</b></div>';
    if (d.deliveryDate) extras += '<div class="meta"><span>Delivered On</span><b>' + esc(d.deliveryDate) + (d.deliveryTime ? ' ' + esc(d.deliveryTime) : '') + '</b></div>';
    if (d.codAmount) extras += '<div class="meta"><span>COD Amount</span><b>₹' + esc(d.codAmount) + '</b></div>';
    if (d.reference) extras += '<div class="meta"><span>Reference</span><b>' + esc(d.reference) + '</b></div>';

    return '<div class="result-card">' +
      '<div class="result-head">' +
        '<div><div class="awb">' + esc(d.awb) + '</div>' +
          '<div class="meta"><span>Courier</span><b>' + esc(d.courier || '—') + '</b></div>' +
        '</div>' +
        '<span class="badge ' + badgeCls + '">' + esc(rawStatus || 'Unknown') + '</span>' +
        '<div class="meta"><span>Route</span><b>' + esc(d.origin || '—') + ' → ' + esc(d.destination || '—') + '</b></div>' +
        '<div class="meta"><span>Expected Delivery</span><b>' + fmtDateOnly(d.expectedDelivery) + '</b></div>' +
        '<div class="meta"><span>Last Updated</span><b>' + fmtDate(d.lastUpdate) + '</b></div>' +
        extras +
      '</div>' +
      (isRto || isNdr ? '' : '<div class="stepper">' + stepper + '</div>') +
      rtoFlag + ndrFlag +
      (scans ? '<div class="scans"><h4>Tracking History</h4>' + scans + '</div>' : '') +
    '</div>';
  }

  function fmtDate(ts) {
    if (!ts) return '—';
    var d = new Date(ts);
    if (isNaN(d)) return esc(ts);
    return d.toLocaleString('en-IN', { day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' });
  }
  function fmtDateOnly(ts) {
    if (!ts) return '—';
    var d = new Date(ts);
    if (isNaN(d)) return esc(ts);
    return d.toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' });
  }
})();
