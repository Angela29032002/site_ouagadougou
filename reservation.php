<?php
session_start();

if (!isset($_SESSION['utilisateur'])) {
    header('Location: login.php');
    exit;
}

require_once 'includes/config.php';

$success = "";
$error = "";
$hotel = null;

// Vérification de l'hôtel sélectionné
if (!isset($_GET['hotel_id']) || !is_numeric($_GET['hotel_id'])) {
    $error = "Aucun hôtel sélectionné.";
} else {
    $hotel_id = (int) $_GET['hotel_id'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM hotels WHERE id = :id");
        $stmt->execute(['id' => $hotel_id]);
        $hotel = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$hotel) {
            $error = "Hôtel introuvable.";
        }
    } catch (PDOException $e) {
        $error = "Erreur : " . $e->getMessage();
    }
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $hotel) {
    $date_arrivee = $_POST['date_arrivee'];
    $date_depart = $_POST['date_depart'];
    $nb_personnes = (int) $_POST['nb_personnes'];
    $utilisateur_id = $_SESSION['utilisateur']['id'];

    if ($date_depart < $date_arrivee) {
        $error = "La date de départ ne peut pas être antérieure à la date d’arrivée.";
    } else {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO reservations (utilisateur_id, hotel_id, date_arrivee, date_depart, nb_personnes)
                VALUES (:utilisateur_id, :hotel_id, :date_arrivee, :date_depart, :nb_personnes)
            ");
            $stmt->execute([
                'utilisateur_id' => $utilisateur_id,
                'hotel_id' => $hotel_id,
                'date_arrivee' => $date_arrivee,
                'date_depart' => $date_depart,
                'nb_personnes' => $nb_personnes
            ]);

            $success = "Réservation confirmée à l’hôtel « " . htmlspecialchars($hotel['nom_hotel']) . " » 🎉";
        } catch (PDOException $e) {
            $error = "Erreur lors de la réservation : " . $e->getMessage();
        }
    }
}
?>

<?php include 'includes/header.php'; ?>

<section>
  <h2>Réserver un hôtel</h2>

  <?php if ($success): ?>
    <p style="color: green;"><?= $success ?></p>
  <?php elseif ($error): ?>
    <p style="color: red;"><?= $error ?></p>
  <?php endif; ?>

  <?php if ($hotel): ?>
    <div class="site-card">
      <?php if (!empty($hotel['image_path'])): ?>
        <img src="images/<?= htmlspecialchars($hotel['image_path']) ?>" alt="<?= htmlspecialchars($hotel['nom_hotel']) ?>" style="max-width: 400px; border-radius: 10px;">
      <?php endif; ?>

      <h3><?= htmlspecialchars($hotel['nom_hotel']) ?></h3>
      <p><strong>Adresse :</strong> <?= htmlspecialchars($hotel['adresse']) ?></p>
      <p><?= nl2br(htmlspecialchars($hotel['description'])) ?></p>
    </div>

    <form method="POST" action="reservation.php?hotel_id=<?= $hotel['id'] ?>" style="margin-top: 20px;">
      <label for="date_arrivee">Date d’arrivée :</label>
      <input type="date" id="date_arrivee" name="date_arrivee" required>

      <label for="date_depart">Date de départ :</label>
      <input type="date" id="date_depart" name="date_depart" required>

      <label for="nb_personnes">Nombre de personnes :</label>
      <input type="number" id="nb_personnes" name="nb_personnes" min="1" required>

      <button type="submit">Confirmer la réservation</button>
    </form>
  <?php endif; ?>
</section>

<?php include 'includes/footer.php'; ?>
