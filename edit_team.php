<?php
// edit_team.php - placeholder
require_once 'config.php';
if (!isset($_GET['id'])) { header('Location: teams.php'); exit; }
$id = intval($_GET['id']);
$team = $pdo->prepare("SELECT * FROM teams WHERE id = ?"); $team->execute([$id]);
$team = $team->fetch(PDO::FETCH_ASSOC);
if (!$team) { header('Location: teams.php'); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    if ($name !== '') {
        $stmt = $pdo->prepare("UPDATE teams SET name = ? WHERE id = ?");
        $stmt->execute([$name, $id]);
        header("Location: teams.php");
        exit;
    }
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Edit Team</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"></head>
<body class="p-4">
<div class="container">
  <h1>Edit Team</h1>
  <form method="post">
    <div class="mb-3">
      <label class="form-label">Nama Tim</label>
      <input type="text" name="name" class="form-control" value="<?=htmlspecialchars($team['name'])?>" required>
    </div>
    <button class="btn btn-primary">Simpan</button>
    <a href="teams.php" class="btn btn-secondary">Batal</a>
  </form>
</div>
</body>
</html>
