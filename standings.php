<?php
// standings.php
require_once 'config.php';
require_once 'functions.php';

$standings = computeStandings($pdo);
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Klasemen Liga e-Football 2025</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
      color: #fff;
      font-family: 'Poppins', sans-serif;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .table-container {
      background: rgba(0, 0, 0, 0.5);
      backdrop-filter: blur(10px);
      border-radius: 20px;
      padding: 30px;
      box-shadow: 0 0 25px rgba(0, 255, 255, 0.2);
      width: 95%;
      max-width: 1100px;
    }

    h1 {
      text-align: center;
      font-weight: 700;
      letter-spacing: 1px;
      margin-bottom: 30px;
      text-transform: uppercase;
      color: #00ffff;
      text-shadow: 0 0 15px rgba(0, 255, 255, 0.8);
    }

    table {
      color: #fff;
    }

    th {
      background-color: rgba(0, 255, 255, 0.2);
      text-transform: uppercase;
      font-size: 0.9rem;
    }

    tbody tr:hover {
      background-color: rgba(0, 255, 255, 0.1);
      box-shadow: 0 0 10px rgba(0, 255, 255, 0.3);
      transform: scale(1.01);
      transition: all 0.2s ease-in-out;
    }

    .btn-custom {
      background-color: #00ffff;
      border: none;
      color: #000;
      font-weight: 600;
      margin: 5px;
      border-radius: 30px;
      transition: all 0.3s;
    }

    .btn-custom:hover {
      background-color: #00b3b3;
      color: #fff;
      box-shadow: 0 0 15px rgba(0, 255, 255, 0.5);
    }

    .footer {
      text-align: center;
      margin-top: 20px;
      font-size: 0.9rem;
      color: #ccc;
    }
  </style>
</head>
<body>
  <div class="table-container">
    <h1>🏆 Klasemen PDK Super League 2025</h1>

    <div class="table-responsive">
      <table class="table table-dark table-hover align-middle text-center">
        <thead>
          <tr>
            <th>#</th>
            <th>Tim</th>
            <th>Main</th>
            <th>Menang</th>
            <th>Seri</th>
            <th>Kalah</th>
            <th>Gol</th>
            <th>Kebobolan</th>
            <th>Selisih</th>
            <th>Poin</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1; foreach ($standings as $row): ?>
          <tr>
            <td><?= $i++ ?></td>
            <td class="fw-bold text-info"><?= htmlspecialchars($row['team_name']) ?></td>
            <td><?= $row['played'] ?></td>
            <td><?= $row['win'] ?></td>
            <td><?= $row['draw'] ?></td>
            <td><?= $row['loss'] ?></td>
            <td><?= $row['gf'] ?></td>
            <td><?= $row['ga'] ?></td>
            <td><?= $row['gd'] ?></td>
            <td class="fw-bold text-success"><?= $row['points'] ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <div class="text-center mt-4">
      <a href="matches.php" class="btn btn-custom">⚔ Jadwal Pertandingan</a>
      <a href="teams.php" class="btn btn-custom">⚙ Kelola Tim</a>
      <a href="index.php" class="btn btn-custom">🏠 Kembali ke Beranda</a>
    </div>

    <div class="footer">© 2025 Babang HM</div>
  </div>
</body>
</html>
