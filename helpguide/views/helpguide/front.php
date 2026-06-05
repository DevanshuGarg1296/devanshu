<?php
use yii\helpers\Html;
use yii\helpers\Url;

/** @var app\modules\helpguide\models\HelpGuide[] $docs */
/** @var string $search */
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Help Guide</title>
  <link rel="icon" href="<?= Url::to('@web/assets/logo.jpg') ?>" type="image/x-icon">
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      display: flex;
      height: 100vh;
    }
    #hamburger {
      position: fixed;
      top: 10px;
      font-size: 24px;
      cursor: pointer;
      z-index: 1000;
      color: white;
      padding: 6px 10px;
      border-radius: 4px;
      background: #1e293b;
      left: 0;
    }
    #sidebar {
      width: 250px;
      background: #1e293b;
      color: white;
      height: 100vh;
      overflow-y: auto;
      transition: width 0.3s;
      padding: 15px;
      box-sizing: border-box;
      position: fixed;
      top: 0;
      left: 0;
    }
    #sidebar.collapsed { width: 60px; }
    #sidebar h2 { margin-top: 0; font-size: 1.2rem; }
    #sidebar.collapsed h2,
    #sidebar.collapsed form,
    #sidebar.collapsed .toc li a span { display: none; }
    #sidebar form { margin-bottom: 15px; }
    #sidebar input[type="text"] {
      width: 100%;
      padding: 5px;
      border: none;
      border-radius: 4px;
    }
    #sidebar ul { list-style: none; padding: 0; margin: 0; }
    #sidebar ul li { margin: 5px 0; }
    #sidebar ul li a {
      color: white;
      text-decoration: none;
      display: block;
      padding: 8px 10px;
      border-radius: 4px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    #sidebar ul li a:hover { background: #334155; }
    main {
      flex-grow: 1;
      margin-left: 250px;
      padding: 20px;
      overflow-y: auto;
      height: 100vh;
      background-color: #f4f7fa;
      transition: margin-left 0.3s;
    }
    #sidebar.collapsed + main { margin-left: 61px; width: 100%; }
    section { margin-bottom: 30px; }
    section h2 { color: #333; font-size: 1.5rem; margin-bottom: 10px; }
    section div { color: #555; line-height: 1.6; }
  </style>
</head>

<body>
  <div id="hamburger">&#9776;</div>

  <nav id="sidebar" class="collapsed">
    <h2>📖 Contents</h2>
    <form method="get">
      <input type="text" name="search" placeholder="Search..." value="<?= Html::encode($search) ?>" />
    </form>
    <ul class="toc">
      <?php if (!empty($docs)): ?>
        <?php foreach ($docs as $doc): ?>
          <li><a href="#<?= Html::encode($doc->slug) ?>"><span><?= Html::encode($doc->title) ?></span></a></li>
        <?php endforeach; ?>
      <?php else: ?>
        <li><em>No results found.</em></li>
      <?php endif; ?>
    </ul>
  </nav>

  <main>
    <?php foreach ($docs as $doc): ?>
      <section id="<?= Html::encode($doc->slug) ?>">
        <h2><?= Html::encode($doc->title) ?></h2>
        <hr>
        <div><?= $doc->content ?></div>
      </section>
    <?php endforeach; ?>
  </main>

  <script>
  document.getElementById("hamburger").addEventListener("click", function() {
    const sidebar = document.getElementById("sidebar");
    sidebar.classList.toggle("collapsed");
    const hamburger = document.getElementById("hamburger");
    if (sidebar.classList.contains("collapsed")) {
        hamburger.style.left = "0";
    } else {
        hamburger.style.left = "180px";
    }
  });
  </script>
</body>
</html>
