<?php
session_start();
require_once 'includes/confiig.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $mot_de_passe = trim($_POST['mot_de_passe']);

    try {
        $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && $mot_de_passe === $user['mot_de_passe']) {
            // Connexion réussie
            $_SESSION['utilisateur'] = [
                'id' => $user['id'],
                'nom' => $user['nom'],
                'email' => $user['email']
            ];
            header('Location: hotels.php');
            exit;
        } else {
            $error = "Email ou mot de passe incorrect.";
        }
    } catch (PDOException $e) {
        $error = "Erreur de connexion à la base : " . $e->getMessage();
    }
}
?>

<?php include 'includes/header.php'; ?>

<section>
  <h2>Connexion à l’espace utilisateur</h2>

  <?php if ($error): ?>
    <p style="color: red;"><?= htmlspecialchars($error) ?></p>
  <?php endif; ?>

  <form method="POST" action="login.php">
    <label for="email">Adresse e-mail :</label>
    <input type="email" name="email" id="email" required>

    <label for="mot_de_passe">Mot de passe :</label>
    <input type="password" name="mot_de_passe" id="mot_de_passe" required>

    <button type="submit">Se connecter</button>

    <p>Pas de compte ? <a href="register.php">Créez-en un</a></p>

  </form>
</section>

<?php include 'includes/footer.php'; ?>
