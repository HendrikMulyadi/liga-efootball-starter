<?php
require_once '../config.php';

// Hapus data lama biar bersih kalau regenerate
$pdo->exec("DELETE FROM cup_matches");

// Ambil semua tim
$teams = $pdo->query("SELECT id FROM cup_teams ORDER BY RAND()")->fetchAll(PDO::FETCH_COLUMN);
$totalTeams = count($teams);

if ($totalTeams < 2) {
    die("<h2>Minimal 2 tim untuk membuat jadwal turnamen!</h2>");
}

// Buat pasangan dua-dua
$round = 1;
for ($i = 0; $i < $totalTeams; $i += 2) {
    if (isset($teams[$i+1])) {
        $stmt = $pdo->prepare("INSERT INTO cup_matches (round, team_home_id, team_away_id) VALUES (?, ?, ?)");
        $stmt->execute([$round, $teams[$i], $teams[$i+1]]);
    }
}

// Redirect ke bagan
header("Location: bracket.php");
exit;
