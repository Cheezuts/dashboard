<?php include 'header.php'; ?>

<!-- GESTION DES ARTICLES -->
<?php

// require_once 'app/config/Database.php';

// $database = new \App\Database('dashboard');
// $pdo = $database->getPDO();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Validate password length and pattern
    if (strlen($password) < 12 || !preg_match('#[A-Z]#', $password) || !preg_match('/[^a-zA-Z\d]/', $password)) {
        $errorMessage = 'Le mot de passe doit contenir au moins 12 caractères avec une majuscule et un caractère spécial.';
    } elseif ($password !== $confirmPassword) {
        $errorMessage = 'Les mots de passe ne correspondent pas.';
    } else {
        // Check if the email is already registered
        $stmt = $pdo->prepare("SELECT email FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $existingUser = $stmt->fetch();

        if ($existingUser) {
            $errorMessage = 'Cet email est déjà enregistré.';
        } else {
            // All validations passed, proceed with registration logic
            // Encrypt the password
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Insert the user into the database
            $stmt = $pdo->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
            $stmt->execute([$email, $hashedPassword]);

            // Redirect the user to a success page or perform any other desired actions
            header('Location: admin.php');
            exit;
        }
    }
}

?>
<?php include 'Navbar.php' ?>


<div class="container text-center">
    <div class="row p-5">
        <section id="contact">
            <div class="container">
                <div class="heading">
                    <h2>Inscription</h2>
                </div>

                <div class="row">
                    <div class="col-lg-6 offset-lg-3">
                        <form id="contact-form" method="post" action="" role="form">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="email">Email *</label>
                                    <input id="email" type="email" name="email" class="form-control" placeholder="Votre Email" required>
                                    <p class="comments"></p>
                                </div>
                                <div class="col-md-12">
                                    <label for="password">Mot de passe *</label>
                                    <input id="password" type="password" name="password" class="form-control" placeholder="Votre Mot de passe" required>
                                    <p class="comments"></p>
                                </div>
                                <div class="col-md-12">
                                    <label for="confirm_password">Confirmer le mot de passe *</label>
                                    <input id="confirm_password" type="password" name="confirm_password" class="form-control" placeholder="Confirmez votre Mot de passe" required>
                                    <p class="comments"></p>
                                </div>
                                <div class="col-md-12">
                                    <?php if (isset($errorMessage)) : ?>
                                        <p class="text-danger"><?php echo $errorMessage; ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-12">
                                    <input type="submit" class="btn btn-primary" value="Envoyer">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </section>
    </div>
</div>

<div class="container text-center">
    <div class="row p-5 text-center">
        <h2>Agence nationale de la sécurité des systèmes d'information.</h2>
        <br>
        <br>
        <h3>Les principales recommandations de la CNIL</h3>
        <p><strong>Exemple 1 :</strong> les mots de passe doivent être composés d'au minimum 12 caractères comprenant des majuscules, des minuscules, des chiffres et des caractères spéciaux à choisir dans une liste d'au moins 37 caractères spéciaux possibles.</p>
        <p><strong>Exemple 2 :</strong> les mots de passe doivent être composés d'au minimum 14 caractères comprenant des majuscules, des minuscules et des chiffres, sans caractère spécial obligatoire.</p>
        <p><strong>Exemple 3 :</strong> une phrase de passe doit être utilisée et elle doit être composée d’au minimum 7 mots.</p>
        <h3>Ceci est un message de la Commission Nationale de l'Informatique et des Libertés</h3>
    </div>
</div>

<?php include 'footer.php'; ?>