<?php
session_start();

if (!isset($_SESSION['utilisateur'])) {
    header('Location: login.php');
    exit;
}

require_once 'includes/config.php';

try {
    $stmt = $pdo->query("SELECT * FROM hotels ORDER BY etoiles DESC, nom_hotel ASC");
    $hotels = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur lors du chargement des hotels : " . $e->getMessage());
}
?>

<?php include 'includes/header.php'; ?>

<section>
  <h2>Nos Hotels Partenaires</h2>
  <p style="text-align: center; margin-bottom: 30px;">Selectionnez un hotel pour effectuer votre reservation</p>

  <div class="site-grid">
    <?php foreach ($hotels as $hotel): ?>
      <div class="site-card">
        <?php if (!empty($hotel['image_path'])): ?>
          <img src="images/<?= htmlspecialchars($hotel['image_path']) ?>" alt="<?= htmlspecialchars($hotel['nom_hotel']) ?>">
        <?php endif; ?>

        <h3><?= htmlspecialchars($hotel['nom_hotel']) ?></h3>

        <div class="etoiles">
          <?php for ($i = 0; $i < $hotel['etoiles']; $i++): ?>&#9733;<?php endfor; ?>
          <?php for ($i = $hotel['etoiles']; $i < 5; $i++): ?>&#9734;<?php endfor; ?>
        </div>

        <p style="padding: 0 20px; font-size: 0.9em;"><?= htmlspecialchars($hotel['adresse']) ?></p>

        <?php if (!empty($hotel['prix_moyen'])): ?>
          <p class="prix"><?= number_format($hotel['prix_moyen'], 0, ',', ' ') ?> FCFA / nuit</p>
        <?php endif; ?>

        <a href="reservation.php?hotel_id=<?= $hotel['id'] ?>" class="button">Reserver</a>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
