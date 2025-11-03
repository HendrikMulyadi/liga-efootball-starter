<?php
// teams.php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    if ($name !== '') {
        $stmt = $pdo->prepare("INSERT INTO teams (name) VALUES (?)");
        $stmt->execute([$name]);
        header("Location: teams.php");
        exit;
    }
}
$teams = $pdo->query("SELECT * FROM teams ORDER BY id")->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Kelola Tim - Liga eFootball</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #141E30, #243B55);
      font-family: 'Poppins', sans-serif;
      color: white;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .container {
      background: rgba(255, 255, 255, 0.08);
      backdrop-filter: blur(10px);
      border-radius: 20px;
      padding: 40px;
      max-width: 900px;
      box-shadow: 0 0 30px rgba(0, 255, 255, 0.2);
    }

    h1 {
      text-align: center;
      font-weight: 700;
      margin-bottom: 25px;
      color: #00ffff;
      text-shadow: 0 0 15px rgba(0, 255, 255, 0.6);
      letter-spacing: 1px;
    }

    form input {
      border-radius: 25px;
      border: none;
      padding: 10px 20px;
    }

    form .btn {
      border-radius: 25px;
      background-color: #00ffff;
      color: #000;
      font-weight: 600;
      transition: all 0.3s;
    }

    form .btn:hover {
      background-color: #00b3b3;
      color: #fff;
      box-shadow: 0 0 15px rgba(0, 255, 255, 0.4);
    }

    table {
      color: white;
    }

    th {
      background-color: rgba(0, 255, 255, 0.15);
      text-transform: uppercase;
      font-size: 0.85rem;
    }

    tbody tr:hover {
      background-color: rgba(0, 255, 255, 0.1);
      transition: 0.2s ease-in-out;
      transform: scale(1.01);
    }

    .btn-sm {
      border-radius: 20px;
      font-size: 0.85rem;
      transition: all 0.2s;
    }

    .btn-danger:hover {
      box-shadow: 0 0 10px rgba(255, 0, 0, 0.5);
    }

    .btn-secondary:hover {
      box-shadow: 0 0 10px rgba(0, 255, 255, 0.4);
    }

    .footer {
      text-align: center;
      margin-top: 20px;
      font-size: 0.9rem;
      color: #ccc;
    }

    .nav-buttons a {
      border-radius: 30px;
      margin: 5px;
      font-weight: 600;
      transition: all 0.3s;
    }

    .nav-buttons a:hover {
      transform: scale(1.05);
      box-shadow: 0 0 12px rgba(0, 255, 255, 0.3);
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>⚙️ Kelola Tim Liga</h1>

    <form method="post" class="mb-4 d-flex gap-2 justify-content-center">
      <input type="text" name="name" class="form-control w-50" placeholder="Masukkan Nama Tim Baru..." required>
      <button class="btn btn-info px-4">Tambah Tim</button>
    </form>

    <div class="table-responsive">
      <table class="table table-dark table-hover align-middle text-center">
        <thead>
          <tr>
            <th>#</th>
            <th>Nama Tim</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($teams as $t): ?>
          <tr>
            <td><?= htmlspecialchars($t['id']) ?></td>
            <td class="fw-bold text-info"><?= htmlspecialchars($t['name']) ?></td>
            <td>
              <a href="edit_team.php?id=<?= $t['id'] ?>" class="btn btn-sm btn-secondary">✏️ Edit</a>
              <a href="delete_team.php?id=<?= $t['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus tim ini?')">🗑 Hapus</a>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <div class="text-center mt-4 nav-buttons">
      <a href="generate_schedule.php" class="btn btn-success">⚔ Generate Jadwal Otomatis</a>
      <a href="matches.php" class="btn btn-primary">📅 Lihat Pertandingan</a>
      <a href="standings.php" class="btn btn-outline-info">🏆 Lihat Klasemen</a>
      <a href="index.php" class="btn btn-outline-light">🏠 Kembali ke Beranda</a>
    </div>

    <div class="footer">© 2025 Babang HM</div>
  </div>
</body>
</html>
