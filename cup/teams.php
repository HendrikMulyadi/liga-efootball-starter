<?php
require_once '../config.php';

// Tambah tim baru
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['team_name'])) {
    $team_name = trim($_POST['team_name']);
    if ($team_name !== '') {
        $stmt = $pdo->prepare("INSERT INTO cup_teams (name) VALUES (?)");
        $stmt->execute([$team_name]);
    }
    header("Location: teams.php");
    exit;
}

// Hapus tim
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM cup_teams WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: teams.php");
    exit;
}

// Ambil semua tim
$teams = $pdo->query("SELECT * FROM cup_teams ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Kelola Tim | PDK Cup</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
  background: url('../assets/img/stadion.png') no-repeat center center fixed;
  background-size: cover;
  font-family: 'Poppins', sans-serif;
  color: white;
  padding: 40px;
}

.container {
  background: rgba(0,0,0,0.75);
  padding: 40px;
  border-radius: 15px;
  box-shadow: 0 0 20px rgba(255,255,255,0.2);
}

h1 {
  color: #ffcc00;
  text-align: center;
  margin-bottom: 30px;
  font-weight: 700;
}

.table {
  color: white;
  text-align: center;
}

.btn-danger {
  background-color: #ff4444;
  border: none;
}

.btn-warning {
  background-color: #ffcc00;
  color: black;
  border: none;
  font-weight: bold;
}

.btn-primary {
  background: linear-gradient(90deg, #00ffff, #0077ff);
  border: none;
  color: black;
  font-weight: 600;
}

footer {
  text-align: center;
  margin-top: 40px;
  color: rgba(255,255,255,0.7);
}
</style>
</head>
<body>
<div class="container">
  <h1>⚙️ Kelola Tim - PDK Cup</h1>

  <form method="POST" class="d-flex justify-content-center mb-4">
    <input type="text" name="team_name" class="form-control w-50 me-3" placeholder="Nama Tim Baru" required>
    <button type="submit" class="btn btn-primary">➕ Tambah</button>
  </form>

  <?php if (count($teams) > 0): ?>
  <table class="table table-bordered table-dark">
    <thead>
      <tr>
        <th>#</th>
        <th>Nama Tim</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php $no=1; foreach ($teams as $t): ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= htmlspecialchars($t['name']) ?></td>
        <td>
          <a href="?delete=<?= $t['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus tim ini?')">Hapus</a>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <div class="text-center mt-4">
    <a href="generate_bracket.php" class="btn btn-warning btn-lg">🏁 Buat Jadwal Turnamen</a>
  </div>

  <?php else: ?>
    <p class="text-center">Belum ada tim yang didaftarkan.</p>
  <?php endif; ?>

  <div class="text-center mt-4">
    <a href="../index.php" class="btn btn-outline-light">⬅ Kembali ke Menu Utama</a>
  </div>
</div>

<footer>© 2025 Babang HM | Mode Cup System</footer>
</body>
</html>
