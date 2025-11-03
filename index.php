<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>PDK Super League & Cup 2025</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      background: url('assets/img/stadion.png') no-repeat center center fixed;
      background-size: cover;
      height: 100vh;
      margin: 0;
      font-family: 'Poppins', sans-serif;
      color: white;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .overlay-box {
      background: rgba(0, 0, 0, 0.75);
      padding: 60px 90px;
      border-radius: 25px;
      box-shadow: 0 0 25px rgba(0, 255, 255, 0.2);
      text-align: center;
      backdrop-filter: blur(8px);
      transition: transform 0.3s ease;
    }

    .overlay-box:hover {
      transform: scale(1.03);
      box-shadow: 0 0 40px rgba(0, 255, 255, 0.4);
    }

    h1 {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 4rem;
      letter-spacing: 2px;
      color: #00ffff;
      text-shadow: 0 0 20px rgba(0, 255, 255, 0.6);
      margin-bottom: 10px;
    }

    .subtitle {
      font-size: 1.3rem;
      color: #ddd;
      font-weight: 400;
      margin-bottom: 40px;
      letter-spacing: 0.5px;
    }

    .btn-mode {
      font-size: 1.2rem;
      padding: 12px 35px;
      border-radius: 50px;
      font-weight: 600;
      border: none;
      transition: all 0.3s ease;
      box-shadow: 0 0 15px rgba(0, 255, 255, 0.4);
      margin: 10px;
      min-width: 200px;
    }

    .btn-league {
      background: linear-gradient(90deg, #00ffff, #0077ff);
      color: #000;
    }

    .btn-league:hover {
      transform: translateY(-3px);
      background: linear-gradient(90deg, #00b3b3, #0044aa);
      box-shadow: 0 0 25px rgba(0, 255, 255, 0.6);
      color: #fff;
    }

    .btn-cup {
      background: linear-gradient(90deg, #ffcc00, #ff6600);
      color: #000;
    }

    .btn-cup:hover {
      transform: translateY(-3px);
      background: linear-gradient(90deg, #ff9900, #cc3300);
      box-shadow: 0 0 25px rgba(255, 165, 0, 0.7);
      color: #fff;
    }

    footer {
      position: absolute;
      bottom: 20px;
      width: 100%;
      text-align: center;
      font-size: 0.9rem;
      color: rgba(255,255,255,0.7);
      letter-spacing: 1px;
    }
  </style>
</head>
<body>
  <div class="overlay-box">
    <h1>PDK SUPER LEAGUE 2025</h1>
    <p class="subtitle">Rasakan sensasi persaingan antar tim terbaik di dunia e-Football.<br>
    Strategi, kecepatan, dan semangat juara — semuanya dimulai di sini!</p>

    <div class="d-flex justify-content-center flex-wrap">
      <a href="standings.php?mode=league" class="btn btn-mode btn-league">⚽ Mode Liga</a>
      <a href="cup/index.php" class="btn btn-mode btn-cup">🏆 Mode Cup</a>
    </div>
  </div>

  <footer>© 2025 Babang HM | Powered by e-Football League System</footer>
</body>
</html>
