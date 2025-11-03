<?php
require_once 'config.php';

// Ambil semua tim
$teams = $pdo->query("SELECT id FROM teams")->fetchAll(PDO::FETCH_COLUMN);
$totalTeams = count($teams);

if ($totalTeams % 2 != 0) {
    // Tambah 'dummy' kalau tim ganjil
    $teams[] = null;
    $totalTeams++;
}

$rounds = $totalTeams - 1;
$matchesPerRound = $totalTeams / 2;

$startDate = new DateTime(); // mulai dari hari ini
$startDate->modify('+1 day'); // bisa diubah sesuai kebutuhan

for ($round = 1; $round <= $rounds; $round++) {
    $date = clone $startDate;
    $date->modify('+' . ($round - 1) . ' day'); // hari ke-n

    for ($i = 0; $i < $matchesPerRound; $i++) {
        $home = $teams[$i];
        $away = $teams[$totalTeams - 1 - $i];

        if ($home !== null && $away !== null) {
            $stmt = $pdo->prepare("
                INSERT INTO matches (team_home_id, team_away_id, match_date, round_no, status)
                VALUES (?, ?, ?, ?, 'pending')
            ");
            $stmt->execute([$home, $away, $date->format('Y-m-d'), $round]);
        }
    }

    // rotasi tim untuk round berikutnya (metode round robin)
    $fixed = array_shift($teams);
    $rotated = array_splice($teams, 0);
    array_unshift($rotated, array_pop($rotated));
    array_unshift($rotated, $fixed);
    $teams = $rotated;
}

echo "✅ Jadwal pertandingan berhasil dibuat otomatis!";
?>
