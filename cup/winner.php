<?php
require_once '../config.php';

// Ambil juara dari tabel
$winner = $pdo->query("
    SELECT t.name
    FROM cup_winner w 
    JOIN cup_teams t ON w.team_id = t.id
    ORDER BY w.id DESC LIMIT 1
")->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>🏆 Juara PDK CUP 2025</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
  background: radial-gradient(circle at center, #000000, #111111, #000);
  color: #ffcc00;
  font-family: 'Poppins', sans-serif;
  text-align: center;
  height: 100vh;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  overflow: hidden;
}
.trophy {
  font-size: 8rem;
  animation: glow 2s infinite alternate;
}
@keyframes glow {
  from { text-shadow: 0 0 20px #ffcc00; }
  to { text-shadow: 0 0 50px #ffaa00, 0 0 80px #ff8800; }
}
.champion {
  font-size: 3rem;
  font-weight: 800;
  text-shadow: 0 0 20px #ff8800;
  margin-top: 20px;
}
.team-logo {
  width: 150px;
  height: 150px;
  border-radius: 50%;
  margin-top: 20px;
  box-shadow: 0 0 25px #ffcc00;
}
.btn-back {
  margin-top: 40px;
  background: #ffcc00;
  color: black;
  border: none;
  border-radius: 10px;
  padding: 10px 20px;
  font-size: 1.2rem;
}
</style>
</head>
<body>
  <div class="trophy">🏆</div>
  <div class="champion">SELAMAT JUARA!</div>
  <?php if ($winner): ?>
    <h1 class="mt-4"><?= htmlspecialchars($winner['name']) ?></h1>
  <?php else: ?>
    <p>Belum ada juara ditentukan.</p>
  <?php endif; ?>
  <a href="index.php" class="btn btn-back">🏁 Kembali ke Menu</a>
</body>
</html>
