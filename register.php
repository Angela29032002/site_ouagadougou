<?php
require_once 'includes/config.php';

$success = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom']);
    $email = trim($_POST['email']);
    $telephone = trim($_POST['telephone']);
    $mot_de_passe = trim($_POST['mot_de_passe']);
    $mot_de_passe2 = trim($_POST['mot_de_passe2']);

    if ($mot_de_passe !== $mot_de_passe2) {
        $error = "❌ Les mots de passe ne correspondent pas.";
    } else {
        try {
            // Vérifier si l’email existe déjà
            $stmt = $pdo->prepare("SELECT id FROM utilisateurs WHERE email = :email");
            $stmt->execute(['email' => $email]);

            if ($stmt->fetch()) {
                $error = "⚠️ Cet email est déjà utilisé.";
            } else {
                // Hasher le mot de passe pour la securite
                $mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

                $stmt = $pdo->prepare("INSERT INTO utilisateurs (nom, email, mot_de_passe, telephone)
                                       VALUES (:nom, :email, :mot_de_passe, :telephone)");
                $stmt->execute([
                    'nom' => $nom,
                    'email' => $email,
                    'mot_de_passe' => $mot_de_passe_hash,
                    'telephone' => $telephone
                ]);

                $success = "✅ Compte créé avec succès ! <a href='login.php'>Se connecter</a>";
            }
        } catch (PDOException $e) {
            $error = "Erreur lors de l'inscription : " . $e->getMessage();
        }
    }
}
?>

<?php include 'includes/header.php'; ?>

<section>
  <h2>Créer un compte</h2>

  <?php if ($success): ?>
    <p style="color: green;"><?= $success ?></p>
  <?php elseif ($error): ?>
    <p style="color: red;"><?= $error ?></p>
  <?php endif; ?>

  <form method="POST" action="register.php">
    <label for="nom">Nom complet :</label>
    <input type="text" id="nom" name="nom" required>

    <label for="email">Adresse e-mail :</label>
    <input type="email" id="email" name="email" required>

    <label for="telephone">Téléphone :</label>
    <input type="text" id="telephone" name="telephone" required>

    <label for="mot_de_passe">Mot de passe :</label>
    <input type="password" id="mot_de_passe" name="mot_de_passe" required>

    <label for="mot_de_passe2">Confirmer le mot de passe :</label>
    <input type="password" id="mot_de_passe2" name="mot_de_passe2" required>

    <button type="submit">Créer le compte</button>
  </form>
</section>

<?php include 'includes/footer.php'; ?>
