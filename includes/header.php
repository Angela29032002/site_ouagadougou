<?php
// Demarrage de session si besoin
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Decouvrez Ouagadougou, capitale du Burkina Faso. Sites patrimoniaux, hotels et reservations.">
  <meta name="theme-color" content="#005a87">
  <title>Ouagadougou Tourisme - Decouvrez le Burkina Faso</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
</head>
<body>

<header>
  <div class="header-top">
    <div class="logo">
      <h1>Decouvrir Ouagadougou</h1>
    </div>
  </div>
  <nav>
    <ul class="nav-links">
      <li><a href="index.php" <?= $currentPage === 'index.php' ? 'style="background: rgba(255,255,255,0.2);"' : '' ?>>Accueil</a></li>
      <li><a href="patrimoine.php" <?= $currentPage === 'patrimoine.php' || $currentPage === 'site.php' ? 'style="background: rgba(255,255,255,0.2);"' : '' ?>>Patrimoine</a></li>
      <li><a href="<?= isset($_SESSION['utilisateur']) ? 'hotels.php' : 'login.php' ?>" <?= in_array($currentPage, ['hotels.php', 'login.php', 'reservation.php']) ? 'style="background: rgba(255,255,255,0.2);"' : '' ?>>Hotels</a></li>
      <li><a href="galerie.php" <?= $currentPage === 'galerie.php' ? 'style="background: rgba(255,255,255,0.2);"' : '' ?>>Galerie</a></li>
      <?php if (isset($_SESSION['utilisateur'])): ?>
        <li><a href="logout.php">Deconnexion</a></li>
      <?php else: ?>
        <li><a href="login.php">Connexion</a></li>
      <?php endif; ?>
    </ul>
  </nav>

  <?php if (isset($_SESSION['utilisateur']) && in_array($currentPage, ['hotels.php', 'reservation.php', 'mes_reservations.php'])): ?>
  <div class="profil-utilisateur">
    <p>Bonjour, <?= htmlspecialchars($_SESSION['utilisateur']['nom']) ?> !</p>
    <a href="mes_reservations.php">Mes reservations</a>
  </div>
  <?php endif; ?>

</header>

<main>
