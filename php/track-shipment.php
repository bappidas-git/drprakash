<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title>Tracking Result — Online Xpress</title>
<meta name="description" content="Online Xpress shipment tracking result — live status, delivery progress, and full scan history.">
<link rel="icon" href="https://res.cloudinary.com/drx1zsmeq/image/upload/v1782824174/Icon-OnlineXpress_aeynkp.png">
<link rel="apple-touch-icon" href="https://res.cloudinary.com/drx1zsmeq/image/upload/v1782824174/Icon-OnlineXpress_aeynkp.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../css/styles.css">
<style>
  /* ---- result table ---- */
  .result-section { padding: 48px 0 64px; }
  .result-table-wrap { overflow-x: auto; margin-top: 32px; }
  .result-table {
    width: 100%;
    border-collapse: collapse;
    font-size: .875rem;
    font-family: var(--font-body, Inter, sans-serif);
    border: 3px solid var(--primary, #FC5F45);
    border-radius: 8px;
    overflow: hidden;
  }
  .result-table thead tr { background: #1a1a2e; color: #fff; }
  .result-table th,
  .result-table td { padding: 12px 14px; text-align: left; white-space: nowrap; }
  .result-table tbody tr:nth-child(even) { background: #fafafa; }
  .result-table tbody tr:hover { background: #fff5f3; }
  .result-table a { color: var(--primary, #FC5F45); text-decoration: none; font-weight: 600; }
  .result-table a:hover { text-decoration: underline; }

  /* ---- modal overlay ---- */
  .ox-modal-overlay {
    display: none; position: fixed; inset: 0;
    background: rgba(0,0,0,.5); z-index: 900;
    align-items: center; justify-content: center;
  }
  .ox-modal-overlay.open { display: flex; }
  .ox-modal-box {
    background: #fff; border-radius: 12px;
    max-width: 680px; width: 94%; max-height: 80vh;
    overflow-y: auto; padding: 28px 32px; position: relative;
  }
  .ox-modal-close {
    position: absolute; top: 14px; right: 18px;
    background: none; border: none; font-size: 1.4rem;
    cursor: pointer; line-height: 1;
  }
  .history-content table { width: 100%; border-collapse: collapse; font-size: .85rem; }
  .history-content th, .history-content td { padding: 8px 10px; border-bottom: 1px solid #eee; text-align: left; }
  .history-content thead tr { background: #1a1a2e; color: #fff; }

  /* ---- back + download bar ---- */
  .result-actions {
    display: flex; gap: 12px; flex-wrap: wrap;
    align-items: center; margin-bottom: 28px;
  }
  .btn-dl {
    background: var(--primary, #FC5F45); color: #fff;
    border: none; border-radius: 24px;
    padding: 10px 24px; font-weight: 700;
    cursor: pointer; font-size: .9rem;
  }
  .btn-dl:hover { opacity: .88; }
</style>
</head>
<body>

<header class="site-header">
  <div class="wrap nav">
    <a class="brand" href="../index.html" aria-label="Online Xpress home"><img src="https://res.cloudinary.com/drx1zsmeq/image/upload/v1782824098/online-xpress-logo_dr6gpu.png" alt="Online Xpress"></a>
    <nav class="nav-links" aria-label="Primary">
      <a href="../index.html">Home</a>
      <a href="../about.html">About Us</a>
      <a href="../products.html">Products</a>
      <a href="../features.html">Features</a>
      <a href="../pricing.html">Pricing</a>
      <a href="../tracking.html" class="active" aria-current="page">Tracking</a>
      <a href="../contact.html">Contact Us</a>
    </nav>
    <div class="nav-actions">
      <a class="btn-login" href="https://b2c.onlinexpress.co.in/#/auth/login" target="_blank" rel="noopener noreferrer"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 4-6 8-6s8 2 8 6"/></svg>Log In | Sign Up</a>
      <button class="hamburger" aria-label="Open menu" aria-controls="mobileMenu" aria-expanded="false"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M3 12h18M3 18h18"/></svg></button>
    </div>
  </div>
</header>
<div class="mobile-menu" id="mobileMenu">
  <div class="mobile-panel" role="dialog" aria-modal="true" aria-label="Menu">
    <div class="mm-head"><img src="https://res.cloudinary.com/drx1zsmeq/image/upload/v1782824098/online-xpress-logo_dr6gpu.png" alt="Online Xpress" style="height:36px"><button class="mm-close" aria-label="Close menu"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 6l12 12M18 6L6 18"/></svg></button></div>
    <a class="mm-link" href="../index.html">Home</a>
    <a class="mm-link" href="../about.html">About Us</a>
    <a class="mm-link" href="../products.html">Products</a>
    <a class="mm-link" href="../features.html">Features</a>
    <a class="mm-link" href="../pricing.html">Pricing</a>
    <a class="mm-link active" href="../tracking.html">Tracking</a>
    <a class="mm-link" href="../contact.html">Contact Us</a>
    <a class="btn-login" href="https://b2c.onlinexpress.co.in/#/auth/login" target="_blank" rel="noopener noreferrer"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 4-6 8-6s8 2 8 6"/></svg>Log In | Sign Up</a>
  </div>
</div>

<main>
<section class="section result-section">
  <span class="orb orb-g" style="width:120px;height:120px;top:4%;left:4%;opacity:.25"></span>
  <span class="orb orb-p" style="width:80px;height:80px;bottom:10%;right:8%;opacity:.25;animation-delay:-5s"></span>
  <div class="wrap">

<?php
libxml_use_internal_errors(true);
require_once '../admin/DAO/Controller.php';
require_once '../admin/DAO/sql.php';

$controller = new Controller();
$db = $controller->getDB();

$select = null;
$awbNumbers = null;
$isVendorOrder = false;

if (isset($_REQUEST['awb'])) {
    $input   = trim($_REQUEST['awb']);
    $numbers = preg_split('/[\s,]+/', $input, -1, PREG_SPLIT_NO_EMPTY);
    $awbNumbers = implode("','", $numbers);

    $qMarks = str_repeat('?,', count($numbers) - 1) . '?';
    $parameters = [];
    for ($i = 0; $i < count($numbers); $i++) {
        $parameters[$i + 1] = trim($numbers[$i]);
    }
    for ($i = 0; $i < count($numbers); $i++) {
        $parameters[count($numbers) + 1 + $i] = trim($numbers[$i]);
    }

    $select = $db->exec(
        "SELECT * FROM tbl_orders_compacted WHERE (awb IN ($qMarks) OR remrk IN ($qMarks)) AND status <> 'Booked'",
        $parameters
    );
}
?>

    <div class="result-actions">
      <a class="btn btn-outline" href="../tracking.html">← Track another order</a>
      <?php if ($select): ?>
      <button class="btn-dl" onclick="downloadResult()">Download Result</button>
      <?php endif; ?>
    </div>

    <?php if (!isset($_REQUEST['awb']) || empty(trim($_REQUEST['awb']))): ?>
      <p style="color:var(--muted)">No AWB number provided. <a href="../tracking.html">Go back</a> and enter one.</p>

    <?php elseif (!$select || count($select) === 0): ?>
      <div class="track-msg error">No shipment found for the entered AWB / reference number. Please check and <a href="../tracking.html">try again</a>.</div>

    <?php else: ?>

      <h2 class="h3" style="margin-bottom:8px">Search Results</h2>
      <p style="color:var(--muted);margin-bottom:0"><?php echo count($select); ?> shipment<?php echo count($select) !== 1 ? 's' : ''; ?> found.</p>

      <div class="result-table-wrap">
        <table class="result-table" id="resultTable">
          <thead>
            <tr>
              <th>Consignment No.</th>
              <th>Reference No.</th>
              <th>Booking Date</th>
              <th>Origin</th>
              <th>Destination</th>
              <th>Consignee</th>
              <th>Status</th>
              <th>Delivery Date</th>
              <th>Delivery Time</th>
              <th>Received By</th>
              <th>COD Amount</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($select as $row):
            /* NDR reason */
            $res = null;
            $chk_t = $db->exec("SELECT reason FROM tbl_ndreason WHERE id = ?", [1 => $row['ndr_id']]);
            foreach ($chk_t as $r) { $res = $r; }

            /* Destination */
            $res1 = null;
            $chk_t1 = $db->exec("SELECT destination FROM tbl_destination WHERE id = ?", [1 => $row['destination_id']]);
            foreach ($chk_t1 as $r) { $res1 = $r; }

            /* Origin */
            $res2 = null;
            $chk_t2 = $db->exec("SELECT destination FROM tbl_destination WHERE id = ?", [1 => $row['origin']]);
            foreach ($chk_t2 as $r) { $res2 = $r; }

            $awbNum = preg_replace('/\s+/', '', $row['awb']);
            $detailUrl = '//onlinexpress.co.in/tracking-history.php?awb=' . urlencode($awbNum);

            /* Status cell text */
            $statusText = htmlspecialchars($row['status']);
            if (!empty($res['reason'])) {
                $statusText .= ' — ' . htmlspecialchars($res['reason']);
                if (!empty($row['ndr_date'])) $statusText .= ' (' . htmlspecialchars($row['ndr_date']) . ')';
            }

            /* Received by */
            $receivedBy = '';
            if (!empty($row['cust_id_proof'])) {
                $pos = strripos($row['cust_id_proof'], '-');
                $receivedBy = $pos !== false
                    ? substr($row['cust_id_proof'], 0, $pos)
                    : $row['cust_id_proof'];
            }
          ?>
            <tr>
              <td><?php echo htmlspecialchars($row['awb']); ?></td>
              <td><?php echo htmlspecialchars($row['remrk']); ?></td>
              <td><?php echo htmlspecialchars($row['booking_date']); ?></td>
              <td><?php echo htmlspecialchars($res2['destination'] ?? '—'); ?></td>
              <td><?php echo htmlspecialchars($res1['destination'] ?? '—'); ?></td>
              <td><?php echo htmlspecialchars($row['dealer']); ?></td>
              <td>
                <?php echo $statusText; ?>
                <br><a href="#modal-<?php echo $awbNum; ?>"
                       class="detail-link"
                       data-remote="<?php echo $detailUrl; ?>">View Details</a>
              </td>
              <td><?php echo htmlspecialchars($row['delivery_date'] ?? ''); ?></td>
              <td><?php echo htmlspecialchars($row['delivery_time'] ?? ''); ?></td>
              <td><?php echo htmlspecialchars($receivedBy); ?></td>
              <td><?php echo htmlspecialchars($row['collectable_value'] ?? ''); ?></td>
            </tr>

            <!-- tracking history modal -->
            <div class="ox-modal-overlay" id="modal-<?php echo $awbNum; ?>">
              <div class="ox-modal-box">
                <button class="ox-modal-close" aria-label="Close">✕</button>
                <div class="history-content">Loading…</div>
              </div>
            </div>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div><!-- .result-table-wrap -->

    <?php endif; ?>

  </div><!-- .wrap -->
</section>
</main>

<footer class="site-footer">
  <div class="wrap footer-main">
    <div class="footer-brand">
      <span class="footer-chip"><img src="https://res.cloudinary.com/drx1zsmeq/image/upload/v1782836577/online-xpress-logo-white_h6scqh.png" alt="Online Xpress"></span>
      <p>Your one-stop multi-courier shipping platform — transparent pricing, real-time tracking, and early remittance.</p>
      <div class="socials">
        <a href="#" aria-label="LinkedIn"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M4.98 3.5a2.5 2.5 0 11-.02 5 2.5 2.5 0 01.02-5zM3 9h4v12H3zM9 9h3.8v1.7h.05c.53-1 1.83-2.05 3.77-2.05C20.5 8.65 22 10.6 22 14v7h-4v-6.2c0-1.48-.03-3.38-2.06-3.38-2.06 0-2.38 1.6-2.38 3.27V21H9z"/></svg></a>
        <a href="#" aria-label="Instagram"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor"/></svg></a>
        <a href="#" aria-label="Facebook"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M14 9h3V5h-3c-2.2 0-4 1.8-4 4v2H7v4h3v8h4v-8h3l1-4h-4V9c0-.6.4-1 1-1z"/></svg></a>
        <a href="#" aria-label="X"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M17.5 3h3l-7 8 8.2 10h-6.4l-5-6-5.7 6H1.5l7.5-8.5L1 3h6.6l4.5 5.5zM16 19h1.7L8 5H6.2z"/></svg></a>
      </div>
    </div>
    <div class="footer-col"><h4>Company</h4><ul><li><a href="../index.html">Home</a></li><li><a href="../about.html">About Us</a></li><li><a href="../products.html">Products</a></li><li><a href="../features.html">Features</a></li></ul></div>
    <div class="footer-col"><h4>Support</h4><ul><li><a href="../pricing.html">Pricing</a></li><li><a href="../tracking.html">Tracking</a></li><li><a href="../contact.html">Contact Us</a></li><li><a href="../contact.html#faq">FAQ</a></li></ul></div>
    <div class="footer-col"><h4>Get in Touch</h4><ul class="footer-contact">
      <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 21s-7-6-7-11a7 7 0 0114 0c0 5-7 11-7 11z"/><circle cx="12" cy="10" r="2.5"/></svg>D-47, Okhla Phase I, Okhla Industrial Area, New Delhi</li>
      <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.9v3a2 2 0 01-2.2 2 19.8 19.8 0 01-8.6-3 19.5 19.5 0 01-6-6 19.8 19.8 0 01-3-8.6A2 2 0 014.1 2h3a2 2 0 012 1.7c.1.9.3 1.8.6 2.6a2 2 0 01-.5 2.1L8 9.6a16 16 0 006 6l1.2-1.2a2 2 0 012.1-.5c.8.3 1.7.5 2.6.6a2 2 0 011.7 2z"/></svg>+91-11-4155-343</li>
      <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M2 7l10 6 10-6"/></svg>sales@onlinexpress.co.in</li>
    </ul></div>
  </div>
  <div class="footer-bottom">© <span data-year>2025</span> Online Xpress. All rights reserved. Designed &amp; Developed by <b>Assam Digital</b>.</div>
</footer>

<a class="wa-float" data-wa href="#" aria-label="Speak with us on WhatsApp">
  <svg viewBox="0 0 24 24" fill="currentColor"><path d="M.5 23.5l1.6-5.9A11.4 11.4 0 011 12 11.4 11.4 0 0112.5.6 11.4 11.4 0 0124 12 11.4 11.4 0 0112.5 23.4a11.5 11.5 0 01-5.5-1.4l-6 1.5zm6.3-3.6l.4.2a9.5 9.5 0 005.3 1.5 9.5 9.5 0 100-19 9.5 9.5 0 00-8 14.6l.3.4-.9 3.3 3.6-.9zm10.6-5.1c-.1-.2-.5-.4-1-.6s-1.6-.8-1.8-.9-.4-.1-.6.1-.7.9-.8 1-.3.2-.5.1a7.7 7.7 0 01-2.3-1.4 8.6 8.6 0 01-1.6-2c-.2-.3 0-.4.1-.6l.4-.5.3-.4v-.5l-.8-2c-.2-.5-.4-.4-.6-.4h-.5a1 1 0 00-.7.3 3 3 0 00-1 2.3 5.3 5.3 0 001.1 2.8 12 12 0 004.6 4.1c.6.3 1.1.4 1.5.6.6.2 1.2.2 1.6.1.5-.1 1.6-.6 1.8-1.3s.2-1.1.2-1.2z"/></svg>
  <span>Speak with us</span>
</a>

<script src="../js/main.js"></script>
<script>
/* ---- download result ---- */
function downloadResult() {
  var form = document.createElement('form');
  form.method = 'post';
  form.action = '//onlinexpress.co.in/php/resultDownload.php';
  form.target = 'view';
  var field = document.createElement('input');
  field.type = 'hidden';
  field.name = 'awb';
  var awbs = '';
  document.querySelectorAll('#resultTable tbody tr td:first-child').forEach(function (td) {
    awbs += td.textContent.trim() + ' ';
  });
  field.value = awbs.trim();
  form.appendChild(field);
  document.body.appendChild(form);
  window.open('', 'view');
  form.submit();
}

/* ---- tracking history modals ---- */
document.querySelectorAll('.detail-link').forEach(function (link) {
  link.addEventListener('click', function (e) {
    e.preventDefault();
    var modalId = this.getAttribute('href').replace('#', '');
    var overlay = document.getElementById(modalId);
    if (!overlay) return;
    var content = overlay.querySelector('.history-content');
    overlay.classList.add('open');
    if (content.dataset.loaded) return;
    fetch(this.dataset.remote)
      .then(function (r) { return r.text(); })
      .then(function (html) { content.innerHTML = html; content.dataset.loaded = '1'; })
      .catch(function () { content.innerHTML = '<p>Could not load tracking history.</p>'; });
  });
});

document.querySelectorAll('.ox-modal-overlay').forEach(function (overlay) {
  overlay.addEventListener('click', function (e) {
    if (e.target === overlay || e.target.classList.contains('ox-modal-close')) {
      overlay.classList.remove('open');
    }
  });
});
</script>
</body>
</html>
