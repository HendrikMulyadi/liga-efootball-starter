<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>🏆 PDK eFootball Cup 2025</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: url('../assets/img/stadion.png') no-repeat center center fixed;
      background-size: cover;
      font-family: 'Poppins', sans-serif;
      color: white;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .menu-box {
      background: rgba(0, 0, 0, 0.75);
      padding: 50px 80px;
      border-radius: 25px;
      box-shadow: 0 0 25px rgba(255, 200, 0, 0.3);
      text-align: center;
    }
    .menu-box h1 {
      color: #ffcc00;
      font-weight: 700;
      text-shadow: 0 0 15px rgba(255, 200, 0, 0.6);
      margin-bottom: 25px;
    }
    .btn-custom {
      border-radius: 40px;
      padding: 12px 30px;
      font-size: 1.2rem;
      margin: 10px;
      transition: 0.3s;
    }
    .btn-teams {
      background: linear-gradient(90deg, #ffcc00, #ff8800);
      color: black;
      font-weight: 600;
    }
    .btn-teams:hover {
      background: linear-gradient(90deg, #ffdd33, #ff6600);
      color: white;
      transform: scale(1.05);
    }
    .btn-bracket {
      background: linear-gradient(90deg, #00ffff, #0077ff);
      color: black;
      font-weight: 600;
    }
    .btn-bracket:hover {
      background: linear-gradient(90deg, #00cccc, #0044aa);
      color: white;
      transform: scale(1.05);
    }
  </style>
</head>
<body>
  <div class="menu-box">
    <h1>🏆 PDK CUP 2025</h1>
    <p>Pertandingan sistem gugur — siapa kuat dia juara!</p>
    <a href="teams.php" class="btn btn-custom btn-teams">👥 Kelola Tim</a>
    <a href="bracket.php" class="btn btn-custom btn-bracket">🔗 Lihat Bagan Turnamen</a>
  </div>
</body>
</html>
