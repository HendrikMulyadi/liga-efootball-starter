<?php
require_once '../config.php';

// Ambil semua pertandingan urut per round
$matches = $pdo->query("
    SELECT m.*, 
    th.name AS home_name, 
    ta.name AS away_name
    FROM cup_matches m
    LEFT JOIN cup_teams th ON m.team_home_id = th.id
    LEFT JOIN cup_teams ta ON m.team_away_id = ta.id
    ORDER BY m.round, m.id
")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Bagan PDK Cup</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
  background: #101010;
  color: white;
  font-family: 'Poppins', sans-serif;
  padding: 30px;
}
h1 { text-align: center; color: #ffcc00; margin-bottom: 40px; }
.round { margin-bottom: 50px; }
.match { background: rgba(255,255,255,0.1); border-radius: 10px; padding: 15px; margin: 10px 0; }
</style>
</head>
<body>
<h1>🏆 Bagan Turnamen PDK Cup</h1>

<?php
$rounds = [];
foreach ($matches as $m) $rounds[$m['round']][] = $m;

foreach ($rounds as $round => $games):
?>
<div class="round">
  <h3>🌀 Round <?= $round ?></h3>
  <?php foreach ($games as $g): ?>
    <div class="match">
      <strong><?= htmlspecialchars($g['home_name']) ?></strong>
      vs
      <strong><?= htmlspecialchars($g['away_name']) ?></strong><br>

      <?php if ($g['score_home'] === null || $g['score_away'] === null): ?>
        <form method="post" action="update_score.php" class="mt-2">
          <input type="hidden" name="match_id" value="<?= $g['id'] ?>">
          <input type="number" name="score_home" placeholder="Home" style="width:70px" required>
          <input type="number" name="score_away" placeholder="Away" style="width:70px" required>
          <button class="btn btn-warning btn-sm">💾 Simpan</button>
        </form>
      <?php else: ?>
        <p class="mt-2">Skor: <strong><?= $g['score_home'] ?></strong> - <strong><?= $g['score_away'] ?></strong></p>
        <p>Pemenang: 
          <span class="text-success fw-bold">
            <?php
              if ($g['winner_id'] == $g['team_home_id']) echo $g['home_name'];
              else echo $g['away_name'];
            ?>
          </span>
        </p>
      <?php endif; ?>
    </div>
  <?php endforeach; ?>
</div>
<?php endforeach; ?>

<a href="generate_bracket.php" class="btn btn-outline-warning mt-4">🔄 Buat Ulang Bagan</a>

</body>
</html>
