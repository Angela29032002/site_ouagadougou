<?php
session_start();

if (!isset($_SESSION['utilisateur'])) {
    header('Location: login.php');
    exit;
}

require_once 'includes/confiig.php';

try {
    $stmt = $pdo->query("SELECT * FROM hotels ORDER BY nom_hotel ASC");
    $hotels = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur lors du chargement des hôtels : " . $e->getMessage());
}
?>

<?php include 'includes/header.php'; ?>

<section>
  <h2>Nos hôtels partenaires</h2>

  <div class="site-grid">
    <?php foreach ($hotels as $hotel): ?>
      <div class="site-card">
        <?php if (!empty($hotel['image_path'])): ?>
          <img src="images/<?= htmlspecialchars($hotel['image_path']) ?>" alt="<?= htmlspecialchars($hotel['nom_hotel']) ?>" style="width:100%; height:200px; object-fit:cover; border-radius:8px;">
        <?php endif; ?>

        <h3><?= htmlspecialchars($hotel['nom_hotel']) ?></h3>
        <p><strong>Adresse :</strong> <?= htmlspecialchars($hotel['adresse']) ?></p>
        <p><?= nl2br(htmlspecialchars($hotel['description'])) ?></p>

        <a href="reservation.php?hotel_id=<?= $hotel['id'] ?>" class="button">Réserver</a>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
