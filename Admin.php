<?php include 'header.php'; ?>

<?php
if (isset($_POST['checkBoxArray'])) {
    foreach ($_POST['checkBoxArray'] as $checkBoxValue) {
        $bulk_options = $_POST['bulk_options'];

        switch ($bulk_options) {
            case 'delete':
                $query = "DELETE FROM file WHERE id = $checkBoxValue";
                $statement = $pdo->query($query);
                break;
            case 'clone':
                $query = "SELECT * FROM file WHERE id = $checkBoxValue";
                $statement = $pdo->query($query);
                $files = $statement->fetchAll(PDO::FETCH_ASSOC);

                foreach ($files as $file) {
                    $file_name = $file['name'];
                }

                $query = "INSERT INTO file (name) VALUES (?)";
                $statement = $pdo->prepare($query);
                $statement->execute([$file_name]);
                break;
        }
    }
}

// Supprimer une image lorsque l'identifiant est envoyé via la méthode GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM file WHERE id = ?";
    $statement = $pdo->prepare($query);
    $statement->execute([$id]);

    // Rediriger l'utilisateur vers la même page pour actualiser la liste des images
    // Ajouter un paramètre GET pour indiquer le succès de l'action
    header("Location: admin.php");
    exit;
}
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
if (isset($_POST['checkBoxArray'])) {
    foreach ($_POST['checkBoxArray'] as $checkBoxValue) {
        $bulk_options = $_POST['bulk_options'];

        switch ($bulk_options) {
            case 'delete':
                $query = "DELETE FROM file WHERE id = $checkBoxValue";
                $statement = $pdo->query($query);
                break;
            case 'clone':
                $query = "SELECT * FROM file WHERE id = $checkBoxValue";
                $statement = $pdo->query($query);
                $files = $statement->fetchAll(PDO::FETCH_ASSOC);

                foreach ($files as $file) {
                    $file_name = $file['name'];
                }

                $query = "INSERT INTO file (name) VALUES (?)";
                $statement = $pdo->prepare($query);
                $statement->execute([$file_name]);
                break;
        }
    }
}

// Supprimer une image lorsque l'identifiant est envoyé via la méthode GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM file WHERE id = ?";
    $statement = $pdo->prepare($query);
    $statement->execute([$id]);

    // Rediriger l'utilisateur vers la même page pour actualiser la liste des images
    // Ajouter un paramètre GET pour indiquer le succès de l'action
    header("Location: admin.php");
    exit;
}
?>



<?php include 'Navbar.php' ?>









<div class="container-fluid">

    <div class="row justify-content-center">
        <div class="col-md-6 text-center p-5">
            <h1>Upload une image !</h1>
            <form action="index.php" method="POST" enctype="multipart/form-data">
                <div class="form-group p-5">
                    <label for="file"></label>
                    <input type="file" name="file" class="form-control-file btn btn-primary">
                </div>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </form>
        </div>
    </div>
</div>



<div class="table-responsive">
    <form action="" method="post">
        <div class="row">
            <div class="col-xs-12 col-sm-4">
                <div class="form-group">
                    <select name="bulk_options" id="bulk_options" class="form-control">
                        <option value="">Selectionnez une option</option>
                        <option value="delete">Supprimer</option>
                        <option value="clone">Cloner</option>
                    </select>
                </div>
            </div>

            <div class="col-xs-12 col-sm-4">
                <div class="form-group">
                    <input type="submit" name="submit" class="btn btn-success" value="Appliquer">
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>

                        <th>Id</th>
                        <th>Image</th>
                        <th>Supprimer</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Exécution de la requête SELECT
                    $query = "SELECT * FROM file";
                    $statement = $pdo->query($query);
                    $files = $statement->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($files as $file) {
                        $file_id = $file['id'];
                        $file_name = $file['name'];

                        echo "<tr>";
                        echo "<td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='$file_id'></td>";
                        echo "<td>$file_id</td>";
                        echo "<td class='text-center'><img src='upload/$file_name' alt='Image' class='img-thumbnail' style=' max-width: 100px;
                        max-height: 100px;'></td>";
                        echo "<td class='text-center'><a onClick=\"javascript: return confirm('Êtes-vous sûr de vouloir supprimer ?')\" href='admin.php?id={$file_id}'><i class='fa-solid fa-trash text-danger fa-2x'></i></a></td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        </tbody>
        </table>
</div>
</form>
</div>



<?php include 'footer.php'; ?>