<?php
session_start();
require_once 'includes/config.php';

// Rediriger si deja connecte
if (isset($_SESSION['utilisateur'])) {
    header('Location: hotels.php');
    exit;
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $mot_de_passe = trim($_POST['mot_de_passe']);

    try {
        $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($mot_de_passe, $user['mot_de_passe'])) {
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
        $error = "Erreur de connexion. Veuillez reessayer.";
    }
}
?>

<?php include 'includes/header.php'; ?>

<section>
  <h2>Connexion</h2>

  <form method="POST" action="login.php">
    <?php if ($error): ?>
      <p style="color: #e74c3c; background: #fdecea; padding: 12px; border-radius: 8px; text-align: center;">
        <?= htmlspecialchars($error) ?>
      </p>
    <?php endif; ?>

    <label for="email">Adresse e-mail</label>
    <input type="email" name="email" id="email" placeholder="votre@email.com" required>

    <label for="mot_de_passe">Mot de passe</label>
    <input type="password" name="mot_de_passe" id="mot_de_passe" placeholder="Votre mot de passe" required>

    <button type="submit">Se connecter</button>

    <p>Pas encore de compte ? <a href="register.php">Creer un compte</a></p>
  </form>
</section>

<?php include 'includes/footer.php'; ?>
