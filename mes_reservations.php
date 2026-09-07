<?php
session_start();

if (!isset($_SESSION['utilisateur'])) {
    header("Location: login.php");
    exit;
}

require_once 'includes/config.php';

$id_utilisateur = $_SESSION['utilisateur']['id'];

try {
    $query = "
        SELECT r.id, r.date_reservation, r.date_arrivee, r.date_depart, r.nb_personnes, r.statut,
               h.nom_hotel, h.adresse, h.image_path, h.etoiles
        FROM reservations r
        JOIN hotels h ON r.hotel_id = h.id
        WHERE r.utilisateur_id = :id_utilisateur
        ORDER BY r.date_reservation DESC
    ";

    $stmt = $pdo->prepare($query);
    $stmt->execute(['id_utilisateur' => $id_utilisateur]);
    $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur lors de la recuperation des reservations : " . $e->getMessage());
}
?>

<?php include 'includes/header.php'; ?>

<section>
  <h2>Mes Reservations</h2>

  <?php if (count($reservations) === 0): ?>
    <div style="text-align: center; padding: 50px 20px;">
      <p style="font-size: 1.2em; color: #666;">Vous n'avez pas encore effectue de reservation.</p>
      <a href="hotels.php" class="button" style="margin-top: 20px;">Voir les hotels</a>
    </div>
  <?php else: ?>
    <div class="site-grid">
      <?php foreach ($reservations as $res): ?>
        <div class="site-card">
          <?php if (!empty($res['image_path'])): ?>
            <img src="images/<?= htmlspecialchars($res['image_path']) ?>" alt="<?= htmlspecialchars($res['nom_hotel']) ?>">
          <?php endif; ?>

          <h3><?= htmlspecialchars($res['nom_hotel']) ?></h3>

          <div class="etoiles">
            <?php for ($i = 0; $i < $res['etoiles']; $i++): ?>&#9733;<?php endfor; ?>
          </div>

          <div style="padding: 0 20px; text-align: left;">
            <p><strong>Arrivee :</strong> <?= date('d/m/Y', strtotime($res['date_arrivee'])) ?></p>
            <p><strong>Depart :</strong> <?= date('d/m/Y', strtotime($res['date_depart'])) ?></p>
            <p><strong>Personnes :</strong> <?= htmlspecialchars($res['nb_personnes']) ?></p>
            <p><strong>Statut :</strong>
              <span style="color: #2ecc71; font-weight: bold;">
                <?= ucfirst(htmlspecialchars($res['statut'])) ?>
              </span>
            </p>
          </div>

          <p style="font-size: 0.85em; color: #999; padding: 10px 20px;">
            Reserve le <?= date('d/m/Y a H:i', strtotime($res['date_reservation'])) ?>
          </p>
        </div>
      <?php endforeach; ?>
    </div>

    <div style="text-align: center; margin-top: 30px;">
      <a href="hotels.php" class="button">Nouvelle reservation</a>
    </div>
  <?php endif; ?>
</section>

<?php include 'includes/footer.php'; ?>
