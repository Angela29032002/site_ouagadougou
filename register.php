<?php
session_start();
require_once 'includes/config.php';

// Rediriger si deja connecte
if (isset($_SESSION['utilisateur'])) {
    header('Location: hotels.php');
    exit;
}

$success = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom']);
    $email = trim($_POST['email']);
    $telephone = trim($_POST['telephone']);
    $mot_de_passe = trim($_POST['mot_de_passe']);
    $mot_de_passe2 = trim($_POST['mot_de_passe2']);

    if ($mot_de_passe !== $mot_de_passe2) {
        $error = "Les mots de passe ne correspondent pas.";
    } elseif (strlen($mot_de_passe) < 6) {
        $error = "Le mot de passe doit contenir au moins 6 caracteres.";
    } else {
        try {
            $stmt = $pdo->prepare("SELECT id FROM utilisateurs WHERE email = :email");
            $stmt->execute(['email' => $email]);

            if ($stmt->fetch()) {
                $error = "Cet email est deja utilise.";
            } else {
                $mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

                $stmt = $pdo->prepare("INSERT INTO utilisateurs (nom, email, mot_de_passe, telephone)
                                       VALUES (:nom, :email, :mot_de_passe, :telephone)");
                $stmt->execute([
                    'nom' => $nom,
                    'email' => $email,
                    'mot_de_passe' => $mot_de_passe_hash,
                    'telephone' => $telephone
                ]);

                $success = "Compte cree avec succes !";
            }
        } catch (PDOException $e) {
            $error = "Erreur lors de l'inscription. Veuillez reessayer.";
        }
    }
}
?>

<?php include 'includes/header.php'; ?>

<section>
  <h2>Creer un compte</h2>

  <form method="POST" action="register.php">
    <?php if ($success): ?>
      <p style="color: #155724; background: #d4edda; padding: 12px; border-radius: 8px; text-align: center;">
        <?= $success ?> <a href="login.php" style="color: #005a87; font-weight: bold;">Se connecter</a>
      </p>
    <?php elseif ($error): ?>
      <p style="color: #721c24; background: #f8d7da; padding: 12px; border-radius: 8px; text-align: center;">
        <?= htmlspecialchars($error) ?>
      </p>
    <?php endif; ?>

    <label for="nom">Nom complet</label>
    <input type="text" id="nom" name="nom" placeholder="Votre nom" required>

    <label for="email">Adresse e-mail</label>
    <input type="email" id="email" name="email" placeholder="votre@email.com" required>

    <label for="telephone">Telephone</label>
    <input type="text" id="telephone" name="telephone" placeholder="+226 70 00 00 00" required>

    <label for="mot_de_passe">Mot de passe</label>
    <input type="password" id="mot_de_passe" name="mot_de_passe" placeholder="Minimum 6 caracteres" required>

    <label for="mot_de_passe2">Confirmer le mot de passe</label>
    <input type="password" id="mot_de_passe2" name="mot_de_passe2" placeholder="Confirmez votre mot de passe" required>

    <button type="submit">Creer mon compte</button>

    <p>Deja inscrit ? <a href="login.php">Se connecter</a></p>
  </form>
</section>

<?php include 'includes/footer.php'; ?>
