<?php
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $match_id = $_POST['match_id'];
  $score_home = intval($_POST['score_home']);
  $score_away = intval($_POST['score_away']);

  // Ambil data pertandingan
  $stmt = $pdo->prepare("SELECT * FROM cup_matches WHERE id = ?");
  $stmt->execute([$match_id]);
  $match = $stmt->fetch(PDO::FETCH_ASSOC);

  if (!$match) exit("Match tidak ditemukan.");

  // Tentukan pemenang
  if ($score_home > $score_away) {
    $winner_id = $match['team_home_id'];
  } elseif ($score_away > $score_home) {
    $winner_id = $match['team_away_id'];
  } else {
    exit("Seri tidak diizinkan di sistem gugur!");
  }

  // Update skor dan pemenang
  $pdo->prepare("
    UPDATE cup_matches 
    SET score_home=?, score_away=?, winner_id=? 
    WHERE id=?
  ")->execute([$score_home, $score_away, $winner_id, $match_id]);

  // 🔍 Cek apakah semua pertandingan di round ini sudah selesai
  $stmt = $pdo->prepare("SELECT * FROM cup_matches WHERE round = ? AND (winner_id IS NULL)");
  $stmt->execute([$match['round']]);
  $unfinished = $stmt->rowCount();

  if ($unfinished === 0) {
    // Ambil semua pemenang dari round ini
    $winners = $pdo->query("
      SELECT winner_id FROM cup_matches 
      WHERE round = {$match['round']}
    ")->fetchAll(PDO::FETCH_COLUMN);

    // Kalau lebih dari 1 pemenang, buat round baru
    if (count($winners) > 1) {
      $next_round = $match['round'] + 1;

      for ($i = 0; $i < count($winners); $i += 2) {
        if (isset($winners[$i+1])) {
          $pdo->prepare("
            INSERT INTO cup_matches (team_home_id, team_away_id, round)
            VALUES (?, ?, ?)
          ")->execute([$winners[$i], $winners[$i+1], $next_round]);
        }
      }
    } else {
      // Kalau hanya 1 pemenang tersisa → dia juara
      $champion_id = $winners[0];
      $pdo->prepare("INSERT INTO cup_winner (team_id, created_at) VALUES (?, NOW())")->execute([$champion_id]);
      header("Location: winner.php");
      exit;
    }
  }

  header("Location: bracket.php");
  exit;
}
?>
