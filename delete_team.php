<?php
// delete_team.php
require_once 'config.php';
if (!isset($_GET['id'])) { header('Location: teams.php'); exit; }
$id = intval($_GET['id']);
$stmt = $pdo->prepare("DELETE FROM teams WHERE id = ?");
$stmt->execute([$id]);
header("Location: teams.php");
exit;
?>
