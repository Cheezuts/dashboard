<?php include 'header.php'; ?>

<!-- GESTION DES ARTICLES -->
<?php


// require_once 'app/config/Database.php';

// $database = new \App\Database('dashboard');
// $pdo = $database->getPDO();

// Exécution de la requête SELECT
$query = "SELECT titre, image, texte FROM articles";
$statement = $pdo->query($query);
$articles = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<!-- GESTION DES IMAGES -->
<?php

if (isset($_FILES['file'])) {
    $tmpName = $_FILES['file']['tmp_name'];
    $name = $_FILES['file']['name'];
    $size = $_FILES['file']['size'];
    $error = $_FILES['file']['error'];

    // Récupérer l'extension du fichier
    $tabExtension = explode('.', $name);
    // Récupérer la dernière valeur du tableau ( le .jpg)
    $extension = strtolower(end($tabExtension));

    // Définir les extensions autorisées
    $extensions = ['jpg', 'png', 'jpeg', 'gif'];
    $tailleMax = 2048000;

    // Vérifier si l'extension est autorisée
    if (in_array($extension, $extensions) && $size <= $tailleMax && $error == 0) {
        // Générer un nom unique
        $uniqueName = uniqid('', true);
        // Concaténer le nom unique avec l'extension
        $fileName = $uniqueName . '.' . $extension;
        // Définir le chemin de destination
        move_uploaded_file($tmpName, 'upload/' . $fileName);
        echo '<div class="text-center text-white bg-success fs-2 fw-bold">Le fichier a bien été uploadé.</div>';

        // Exécution de la requête INSERT
        $query = "INSERT INTO file (name) VALUES (?)";
        $statement = $pdo->prepare($query);
        $statement->execute([$fileName]);
    } else {
        $errorMessage = '';

        // Vérifier l'erreur de taille du fichier
        if ($error === UPLOAD_ERR_INI_SIZE || $error === UPLOAD_ERR_FORM_SIZE || $size > $tailleMax) {
            $errorMessage = 'Le fichier est trop volumineux. Veuillez choisir un fichier plus petit.';
        }
        // Vérifier l'erreur d'extension
        elseif (!in_array($extension, $extensions)) {
            $errorMessage = 'L\'extension du fichier n\'est pas autorisée. Veuillez choisir un fichier avec une extension jpg, png, jpeg ou gif.';
        }
        // Autre erreur d'upload
        else {
            $errorMessage = 'Une erreur s\'est produite lors de l\'upload du fichier.';
        }

        echo '<div class="text-center text-white bg-danger fs-2 fw-bold">' . $errorMessage . '</div>';
    }
}

?>

<?php
include 'Navbar.php';
?>






<div class="container text-center">
    <div class="row">
        <div class="col-md-12">

            <h1>Mes images</h1>
            <?php
            // Exécution de la requête SELECT
            $query = "SELECT name FROM file";
            $statement = $pdo->query($query);
            $files = $statement->fetchAll(PDO::FETCH_ASSOC);

            foreach ($files as $file) {
                echo "<img src='upload/" . $file['name'] . "' alt='Image' class='img-thumbnail'><br>";
            }
            ?>


        </div>
    </div>
</div>




<?php include 'footer.php'; ?>