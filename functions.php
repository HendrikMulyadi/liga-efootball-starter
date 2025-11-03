<?php
// functions.php
require_once 'config.php';

function generateRoundRobin($teamIds) {
    $teams = $teamIds;
    if (count($teams) % 2 !== 0) {
        $teams[] = 0; // bye
    }
    $n = count($teams);
    $rounds = $n - 1;
    $matches = [];

    for ($r = 0; $r < $rounds; $r++) {
        for ($i = 0; $i < $n / 2; $i++) {
            $t1 = $teams[$i];
            $t2 = $teams[$n - 1 - $i];
            if ($t1 == 0 || $t2 == 0) continue;
            $matches[] = ['home' => $t1, 'away' => $t2, 'round' => $r + 1];
        }
        $fixed = $teams[0];
        $rest = array_slice($teams, 1);
        $rest = array_merge([array_pop($rest)], $rest);
        $teams = array_merge([$fixed], $rest);
    }
    return $matches;
}

function insertMatches($pdo, $matches, $startDate = null, $secondsBetween = 86400) {
    $stmt = $pdo->prepare("INSERT INTO matches (round_no, team_home_id, team_away_id, match_date, status) VALUES (?, ?, ?, ?, 'scheduled')");
    $ts = $startDate ? strtotime($startDate) : time();
    foreach ($matches as $m) {
        $matchDate = date('Y-m-d H:i:s', $ts);
        $stmt->execute([$m['round'], $m['home'], $m['away'], $matchDate]);
        $ts += $secondsBetween;
    }
}

function computeStandings($pdo) {
    $teams = [];
    $rows = $pdo->query("SELECT id, name FROM teams")->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as $r) {
        $teams[$r['id']] = [
            'team_id' => $r['id'],
            'team_name' => $r['name'],
            'played' => 0,
            'win' => 0,
            'draw' => 0,
            'loss' => 0,
            'gf' => 0,
            'ga' => 0,
            'gd' => 0,
            'points' => 0
        ];
    }

    $matches = $pdo->query("SELECT * FROM matches WHERE status='played'")->fetchAll(PDO::FETCH_ASSOC);
    foreach ($matches as $m) {
        $home = $m['team_home_id'];
        $away = $m['team_away_id'];
        $sh = (int)$m['score_home'];
        $sa = (int)$m['score_away'];

        $teams[$home]['played']++;
        $teams[$away]['played']++;

        $teams[$home]['gf'] += $sh;
        $teams[$home]['ga'] += $sa;
        $teams[$away]['gf'] += $sa;
        $teams[$away]['ga'] += $sh;

        if ($sh > $sa) {
            $teams[$home]['win']++;
            $teams[$away]['loss']++;
            $teams[$home]['points'] += 3;
        } elseif ($sh < $sa) {
            $teams[$away]['win']++;
            $teams[$home]['loss']++;
            $teams[$away]['points'] += 3;
        } else {
            $teams[$home]['draw']++;
            $teams[$away]['draw']++;
            $teams[$home]['points'] += 1;
            $teams[$away]['points'] += 1;
        }
    }

    foreach ($teams as &$t) {
        $t['gd'] = $t['gf'] - $t['ga'];
    }
    unset($t);

    usort($teams, function($a, $b) {
        if ($a['points'] !== $b['points']) return $b['points'] - $a['points'];
        if ($a['gd'] !== $b['gd']) return $b['gd'] - $a['gd'];
        return $b['gf'] - $a['gf'];
    });

    return $teams;
}
?>
