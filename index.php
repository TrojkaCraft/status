<!DOCTYPE html><html lang="cs">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>TrojkaCraft Status</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet" />
  <style>
    body {
      margin: 0;
      font-family: 'Montserrat', sans-serif;
      background-color: #0d1117;
      color: #e6edf3;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      text-align: center;
    }
    h1 {
      color: #a8e63a;
      margin-bottom: 1rem;
    }
    .status-box {
      background-color: #21262d;
      padding: 2rem;
      border-radius: 10px;
      border: 2px solid #30363d;
      max-width: 600px;
      width: 90%;
    }
    .status {
      color: #a8e63a;
      margin: 0.5rem 0;
    }
    .offline {
      color: #ff5555 !important;
    }
    .countdown {
      margin-top: 1rem;
      color: #8b949e;
      font-size: 0.9rem;
    }
  </style>
</head>
<body>
  <h1>TrojkaCraft - Stav serverů</h1>
  <div class="status-box">
    <?php
    function checkMCServer($ip) {
      $data = @file_get_contents("https://api.mcsrvstat.us/2/{$ip}");
      if (!$data) return false;
      return json_decode($data, true);
    }function checkURL($url) {
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_NOBODY, true);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_TIMEOUT, 5);
  curl_exec($ch);
  $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);
  return $httpcode >= 200 && $httpcode < 400;
}

$mcData = checkMCServer('mc.3zscraft.cz');
$dynmapOnline = checkURL('http://feature-cards.gl.at.ply.gg:26636');
$webOnline = checkURL('https://www.3zscraft.cz');
?>

<p class="status">
  <strong>MC Server (mc.3zscraft.cz):</strong>
  <span class="<?php echo $mcData && $mcData['online'] ? 'status' : 'status offline'; ?>">
    <?php echo $mcData && $mcData['online'] ? 'Online' : 'Offline'; ?>
  </span>
</p>
<p class="status">
  <strong>Hráči online:</strong>
  <span class="<?php echo $mcData && $mcData['online'] ? 'status' : 'status offline'; ?>">
    <?php echo $mcData && $mcData['online'] ? ($mcData['players']['online'] ?? 'N/A') : 'N/A'; ?>
  </span>
</p>
<p class="status">
  <strong>Max hráčů:</strong>
  <span class="<?php echo $mcData && $mcData['online'] ? 'status' : 'status offline'; ?>">
    <?php echo $mcData && $mcData['online'] ? ($mcData['players']['max'] ?? 'N/A') : 'N/A'; ?>
  </span>
</p>
<p class="status">
  <strong>Dynmapa:</strong>
  <span class="<?php echo $dynmapOnline ? 'status' : 'status offline'; ?>">
    <?php echo $dynmapOnline ? 'Online' : 'Offline'; ?>
  </span>
</p>
<p class="status">
  <strong>www.3zscraft.cz:</strong>
  <span class="<?php echo $webOnline ? 'status' : 'status offline'; ?>">
    <?php echo $webOnline ? 'Online' : 'Offline'; ?>
  </span>
</p>
<?php if (!$mcData['online'] && !$dynmapOnline): ?>
<p class="status offline">Náš hosting je vypnutý.</p>
<?php endif; ?>

  </div>
</body>
</html>
