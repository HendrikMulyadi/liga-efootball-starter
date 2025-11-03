<?php
// update_result.php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $match_id = intval($_POST['match_id']);
    $score_home = intval($_POST['score_home']);
    $score_away = intval($_POST['score_away']);

    $stmt = $pdo->prepare("UPDATE matches SET score_home = ?, score_away = ?, status = 'played' WHERE id = ?");
    $stmt->execute([$score_home, $score_away, $match_id]);

    header("Location: matches.php");
    exit;
}
?>
