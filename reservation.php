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

if (!isset($_GET['hotel_id']) || !is_numeric($_GET['hotel_id'])) {
    $error = "Aucun hotel selectionne.";
} else {
    $hotel_id = (int) $_GET['hotel_id'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM hotels WHERE id = :id");
        $stmt->execute(['id' => $hotel_id]);
        $hotel = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$hotel) {
            $error = "Hotel introuvable.";
        }
    } catch (PDOException $e) {
        $error = "Erreur : " . $e->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $hotel) {
    $date_arrivee = $_POST['date_arrivee'];
    $date_depart = $_POST['date_depart'];
    $nb_personnes = (int) $_POST['nb_personnes'];
    $utilisateur_id = $_SESSION['utilisateur']['id'];

    if ($date_depart <= $date_arrivee) {
        $error = "La date de depart doit etre apres la date d'arrivee.";
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

            $success = "Reservation confirmee a l'hotel " . htmlspecialchars($hotel['nom_hotel']) . " !";
        } catch (PDOException $e) {
            $error = "Erreur lors de la reservation : " . $e->getMessage();
        }
    }
}
?>

<?php include 'includes/header.php'; ?>

<section>
  <h2>Reserver un Hotel</h2>

  <?php if ($success): ?>
    <div style="text-align: center; padding: 30px;">
      <p style="color: #155724; background: #d4edda; padding: 20px; border-radius: 12px; font-size: 1.2em;">
        <?= $success ?>
      </p>
      <a href="mes_reservations.php" class="button" style="margin-top: 20px;">Voir mes reservations</a>
      <a href="hotels.php" class="button" style="margin-top: 20px; background: linear-gradient(135deg, #6c757d 0%, #495057 100%);">Retour aux hotels</a>
    </div>
  <?php elseif ($error && !$hotel): ?>
    <div style="text-align: center; padding: 30px;">
      <p style="color: #721c24; background: #f8d7da; padding: 20px; border-radius: 12px;">
        <?= htmlspecialchars($error) ?>
      </p>
      <a href="hotels.php" class="button" style="margin-top: 20px;">Voir les hotels</a>
    </div>
  <?php elseif ($hotel): ?>

    <div class="site-card" style="max-width: 600px; margin: 0 auto 30px;">
      <?php if (!empty($hotel['image_path'])): ?>
        <img src="images/<?= htmlspecialchars($hotel['image_path']) ?>" alt="<?= htmlspecialchars($hotel['nom_hotel']) ?>">
      <?php endif; ?>

      <h3><?= htmlspecialchars($hotel['nom_hotel']) ?></h3>

      <div class="etoiles">
        <?php for ($i = 0; $i < $hotel['etoiles']; $i++): ?>&#9733;<?php endfor; ?>
      </div>

      <p style="padding: 0 20px;"><?= htmlspecialchars($hotel['adresse']) ?></p>

      <?php if (!empty($hotel['prix_moyen'])): ?>
        <p class="prix"><?= number_format($hotel['prix_moyen'], 0, ',', ' ') ?> FCFA / nuit</p>
      <?php endif; ?>
    </div>

    <?php if ($error): ?>
      <p style="color: #721c24; background: #f8d7da; padding: 12px; border-radius: 8px; text-align: center; max-width: 500px; margin: 0 auto 20px;">
        <?= htmlspecialchars($error) ?>
      </p>
    <?php endif; ?>

    <form method="POST" action="reservation.php?hotel_id=<?= $hotel['id'] ?>">
      <label for="date_arrivee">Date d'arrivee</label>
      <input type="date" id="date_arrivee" name="date_arrivee" min="<?= date('Y-m-d') ?>" required>

      <label for="date_depart">Date de depart</label>
      <input type="date" id="date_depart" name="date_depart" min="<?= date('Y-m-d', strtotime('+1 day')) ?>" required>

      <label for="nb_personnes">Nombre de personnes</label>
      <input type="number" id="nb_personnes" name="nb_personnes" min="1" max="10" value="1" required>

      <button type="submit">Confirmer la reservation</button>

      <p><a href="hotels.php">Retour a la liste des hotels</a></p>
    </form>
  <?php endif; ?>
</section>

<?php include 'includes/footer.php'; ?>
