<?php
require_once 'config.php';

// Ambil kata kunci pencarian dan round yang dipilih
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$selectedRound = isset($_GET['round']) ? intval($_GET['round']) : 0;

// Ambil daftar round unik dari database
$rounds = $pdo->query("SELECT DISTINCT round_no FROM matches ORDER BY round_no")->fetchAll(PDO::FETCH_COLUMN);

// Bangun query dasar
$sql = "
  SELECT m.*, th.name AS home_name, ta.name AS away_name
  FROM matches m
  JOIN teams th ON m.team_home_id = th.id
  JOIN teams ta ON m.team_away_id = ta.id
  WHERE 1=1
";

// Tambahkan filter round jika dipilih
if ($selectedRound > 0) {
  $sql .= " AND m.round_no = :round_no";
}

// Tambahkan filter pencarian nama tim jika ada
if ($search !== '') {
  $sql .= " AND (th.name LIKE :search OR ta.name LIKE :search)";
}

$sql .= " ORDER BY m.round_no, m.match_date";

$stmt = $pdo->prepare($sql);

// Bind parameter dinamis
if ($selectedRound > 0) {
  $stmt->bindValue(':round_no', $selectedRound, PDO::PARAM_INT);
}
if ($search !== '') {
  $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
}
$stmt->execute();

$matches = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Pertandingan - Liga eFootball</title>
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
      padding: 40px 0;
    }
    .container {
      background: rgba(255, 255, 255, 0.08);
      backdrop-filter: blur(10px);
      border-radius: 20px;
      padding: 40px;
      max-width: 1100px;
      width: 95%;
      box-shadow: 0 0 30px rgba(0, 255, 255, 0.15);
    }
    h1 {
      text-align: center;
      color: #00ffff;
      font-weight: 700;
      text-shadow: 0 0 20px rgba(0, 255, 255, 0.4);
      margin-bottom: 20px;
    }
    .filters {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 10px;
      margin-bottom: 25px;
    }
    .filters input, .filters select {
      border-radius: 30px;
      padding: 8px 15px;
      border: none;
      background-color: rgba(255, 255, 255, 0.9);
      color: #000;
      font-weight: 500;
    }
    .filters button {
      border-radius: 30px;
      background-color: #00ffff;
      color: #000;
      border: none;
      padding: 8px 20px;
      font-weight: 600;
    }
    .filters button:hover {
      background-color: #00b3b3;
      color: white;
    }
    table {
      color: #fff;
      border-collapse: separate;
      border-spacing: 0 10px;
    }
    thead tr {
      background-color: rgba(0, 255, 255, 0.2);
    }
    tbody tr {
      background-color: rgba(255, 255, 255, 0.08);
      transition: all 0.3s ease;
    }
    tbody tr:hover {
      transform: scale(1.01);
      background-color: rgba(0, 255, 255, 0.15);
      box-shadow: 0 0 10px rgba(0, 255, 255, 0.3);
    }
    .form-control {
      background-color: rgba(255, 255, 255, 0.9);
      border: none;
      color: #000;
      font-weight: bold;
    }
    .team-name {
      color: #000;
      background-color: rgba(255, 255, 255, 0.8);
      padding: 4px 10px;
      border-radius: 8px;
      font-weight: 600;
      display: inline-block;
    }
    .status-played { color: #00ff88; font-weight: bold; }
    .status-pending { color: #ffcc00; font-weight: bold; }
    .footer {
      text-align: center;
      margin-top: 25px;
      font-size: 0.9rem;
      color: #ccc;
    }
    .nav-buttons {
      text-align: center;
      margin-top: 25px;
    }
    .nav-buttons a {
      margin: 5px;
      border-radius: 25px;
      font-weight: 600;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>📅 Jadwal Pertandingan Liga <?= $selectedRound ? "(Round $selectedRound)" : "" ?></h1>

    <!-- 🔍 Filter & Search -->
    <form method="get" class="filters">
      <select name="round" onchange="this.form.submit()">
        <option value="0">Semua Round</option>
        <?php foreach($rounds as $r): ?>
          <option value="<?= $r ?>" <?= $selectedRound == $r ? 'selected' : '' ?>>Round <?= $r ?></option>
        <?php endforeach; ?>
      </select>

      <input type="text" name="search" placeholder="Cari nama tim..." value="<?= htmlspecialchars($search) ?>">
      <button type="submit">🔎 Cari</button>
    </form>

    <div class="table-responsive">
      <table class="table table-borderless text-center align-middle">
        <thead>
          <tr>
            <th>Round</th>
            <th>Tanggal</th>
            <th>Home</th>
            <th>Score</th>
            <th>Away</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
        <?php if (count($matches) > 0): ?>
          <?php foreach($matches as $m): ?>
            <tr>
              <td class="fw-bold text-info"><?= htmlspecialchars($m['round_no']) ?></td>
              <td><?= htmlspecialchars($m['match_date']) ?></td>
              <td><span class="team-name"><?= htmlspecialchars($m['home_name']) ?></span></td>
              <td>
                <?php if ($m['status'] === 'played'): ?>
                  <span class="fw-bold text-success"><?= intval($m['score_home']) ?> - <?= intval($m['score_away']) ?></span>
                <?php else: ?>
                  <form method="post" action="update_result.php" class="d-flex gap-1 justify-content-center">
                    <input type="hidden" name="match_id" value="<?= $m['id'] ?>">
                    <input type="number" name="score_home" min="0" class="form-control text-center" style="width:70px" required>
                    <span class="align-self-center fw-bold">-</span>
                    <input type="number" name="score_away" min="0" class="form-control text-center" style="width:70px" required>
                    <button class="btn btn-sm btn-primary px-3">💾</button>
                  </form>
                <?php endif; ?>
              </td>
              <td><span class="team-name"><?= htmlspecialchars($m['away_name']) ?></span></td>
              <td>
                <?php if ($m['status'] === 'played'): ?>
                  <span class="status-played">Selesai</span>
                <?php else: ?>
                  <span class="status-pending">Menunggu</span>
                <?php endif; ?>
              </td>
              <td>
                <?php if ($m['status'] === 'played'): ?>
                  <small class="text-muted">✅ Tersimpan</small>
                <?php else: ?>
                  <a href="#" onclick="alert('Gunakan form di kolom skor untuk menyimpan hasil pertandingan.')" class="btn btn-sm btn-outline-light">ℹ Petunjuk</a>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="7" class="text-muted">Tidak ada pertandingan ditemukan.</td></tr>
        <?php endif; ?>
        </tbody>
      </table>
    </div>

    <div class="nav-buttons">
      <a href="teams.php" class="btn btn-outline-light">👥 Kelola Tim</a>
      <a href="standings.php" class="btn btn-outline-info">🏆 Klasemen</a>
      <a href="index.php" class="btn btn-outline-secondary">🏠 Beranda</a>
    </div>

    <div class="footer">© 2025 Babang HM</div>
  </div>
</body>
</html>
