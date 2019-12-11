<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="author" content="Valentin Dumas" />
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <title><?php echo $this->title ?></title>
  </head>
  <body>
    <header>
      <?php echo $this->header ?>
    </header>

    <main>
      <?php echo $this->content ?>
    </main>

    <footer>
      <div class="container">
        <ul class="info_legale">
          <li><a href="index.php?apropos">A propos</a></li>
          <li>Condition général</li>
        </ul>
        <div class="footer_right">
          <p class="copyright">© Copyright 2019, ALUBEER</p>
          <span><img src="images/logo.svg" class="type_paiment" alt="Logo"></span>
        </div>
      </div>
    </footer>
    <div class="navbar">
      <p class="info_projet">Projet réaliser dans le cadre du cours de Web, L3 informatique de l'université de Caen.</p>
    </div>
  </body>
</html>
