<?php
/*
 * track-api.php — JSON tracking endpoint
 * Accepts: GET/POST ?awb=<single AWB or reference number>
 * Returns: JSON matching the shape expected by js/tracking.js
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

libxml_use_internal_errors(true);
require_once '../admin/DAO/Controller.php';
require_once '../admin/DAO/sql.php';

/* ---- helpers ---- */
function jsonError($awb, $notFound = false) {
    if ($notFound) {
        echo json_encode(['awb' => $awb, 'notFound' => true]);
    } else {
        echo json_encode(['awb' => $awb, 'error' => true]);
    }
    exit;
}

/* ---- input ---- */
$awb = isset($_REQUEST['awb']) ? trim($_REQUEST['awb']) : '';
if ($awb === '') {
    http_response_code(400);
    echo json_encode(['error' => 'awb parameter is required']);
    exit;
}

try {
    $controller = new Controller();
    $db = $controller->getDB();
} catch (Exception $e) {
    jsonError($awb);
}

/* ---- fetch order ---- */
$select = $db->exec(
    "SELECT * FROM tbl_orders_compacted WHERE (awb = ? OR remrk = ?) AND status <> 'Booked' LIMIT 1",
    [1 => $awb, 2 => $awb]
);

$row = null;
foreach ($select as $r) { $row = $r; }

if (!$row) {
    jsonError($awb, true);
}

/* ---- destination / origin labels ---- */
$res1 = null;
$destRows = $db->exec("SELECT destination FROM tbl_destination WHERE id = ?", [1 => $row['destination_id']]);
foreach ($destRows as $d) { $res1 = $d['destination']; }

$res2 = null;
$origRows = $db->exec("SELECT destination FROM tbl_destination WHERE id = ?", [1 => $row['origin']]);
foreach ($origRows as $d) { $res2 = $d['destination']; }

/* ---- NDR reason ---- */
$ndrReason = '';
if (!empty($row['ndr_id'])) {
    $ndrRows = $db->exec("SELECT reason FROM tbl_ndreason WHERE id = ?", [1 => $row['ndr_id']]);
    foreach ($ndrRows as $n) { $ndrReason = $n['reason']; }
}

/* ---- tracking history events ---- */
$events = [];
$histRows = $db->exec(
    "SELECT * FROM tbl_trackinghistory WHERE awb = ? AND showstatus = 'Y' ORDER BY update_time ASC",
    [1 => $row['awb']]
);
foreach ($histRows as $h) {
    $ts = $h['update_time'];
    // normalise timestamp to ISO-8601 if it's a MySQL datetime string
    if ($ts && !preg_match('/T/', $ts)) {
        $ts = date('c', strtotime($ts));
    }
    $events[] = [
        'status'      => $h['status'] ?? '',
        'description' => $h['remarks'] ?? ($h['description'] ?? ''),
        'location'    => $h['location'] ?? '',
        'timestamp'   => $ts,
    ];
}

/* ---- synthesise a status string ---- */
$status = $row['status'];
if ($status === 'NDR' && !empty($ndrReason)) {
    $status = 'NDR - ' . $ndrReason;
}

/* ---- courier label (vendor_id → name mapping) ---- */
$courierMap = [
    1 => 'Online Xpress',
    2 => 'Xpressbees',
    3 => 'Delhivery',
    4 => 'Blue Dart',
    5 => 'Ecom Express',
];
$courier = $courierMap[$row['vendor_id'] ?? 0] ?? 'Online Xpress';

/* ---- expected delivery ---- */
$expectedDelivery = null;
if (!empty($row['expected_date'])) {
    $expectedDelivery = date('c', strtotime($row['expected_date']));
} elseif (!empty($row['delivery_date'])) {
    $expectedDelivery = date('c', strtotime($row['delivery_date']));
}

/* ---- last update timestamp ---- */
$lastUpdate = null;
if (!empty($events)) {
    $lastUpdate = $events[count($events) - 1]['timestamp'];
} elseif (!empty($row['updated_at'])) {
    $lastUpdate = date('c', strtotime($row['updated_at']));
} elseif (!empty($row['booking_date'])) {
    $lastUpdate = date('c', strtotime($row['booking_date']));
}

/* ---- response ---- */
echo json_encode([
    'awb'              => $row['awb'],
    'reference'        => $row['remrk'],
    'courier'          => $courier,
    'status'           => $row['status'],
    'origin'           => $res2,
    'destination'      => $res1,
    'bookingDate'      => $row['booking_date'],
    'deliveryDate'     => $row['delivery_date'] ?? null,
    'deliveryTime'     => $row['delivery_time'] ?? null,
    'expectedDelivery' => $expectedDelivery,
    'lastUpdate'       => $lastUpdate,
    'consignee'        => $row['dealer'] ?? null,
    'codAmount'        => $row['collectable_value'] ?? null,
    'ndrReason'        => $ndrReason ?: null,
    'ndrDate'          => $row['ndr_date'] ?? null,
    'events'           => $events,
]);
