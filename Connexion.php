<?php include 'header.php'; ?>

<!-- GESTION DES ARTICLES -->
<?php

require_once 'app/config/Database.php';

// $database = new \App\Database('dashboard');
// $pdo = $database->getPDO();

// Définir une variable pour stocker le message de résultat de la connexion
$loginMessage = '';

// Vérifier si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Récupérer l'utilisateur depuis la base de données en fonction de l'email
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Le mot de passe est correct, procéder à la logique de connexion
        // Démarrer la session de l'utilisateur ou effectuer d'autres actions souhaitées
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['loggedIn'] = true;

        // Rediriger l'utilisateur vers le tableau de bord ou effectuer d'autres actions souhaitées
        header('Location: admin.php');
        exit;
    } else {
        // Email ou mot de passe incorrect
        $loginMessage = 'Email ou mot de passe incorrect.';
    }
}

?>
<?php include 'Navbar.php' ?>

<div class="container text-center">
    <div class="row p-5">
        <section id="login">
            <div class="container">
                <div class="heading">
                    <h2>Connexion</h2>
                </div>
                <div class="row">
                    <div class="col-lg-6 offset-lg-3">
                        <form id="login-form" method="post" action="" role="form">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="email">Email</label>
                                    <input id="email" type="email" name="email" class="form-control" placeholder="Votre Email" required>
                                    <p class="comments"></p>
                                </div>
                                <div class="col-md-12">
                                    <label for="password">Mot de passe</label>
                                    <input id="password" type="password" name="password" class="form-control" placeholder="Votre Mot de passe" required>
                                    <p class="comments"></p>
                                </div>
                                <div class="col-md-12">
                                    <input type="submit" class="btn btn-primary" value="Se connecter">
                                </div>
                            </div>
                        </form>
                        <?php if ($loginMessage) : ?>
                            <div class="mt-3">
                                <p class="text-danger"><?php echo $loginMessage; ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<?php include 'footer.php'; ?>