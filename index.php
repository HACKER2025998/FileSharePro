<?php
// ----------------------------------------------------
// Logique de Traitement du Téléversement (PHP)
// ----------------------------------------------------

$message = '';
$upload_dir = 'uploads/';

// Assurez-vous que le dossier 'uploads' existe
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['fichier'])) {
    $file = $_FILES['fichier'];

    // 1. Vérification des erreurs
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $message = "❌ Erreur de téléversement. Code : " . $file['error'];
    }

    // 2. Vérification de la taille (Exemple : max 5MB)
    elseif ($file['size'] > 5 * 1024 * 1024) { 
        $message = "❌ Fichier trop volumineux. Max : 5 Mo.";
    }

    // 3. Assainissement du nom de fichier pour la sécurité
    $nom_fichier_propre = basename($file['name']);
    $destination = $upload_dir . $nom_fichier_propre;

    // 4. Déplacement du fichier
    if (move_uploaded_file($file['tmp_name'], $destination)) {
        $message = "Fichier **" . htmlspecialchars($nom_fichier_propre) . "** téléversé avec succès !";
    } else {
        $message = "❌ Une erreur est survenue lors du déplacement du fichier.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FileShare Pro - Partage Rapide</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header>
        <h1> FileShare Pro</h1>
        <p>Je partage mes fichiers rapidement et en toute simplicité. Ne charger pas de fichiers s'il vous  plais , ne faite que telecharger Merci</p>
    </header>

    <main class="container">
        <section class="upload-section card">
            <h2> Téléverser un Fichier</h2>
            
            <?php if ($message): ?>
                <p class="feedback-message"><?php echo $message; ?></p>
            <?php endif; ?>

            <form action="index.php" method="POST" enctype="multipart/form-data">
                <label for="fichier">Choisir le fichier :</label>
                <input type="file" name="fichier" id="fichier" required>
                <button type="submit" class="btn primary">Envoyer le Fichier</button>
            </form>
        </section>

        <hr>

        <section class="file-list-section card">
            <h2> Fichiers Disponibles</h2>

            <?php
            // Affichage des fichiers
            $fichiers = array_diff(scandir($upload_dir), array('.', '..', '.htaccess'));
            
            if (empty($fichiers)) {
                echo "<p>Aucun fichier n'est disponible pour le moment.</p>";
            } else {
                echo "<ul>";
                foreach ($fichiers as $fichier) {
                    $chemin = $upload_dir . $fichier;
                    $taille = round(filesize($chemin) / (1024 * 1024), 2); // Taille en Mo
                    echo "<li>";
                    echo "<span>📂 **" . htmlspecialchars($fichier) . "** ({$taille} Mo)</span>";
                    // Le lien 'download.php' sera l'endroit le plus sûr pour télécharger
                    echo "<a href='" . htmlspecialchars($chemin) . "' download='" . htmlspecialchars($fichier) . "' class='btn secondary'>Télécharger</a>";
                    echo "</li>";
                }
                echo "</ul>";
            }
            ?>
        </section>

        

    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> FileShare Pro. Developper par Bernard. Toute injection sql est rediriger vers l'hote d'emmision /  bonne chance</p>
    </footer>

</body>
</html>
