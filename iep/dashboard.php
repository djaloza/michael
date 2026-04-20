<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Michael's IEP Dashboard</title>
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700;800;900&display=swap" rel="stylesheet">
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  body { font-family: 'Nunito', sans-serif; background: #F0F4FF; color: #2D2D2D; }
  .header { background: #5B8DEF; color: white; padding: 28px 40px; display: flex; align-items: center; justify-content: space-between; }
  .header h1 { font-size: 28px; font-weight: 900; }
  .header p { font-size: 15px; opacity: 0.85; margin-top: 4px; }
  .export-bar { background: white; padding: 16px 40px; border-bottom: 2px solid #E8EEF8; display: flex; gap: 12px; align-items: center; flex-wrap: wrap; }
  .export-bar label { font-size: 14px; font-weight: 700; color: #6B7280; }
  .export-bar input { border: 2px solid #DDE3F0; border-radius: 8px; padding: 6px 12px; font-family: 'Nunito', sans-serif; font-size: 14px; }
  .btn { font-family: 'Nunito', sans-serif; font-size: 14px; font-weight: 800; padding: 8px 20px; border-radius: 20px; border: none; cursor: pointer; color: white; text-decoration: none; display: inline-block; }
  .btn-blue { background: #5B8DEF; }
  .btn-green { background: #06D6A0; }
  .btn-orange { background: #FF9F1C; }
  .btn-red { background: #EF476F; }
  .btn-red:hover { background: #d63a5f; }
  .content { max-width: 1100px; margin: 0 auto; padding: 32px 24px; }
  .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 32px; }
  .stat-card { background: white; border-radius: 20px; padding: 24px; border: 3px solid #E8EEF8; }
  .stat-card .label { font-size: 13px; font-weight: 800; color: #9CA3AF; letter-spacing: 0.5px; margin-bottom: 8px; }
  .stat-card .value { font-size: 42px; font-weight: 900; color: #5B8DEF; }
  .stat-card .sub { font-size: 14px; color: #6B7280; margin-top: 4px; }
  .section { background: white; border-radius: 20px; padding: 28px; border: 3px solid #E8EEF8; margin-bottom: 24px; }
  .section h2 { font-size: 20px; font-weight: 900; color: #2D2D2D; margin-bottom: 20px; }
  table { width: 100%; border-collapse: collapse; font-size: 14px; }
  th { background: #F7F9FF; font-weight: 800; padding: 12px 14px; text-align: left; color: #6B7280; border-bottom: 2px solid #E8EEF8; }
  td { padding: 11px 14px; border-bottom: 1px solid #F1F5F9; }
  tr:last-child td { border-bottom: none; }
  .badge { display: inline-block; padding: 3px 12px; border-radius: 12px; font-size: 12px; font-weight: 800; }
  .badge-yes { background: #ECFDF5; color: #065F46; }
  .badge-no  { background: #FFF1F2; color: #9F1239; }
  .badge-WHO    { background: #EEF2FF; color: #4338CA; }
  .badge-WHAT   { background: #FEF3C7; color: #92400E; }
  .badge-WHEN   { background: #ECFDF5; color: #065F46; }
  .badge-WHERE  { background: #FFF1F2; color: #9F1239; }
  .badge-HOW    { background: #F5F3FF; color: #5B21B6; }
  .badge-LENGTH   { background: #EEF2FF; color: #4338CA; }
  .badge-WIDTH    { background: #FEF3C7; color: #92400E; }
  .badge-CAPACITY { background: #ECFDF5; color: #065F46; }
  .progress-row { display: flex; align-items: center; gap: 14px; margin-bottom: 14px; }
  .progress-label { width: 80px; font-size: 14px; font-weight: 800; }
  .progress-bg { flex: 1; height: 22px; background: #F1F5F9; border-radius: 11px; overflow: hidden; }
  .progress-fill { height: 100%; border-radius: 11px; transition: width 1s; }
  .progress-pct { width: 50px; text-align: right; font-size: 15px; font-weight: 900; }
  .goal-line { border-top: 2px dashed #EF476F; position: relative; }
  .tabs { display: flex; gap: 8px; margin-bottom: 24px; }
  .tab { padding: 10px 24px; border-radius: 20px; font-size: 15px; font-weight: 800; cursor: pointer; border: 2px solid #DDE3F0; background: white; color: #6B7280; }
  .tab.active { background: #5B8DEF; color: white; border-color: #5B8DEF; }
  .iep-goal { background: #FFF8F0; border: 2px solid #FFD166; border-radius: 12px; padding: 14px 18px; margin-bottom: 12px; display: flex; align-items: center; justify-content: space-between; }
  .iep-goal .goal-text { font-size: 15px; font-weight: 700; }
  .iep-goal .goal-pct { font-size: 22px; font-weight: 900; color: #5B8DEF; }
  .iep-target { font-size: 12px; color: #9CA3AF; margin-top: 2px; }
</style>
</head>
<body>
<?php
$host = "localhost";
$db   = "michael_iep";
$user = "hubuser";
$pass = "@2R0land0f3ld";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("<p style='padding:40px;color:red;font-family:sans-serif;'>DB connection failed: " . $e->getMessage() . "</p>");
}

// ---- Story stats ----
$totalStory   = $pdo->query("SELECT COUNT(*) FROM story_responses")->fetchColumn();
$correctStory = $pdo->query("SELECT COUNT(*) FROM story_responses WHERE correct=1")->fetchColumn();
$storyPct     = $totalStory > 0 ? round(($correctStory / $totalStory) * 100) : 0;
$sessions     = $pdo->query("SELECT COUNT(DISTINCT session_id) FROM story_responses")->fetchColumn();

// Story accuracy by question type
$byType = $pdo->query("SELECT question_type, COUNT(*) as total, SUM(correct) as correct FROM story_responses GROUP BY question_type ORDER BY question_type")->fetchAll(PDO::FETCH_ASSOC);

// ---- Math stats ----
$totalMath   = $pdo->query("SELECT COUNT(*) FROM math_responses")->fetchColumn();
$correctMath = $pdo->query("SELECT COUNT(*) FROM math_responses WHERE correct=1")->fetchColumn();
$mathPct     = $totalMath > 0 ? round(($correctMath / $totalMath) * 100) : 0;

// Math accuracy by category
$byCategory = $pdo->query("SELECT category, COUNT(*) as total, SUM(correct) as correct FROM math_responses GROUP BY category ORDER BY category")->fetchAll(PDO::FETCH_ASSOC);

// Recent story responses
$recentStory = $pdo->query("SELECT date, time, story, question_type, question, answer_given, correct, response_time_sec FROM story_responses ORDER BY created_at DESC LIMIT 20")->fetchAll(PDO::FETCH_ASSOC);

// Recent math responses
$recentMath = $pdo->query("SELECT date, time, category, question, answer_given, correct, response_time_sec FROM math_responses ORDER BY created_at DESC LIMIT 20")->fetchAll(PDO::FETCH_ASSOC);

// Weekly trend (last 4 weeks story)
$weeklyStory = $pdo->query("
    SELECT WEEK(created_at) as wk, YEAR(created_at) as yr,
           COUNT(*) as total, SUM(correct) as correct
    FROM story_responses
    GROUP BY YEAR(created_at), WEEK(created_at)
    ORDER BY yr DESC, wk DESC
    LIMIT 4
")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="header">
  <div>
    <h1>📊 Michael's IEP Dashboard</h1>
    <p>Real-time progress tracking · Generated <?= date("F j, Y g:i A") ?></p>
  </div>
  <a href="https://jaloza.com/michael/" style="color:white;font-family:'Nunito',sans-serif;font-size:14px;font-weight:800;text-decoration:none;opacity:0.85;">← Home</a>
</div>

<div class="export-bar">
  <label>Export date range:</label>
  <input type="date" id="fromDate">
  <span style="color:#9CA3AF">to</span>
  <input type="date" id="toDate">
  <a class="btn btn-green" id="exportStory" href="#">⬇ Export Story Data</a>
  <a class="btn btn-blue"  id="exportMath"  href="#">⬇ Export Math Data</a>
  <a class="btn btn-orange" onclick="window.print()">🖨 Print Report</a>
  <span style="margin-left:auto;display:flex;gap:8px;align-items:center;">
    <button class="btn btn-red" onclick="clearData('test')">🧪 Clear Test Data</button>
    <button class="btn btn-red" onclick="clearData('all')" style="opacity:0.75;">⚠️ Clear All Data</button>
  </span>
</div>

<div class="content">

  <!-- IEP Goal Summary -->
  <div class="section">
    <h2>🎯 IEP Goal Progress</h2>
    <div class="iep-goal">
      <div>
        <div class="goal-text">SAI #2 — Story Comprehension (WHO/WHAT/WHEN/WHERE/HOW)</div>
        <div class="iep-target">Target: 80% accuracy · Baseline: ~60%</div>
      </div>
      <div class="goal-pct"><?= $storyPct ?>%</div>
    </div>
    <div class="iep-goal">
      <div>
        <div class="goal-text">SAI #1 — Math Comparisons (Length / Width / Capacity)</div>
        <div class="iep-target">Target: 80% accuracy · Baseline: 50%</div>
      </div>
      <div class="goal-pct"><?= $mathPct ?>%</div>
    </div>
  </div>

  <!-- Summary Stats -->
  <div class="grid">
    <div class="stat-card">
      <div class="label">STORY ACCURACY</div>
      <div class="value"><?= $storyPct ?>%</div>
      <div class="sub"><?= $correctStory ?> correct of <?= $totalStory ?> answered</div>
    </div>
    <div class="stat-card">
      <div class="label">MATH ACCURACY</div>
      <div class="value"><?= $mathPct ?>%</div>
      <div class="sub"><?= $correctMath ?> correct of <?= $totalMath ?> answered</div>
    </div>
    <div class="stat-card">
      <div class="label">TOTAL SESSIONS</div>
      <div class="value"><?= $sessions ?></div>
      <div class="sub">story sessions logged</div>
    </div>
    <div class="stat-card">
      <div class="label">IEP TARGET</div>
      <div class="value">80%</div>
      <div class="sub"><?= max(0, 80 - $storyPct) ?>% to go on story goal</div>
    </div>
  </div>

  <!-- Story accuracy by question type -->
  <div class="section">
    <h2>📖 Story Comprehension — Accuracy by Question Type</h2>
    <?php if (empty($byType)): ?>
      <p style="color:#9CA3AF">No story data yet.</p>
    <?php else: ?>
      <?php foreach ($byType as $row):
        $pct = $row['total'] > 0 ? round(($row['correct'] / $row['total']) * 100) : 0;
        $color = $pct >= 80 ? '#06D6A0' : ($pct >= 60 ? '#FFD166' : '#EF476F');
      ?>
      <div class="progress-row">
        <div class="progress-label"><span class="badge badge-<?= $row['question_type'] ?>"><?= $row['question_type'] ?></span></div>
        <div class="progress-bg"><div class="progress-fill" style="width:<?= $pct ?>%;background:<?= $color ?>;"></div></div>
        <div class="progress-pct" style="color:<?= $color ?>"><?= $pct ?>%</div>
        <div style="font-size:13px;color:#9CA3AF;width:80px;"><?= $row['correct'] ?>/<?= $row['total'] ?></div>
      </div>
      <?php endforeach; ?>
      <div style="font-size:13px;color:#9CA3AF;margin-top:12px;">🟢 = at/above goal (80%) &nbsp; 🟡 = getting close &nbsp; 🔴 = needs focus</div>
    <?php endif; ?>
  </div>

  <!-- Math accuracy by category -->
  <div class="section">
    <h2>📐 Math Comparisons — Accuracy by Category</h2>
    <?php if (empty($byCategory)): ?>
      <p style="color:#9CA3AF">No math data yet.</p>
    <?php else: ?>
      <?php foreach ($byCategory as $row):
        $pct = $row['total'] > 0 ? round(($row['correct'] / $row['total']) * 100) : 0;
        $color = $pct >= 80 ? '#06D6A0' : ($pct >= 60 ? '#FFD166' : '#EF476F');
      ?>
      <div class="progress-row">
        <div class="progress-label"><span class="badge badge-<?= $row['category'] ?>"><?= $row['category'] ?></span></div>
        <div class="progress-bg"><div class="progress-fill" style="width:<?= $pct ?>%;background:<?= $color ?>;"></div></div>
        <div class="progress-pct" style="color:<?= $color ?>"><?= $pct ?>%</div>
        <div style="font-size:13px;color:#9CA3AF;width:80px;"><?= $row['correct'] ?>/<?= $row['total'] ?></div>
      </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>

  <!-- Weekly trend -->
  <?php if (!empty($weeklyStory)): ?>
  <div class="section">
    <h2>📈 Weekly Story Trend (last 4 weeks)</h2>
    <table>
      <tr><th>Week</th><th>Questions Answered</th><th>Correct</th><th>Accuracy</th></tr>
      <?php foreach (array_reverse($weeklyStory) as $w):
        $pct = $w['total'] > 0 ? round(($w['correct'] / $w['total']) * 100) : 0;
        $color = $pct >= 80 ? '#06D6A0' : ($pct >= 60 ? '#FFD166' : '#EF476F');
      ?>
      <tr>
        <td>Week <?= $w['wk'] ?>, <?= $w['yr'] ?></td>
        <td><?= $w['total'] ?></td>
        <td><?= $w['correct'] ?></td>
        <td><strong style="color:<?= $color ?>"><?= $pct ?>%</strong></td>
      </tr>
      <?php endforeach; ?>
    </table>
  </div>
  <?php endif; ?>

  <!-- Recent story responses -->
  <div class="section">
    <h2>📋 Recent Story Responses</h2>
    <?php if (empty($recentStory)): ?>
      <p style="color:#9CA3AF">No story data yet.</p>
    <?php else: ?>
    <table>
      <tr><th>Date</th><th>Story</th><th>Type</th><th>Question</th><th>Answer Given</th><th>Correct</th><th>Time (sec)</th></tr>
      <?php foreach ($recentStory as $r): ?>
      <tr>
        <td><?= htmlspecialchars($r['date']) ?> <?= htmlspecialchars($r['time']) ?></td>
        <td><?= htmlspecialchars($r['story']) ?></td>
        <td><span class="badge badge-<?= $r['question_type'] ?>"><?= $r['question_type'] ?></span></td>
        <td><?= htmlspecialchars($r['question']) ?></td>
        <td><?= htmlspecialchars($r['answer_given']) ?></td>
        <td><span class="badge <?= $r['correct'] ? 'badge-yes' : 'badge-no' ?>"><?= $r['correct'] ? 'YES' : 'NO' ?></span></td>
        <td><?= $r['response_time_sec'] ?></td>
      </tr>
      <?php endforeach; ?>
    </table>
    <?php endif; ?>
  </div>

  <!-- Recent math responses -->
  <div class="section">
    <h2>📋 Recent Math Responses</h2>
    <?php if (empty($recentMath)): ?>
      <p style="color:#9CA3AF">No math data yet.</p>
    <?php else: ?>
    <table>
      <tr><th>Date</th><th>Category</th><th>Question</th><th>Answer Given</th><th>Correct</th><th>Time (sec)</th></tr>
      <?php foreach ($recentMath as $r): ?>
      <tr>
        <td><?= htmlspecialchars($r['date']) ?> <?= htmlspecialchars($r['time']) ?></td>
        <td><span class="badge badge-<?= $r['category'] ?>"><?= $r['category'] ?></span></td>
        <td><?= htmlspecialchars($r['question']) ?></td>
        <td><?= htmlspecialchars($r['answer_given']) ?></td>
        <td><span class="badge <?= $r['correct'] ? 'badge-yes' : 'badge-no' ?>"><?= $r['correct'] ? 'YES' : 'NO' ?></span></td>
        <td><?= $r['response_time_sec'] ?></td>
      </tr>
      <?php endforeach; ?>
    </table>
    <?php endif; ?>
  </div>

</div>

<script>
function buildExportUrl(type) {
  const from = document.getElementById('fromDate').value;
  const to   = document.getElementById('toDate').value;
  let url = `export.php?type=${type}`;
  if (from) url += `&from=${from}`;
  if (to)   url += `&to=${to}`;
  return url;
}
document.getElementById('exportStory').addEventListener('click', function(e) {
  e.preventDefault();
  window.location.href = buildExportUrl('story');
});
document.getElementById('exportMath').addEventListener('click', function(e) {
  e.preventDefault();
  window.location.href = buildExportUrl('math');
});

async function clearData(scope) {
  const label = scope === 'test' ? 'test data' : 'ALL data (this cannot be undone)';
  if (!confirm('Are you sure you want to delete ' + label + '?')) return;
  if (scope === 'all' && !confirm('Second confirmation: permanently delete ALL story and math responses?')) return;

  const resp = await fetch('log.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/json'},
    body: JSON.stringify({action: 'clear', scope: scope, dataset: 'all'})
  });
  const data = await resp.json();
  if (data.status === 'ok') {
    alert((scope === 'test' ? 'Test data' : 'All data') + ' cleared.');
    location.reload();
  } else {
    alert('Error: ' + (data.message || 'unknown'));
  }
}
</script>
</body>
</html>
