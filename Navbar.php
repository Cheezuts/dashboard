<div class="container-fluid sticky-top">
    <nav class="navbar navbar-expand-lg p-0 m-0 navbar-dark bg-dark">
        <a href="index.php" class="navbar-brand">
            <h1 class="headline text-white">Accueil</h1>
        </a>
        <button type="button" class="navbar-toggler ms-auto me-0 bg-dark" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a href="Inscription.php" class="nav-link text-white">Inscription</a>
                </li>
                <?php if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']) : ?>
                    <!-- Afficher le lien Admin uniquement si l'utilisateur est connecté -->
                    <li class="nav-item">
                        <a href="Admin.php" class="nav-link text-white">Admin</a>
                    </li>
                <?php endif; ?>
                <?php if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']) : ?>
                    <!-- Afficher le lien de déconnexion uniquement si l'utilisateur est connecté -->
                    <li class="nav-item">
                        <a href="index.php?logout=true" class="nav-link text-white">Déconnexion</a>
                    </li>
                <?php else : ?>
                    <!-- Afficher le lien de connexion si l'utilisateur n'est pas connecté -->
                    <li class="nav-item">
                        <a href="Connexion.php" class="nav-link text-white">Connexion</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
</div>