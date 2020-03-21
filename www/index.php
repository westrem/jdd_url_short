<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config.php';

$query = $_GET['q'];

if (empty($query)) {
  header($_SERVER['SERVER_PROTOCOL'] . " 404 Not Found", true, 404);
  exit;
}

try {
  $db = new Nette\Database\Connection($dbdsn, $dbuser, $dbpass);

  $link = $db->fetch('SELECT link, instant, title, description, og_image FROM links WHERE deleted_at IS NULL AND paused_at IS NULL AND id = ?', $query);

  if (empty($link)) {
    header($_SERVER['SERVER_PROTOCOL'] . " 404 Not Found", true, 404);
    exit;
  }

  $insert = [
    'link_id' => $query,
  ];

  if (!empty($_SERVER['HTTP_USER_AGENT'])) { $insert['ua'] = $_SERVER['HTTP_USER_AGENT']; }
  if (!empty($_SERVER['HTTP_REFERER'])) { $insert['ref'] = $_SERVER['HTTP_REFERER']; }
  if (!empty($_SERVER['REMOTE_ADDR'])) { $insert['if'] = $db::literal("INET_ATON('" . $_SERVER['REMOTE_ADDR'] ."')"); }

  $db->query('INSERT INTO stats', $insert);

  if ($link->instant) {
    header("Location: " . $link->link, true, 307);
    exit;
  }

  $slink = str_replace('"', '\\"', $link->link);
  $stitle = str_replace('"', '\\"', $link->title);
  $sdescription = str_replace('"', '\\"', $link->description);
  $sog_image = str_replace('"', '\\"', $link->og_image);
?>

<!doctype html>
<html lang="en" prefix="og: http://ogp.me/ns#">

<head>
  <meta charset="utf-8">
  <?php echo $link->title ? "<title>". str_replace('>', '&gt;', $link->title) ."</title>" : ''; ?>
  <?php echo $link->title ? "<meta property=\"og:title\" content=\"{$stitle}\" />" : ''; ?>

  <?php echo $link->description ? "<meta name=\"description\" content=\"{$sdescription}\">" : ''; ?>
  <?php echo $link->description ? "<meta name=\"og:description\" content=\"{$sdescription}\">" : ''; ?>

  <?php echo $link->og_image ? "<meta name=\"og:image\" content=\"{$sog_image}\">" : ''; ?>
</head>

<body>
  Redirecting...

  <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
      ga('create', '<?php echo $google_analytics ?>', 'auto');
      ga('set', 'anonymizeIp', true);
      ga('send', 'pageview', "<?php echo $slink ?>");
      window.setTimeout(function() {
        window.location = "<?php echo $slink ?>";
      }, 1500);
  </script>
</body>

</html>

<?php
} catch (\Exception $e) {
  header($_SERVER['SERVER_PROTOCOL'] . " 500 Internal Server Error", true, 500);
  exit;
}
