<?php
// Démarrage de session si besoin
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ouagadougou Tourisme</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header>
  <div class="logo">
    <h1>Découvrir Ouagadougou</h1>
  </div>
  <nav>
    <ul class="nav-links">
      <li><a href="index.php">Accueil</a></li>
      <li><a href="patrimoine.php">Patrimoine</a></li>
      <li><a href="login.php">Réservation d'hôtel</a></li>
      <li><a href="galerie.php">Galerie</a></li>
    </ul>
  </nav>

  <?php if (isset($_SESSION['utilisateur']) && basename($_SERVER['PHP_SELF']) === 'hotels.php'): ?>
  <div class="profil-utilisateur" style="background: #005A80; padding: 10px 20px; margin-top: 10px; color: black; border-radius: 8px;">
    <p>👤 Bonjour, <?= htmlspecialchars($_SESSION['utilisateur']['nom']) ?> !</p>
    <a href="mes_reservaions.php" style="text-decoration: none; color: black; font-weight: bold;">📋 Voir mes réservations</a>
  </div>
<?php endif; ?>

</header>

<main>
