<?php
require_once '/home/djaloza/config.php';
$host = DB_HOST;
$db   = "michael_iep";
$user = DB_USER;
$pass = DB_PASS;

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("DB connection failed");
}

$type     = isset($_GET['type'])     ? $_GET['type']     : 'all';
$goalCode = isset($_GET['goalCode']) ? $_GET['goalCode'] : '';

$label = $type === 'goal' && $goalCode ? $goalCode : '2026-2027';
$filename = "michael_iep_" . $label . "_" . date("Y-m-d") . ".csv";
header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=\"$filename\"");

$out = fopen("php://output", "w");

// Check table exists
try {
    $pdo->query("SELECT 1 FROM iep_2027_responses LIMIT 1");
} catch (PDOException $e) {
    fputcsv($out, ["ERROR: iep_2027_responses table not found. Run setup_2027_tables.sql first."]);
    fclose($out);
    exit;
}

fputcsv($out, ["ID", "Date", "Time", "Goal Code", "Sub Type", "Question", "Answer Given", "Correct", "Response Time (sec)", "Session ID"]);

$sql = "SELECT id, date, time, goal_code, sub_type, question, answer_given, correct, response_time_sec, session_id FROM iep_2027_responses WHERE 1=1";
if ($type === 'goal' && $goalCode) {
    $stmt = $pdo->prepare("SELECT id, date, time, goal_code, sub_type, question, answer_given, correct, response_time_sec, session_id FROM iep_2027_responses WHERE goal_code = ? ORDER BY created_at ASC");
    $stmt->execute([$goalCode]);
} else {
    $stmt = $pdo->query("SELECT id, date, time, goal_code, sub_type, question, answer_given, correct, response_time_sec, session_id FROM iep_2027_responses ORDER BY created_at ASC");
}

$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($rows as $row) {
    $row['correct'] = $row['correct'] ? 'YES' : 'NO';
    fputcsv($out, array_values($row));
}

fclose($out);
?>
