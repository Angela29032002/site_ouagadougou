<?php
require_once 'includes/config.php';
include 'includes/header.php';

// Vérifie si l'ID est passé dans l'URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<p>ID de site invalide.</p>";
    include 'includes/footer.php';
    exit;
}

$id = (int) $_GET['id'];

// Récupération des infos du site
try {
    $stmt = $pdo->prepare("SELECT * FROM sites WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $site = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$site) {
        echo "<p>Site introuvable.</p>";
        include 'includes/footer.php';
        exit;
    }

    // Récupération des images supplémentaires
    $imagesStmt = $pdo->prepare("SELECT image_path FROM images_sites WHERE site_id = :id");
    $imagesStmt->execute(['id' => $id]);
    $images = $imagesStmt->fetchAll(PDO::FETCH_COLUMN);

} catch (PDOException $e) {
    echo "<p>Erreur : " . $e->getMessage() . "</p>";
    include 'includes/footer.php';
    exit;
}
?>

<section>
  <h2><?= htmlspecialchars($site['nom_site']) ?></h2>

  <?php if ($images): ?>
    <div class="gallery">
      <?php foreach ($images as $img): ?>
        <img src="images/<?= htmlspecialchars($img) ?>" alt="Image de <?= htmlspecialchars($site['nom_site']) ?>" style="max-width:300px; margin:10px; border-radius:8px;">
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <img src="images/<?= htmlspecialchars($site['image_path']) ?>" alt="<?= htmlspecialchars($site['nom_site']) ?>" style="max-width:100%; border-radius:10px; margin-bottom: 20px;">
  <?php endif; ?>

  <h3>Description</h3>
  <p><?= nl2br(htmlspecialchars($site['description'])) ?></p>

  <h3>Historique</h3>
  <p><?= nl2br(htmlspecialchars($site['historique'])) ?></p>

  <div style="margin-top: 20px;">
    <a href="patrimoine.php" class="button">← Retour à la liste des sites</a>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
