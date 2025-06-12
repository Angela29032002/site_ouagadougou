<?php
session_start();

// Redirection si utilisateur non connecté
if (!isset($_SESSION['utilisateur'])) {
    header("Location: login.php");
    exit;
}

require_once 'includes/confiig.php';

$id_utilisateur = $_SESSION['utilisateur']['id'];

try {
    $query = "
        SELECT r.date_reservation, r.date_arrivee, r.date_depart, r.nb_personnes, h.nom_hotel, h.adresse
        FROM reservations r
        JOIN hotels h ON r.hotel_id = h.id
        WHERE r.utilisateur_id = :id_utilisateur
        ORDER BY r.date_reservation DESC
    ";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute(['id_utilisateur' => $id_utilisateur]);
    $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur lors de la récupération des réservations : " . $e->getMessage());
}
?>

<?php include 'includes/header.php'; ?>

<section>
  <h2>Mes Réservations</h2>

  <?php if (count($reservations) === 0): ?>
    <p>Vous n’avez pas encore effectué de réservation.</p>
  <?php else: ?>
    <table border="1" cellpadding="8" cellspacing="0" style="width: 100%; margin-top: 20px; border-collapse: collapse;">
      <thead>
        <tr style="background-color: #f0f0f0;">
          <th>Hôtel</th>
          <th>Adresse</th>
          <th>Date de réservation</th>
          <th>Date d’arrivée</th>
          <th>Date de départ</th>
          <th>Nombre de personnes</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($reservations as $res): ?>
          <tr>
            <td><?= htmlspecialchars($res['nom_hotel']) ?></td>
            <td><?= htmlspecialchars($res['adresse']) ?></td>
            <td><?= htmlspecialchars($res['date_reservation']) ?></td>
            <td><?= htmlspecialchars($res['date_arrivee']) ?></td>
            <td><?= htmlspecialchars($res['date_depart']) ?></td>
            <td><?= htmlspecialchars($res['nb_personnes']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</section>

<?php include 'includes/footer.php'; ?>
