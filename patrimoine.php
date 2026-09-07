<?php
require_once 'includes/config.php';
include 'includes/header.php';

// Récupération des sites
try {
  $stmt = $pdo->query("SELECT * FROM sites");
  $sites = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  echo "<p>Erreur lors de la récupération des sites : " . $e->getMessage() . "</p>";
}
?>

<section>
  <h2>Les sites patrimoniaux de Ouagadougou</h2>

  <div class="site-grid">
    <?php foreach ($sites as $site): ?>
      <div class="site-card">
        <img src="images/<?= htmlspecialchars($site['image_path']) ?>" alt="<?= htmlspecialchars($site['nom_site']) ?>">
        <h3><?= htmlspecialchars($site['nom_site']) ?></h3>
        <a href="site.php?id=<?= $site['id'] ?>" class="button">Voir plus</a>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
