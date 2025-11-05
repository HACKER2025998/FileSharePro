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
        <section>

        <h1> source WIKIPEDIA</h1>
        <br>
        <br>
        
            Bien que les prémices du développement de la fonction de documentation apparaissent au cours du XIXe siècle, Paul Otlet et Henri Lafontaine, avocats belges, sont classiquement présentés comme les précurseurs et parfois même les inventeurs de l’actuelle documentation. L’ouvrage essentiel d’Otlet, Traité de documentation (1934), est un élément central dans l’histoire de la documentation et ses techniques. Durant la première moitié du XXe siècle, l’industrialisation entraîne une production d’information intense : par conséquent, des techniques de collecte et de traitement de l’information sont élaborées en même temps que se mettent en place des services de documentation autour de pôles économiques. En France, les premières normes en matière de documentation apparaissent en 1943[2], et le terme même de « documentation » tend à s’imposer et le documentaliste se distingue toujours plus du bibliothécaire.
Mais c’est davantage après la Seconde guerre mondiale que l’on assiste à un phénomène d’explosion documentaire : l’accroissement du nombre de documents toutes catégories confondues devient exponentiel. Les progrès technologiques, notamment informatiques, permettent aux professionnels de la documentation d’augmenter et automatiser le travail de collecte, traitement et de gestion des données. Dans les années 1970, les « sciences de l’information » apparaissent dans le vocabulaire courant et le premier DESS en documentation et sciences de l’information est créé.

La documentation demeure toujours présente dans les nouveaux environnements numériques et elle est même probablement plus légitime dans le numérique ce que montre Olivier Le Deuff dans son ouvrage La Documentation dans le numérique[3] en rappelant que l'héritage de la pensée de Paul Otlet est à faire fructifier et que les conceptions d'Otlet allaient bien au-delà du livre papier.
Fonctions

Au cours du XXe siècle, la documentation devient donc une « discipline scientifique avec ses techniques et ses méthodes propres. Elle fait appel à des sciences comme la linguistique, les mathématiques, l’informatique. Elle possède sa propre littérature comme en témoignent les nombreuses revues spécialisées françaises et étrangères. La documentation est devenue véritablement le traitement de l'information […] sous toutes ses formes »[4].

Ainsi, le terme « documentation » recouvre en réalité plusieurs idées[5] : une collection de documents organisée en vue d’une diffusion d’information, l’action de se documenter, l’activité professionnelle ou la fonction exercée par les documentalistes, le service de documentation au sein d’une entreprise.

La fonction principale de la documentation est de rendre accessible l’information à l’utilisateur ayant un besoin de connaissances. Une suite d’opérations est nécessaire afin de remplir au mieux cet objectif, et ces opérations constituent ce qui est couramment appelé la « chaîne documentaire » : la collecte, le traitement et la diffusion de l’information.

    La collecte des informations, quel que soit leur support, consiste au repérage (par le biais de sources bibliographiques que le documentaliste peut recouper entre elles), au tri et à l’acquisition des documents (par achat, abonnements...).

    Le traitement est le classement et l’exploitation des documents ; autrement dit, c’est l’extraction et la mise en forme accessible (sous forme de fiche par exemple) de l’information pertinente contenue dans le document. Ce traitement est réalisé à l'aide d'outils propres aux professionnels de l'information et de la documentation tels que les langages documentaires, contrôlés (par exemple les langages classificatoires type RAMEAU), qui s'opposent au langage naturel (bien que celui-ci puisse être utilisé par les utilisateurs pour leurs recherches). Parmi les nombreux outils disponibles, on peut encore citer l'indexation et le catalogage.

    La diffusion de l’information ainsi traitée peut se faire de différentes manières : de façon générale ou sélective selon la nature de l’information et de ses destinataires, de façon orale ou écrite, par réponse ponctuelle, par prêt, par résumé, synthèse, note de veille[6]… La diffusion de l'information peut également se faire par le biais de produits documentaires (documents créés par le service). Ces produits peuvent être élémentaires ou élaborés (type revue de presse, bulletin documentaire), interactifs (foires aux questions, blogs...), et apportent une valeur ajoutée en ce qu'ils traitent et ordonnent l'information qu'ils transmettent aux utilisateurs[7].

Néanmoins, ces différentes opérations sont coûteuses en temps et en ressources et nécessitent des structures adaptées. C’est donc généralement au sein de services organisés que s’effectue le travail documentaire. Les dénominations sont nombreuses pour qualifier un service de documentation : centre ou service de documentation, de ressources documentaires, de traitement des données … Cependant, les objectifs de ces institutions sont généralement les mêmes : acquérir, rassembler, traiter, organiser l’information sur tout support, rendre l’information accessible, délivrer une information d’actualité, pertinente, fiable et de qualité[8].

Si leur taille peut varier suivant les entreprises ou organisations au sein desquelles ils existent, les services d’information-documentation n’en restent pas moins des services stratégiques car l’information (économique, politique, commerciale, technologique…) est une ressource vitale pour les entreprises, ce qui amène beaucoup d’entre elles à intégrer à leur service de documentation une fonction de veille.
Documentation et droit

L’information que traite la documentation est soumise à toutes sortes de lois qui viennent façonner les pratiques des professionnels de l’information. En effet, de nombreux textes juridiques sont applicables à la documentation : la loi Informatique et libertés (qui touche un documentaliste dans sa relation avec l'usager), la loi sur l’accès aux documents administratifs, les lois régissant la propriété intellectuelle (droit d’auteur, droit de reproduction, droit à l’image), le dépôt légal et versement aux archives… Sans oublier qu’Internet et les banques de données utilisés par ces professionnels sont également soumis aux dispositions légales nationales et internationales.

Ainsi, les produits documentaires créés par un service de documentation doivent respecter l’ensemble de ces lois.

Par exemple, un panorama de presse se définit comme « l’ensemble des représentations ou reproductions, dans leur intégralité ou non, d’articles parus dans différentes publications de presse consacrées à un ou plusieurs thèmes, réalisées selon une périodicité déterminée et mises à disposition pendant une durée limitée »[9]. Il est donc soumis au droit de reproduction et il faut donc obtenir un contrat d’autorisation du Centre français d'exploitation du droit de copie (CFC) et acquitter les droits d’auteur pour pouvoir avoir légalement le droit d’en produire un. Ce qui entraîne assez souvent un casse-tête juridique et financier pour les responsables des services de documentation. En effet, les documentalistes et professionnels de l'information et de la documentation doivent rester vigilants car leur responsabilité professionnelle peut être mise en cause, en particulier dans le cas d'une tarification des services documentaires (l'usager attend un service de qualité pour le prix payé).

Afin de prévenir toute erreur (diffusion d'une information fausse par exemple), il est nécessaire pour les professionnels de se tenir informés de l'état du droit, d'effectuer des contrôles qualité et de définir des priorités par rapport aux services et aux utilisateurs[10].
Notes et références

Accart, Jean-Philippe, Réthy, Marie-Pierre,Le métier de documentaliste, Paris, Éditions du Cercle de la Librairie, 3e édition, 2008, pages 403
Chaumier Jacques, Les techniques documentaires, Paris, P.U.F. coll. « Que sais-je ? », 7e éd., 1994, page 5
Le Deuff, Olivier, La Documentation dans le numérique, Villeurbanne, Enssib, 2014, 224 p (ISBN 979-10-91281-32-4), http://www.enssib.fr/sites/www/files/documents/presses-enssib/extrait/le_deuff_intro.pdf [archive]
Chaumier Jacques, Les techniques documentaires, Paris, P.U.F., coll. « Que sais-je ? », 7e éd., 1994, page 9.
Accart, Jean-Philippe, Réthy, Marie-Pierre, Le métier de documentaliste, Paris, Éditions du Cercle de la Librairie, 3e édition, 2008, page 112
ces différents points sont repris du livre de J-P Accart et M-P Réthy
Idem
Accart, Jean-Philippe, Réthy, Marie-Pierre, Le métier de documentaliste, Paris, Éditions du Cercle de la Librairie, 3e édition, 2008, p. 114
Ibid. p. 335

    Ibid. p. 330

Voir aussi
Bibliographie

    Suzanne Briet (fondatrice de l'INTD), Qu’est-ce que la documentation ?. Ouvrage de référence, mais ancien et épuisé.
    Chaumier, Jacques, Les techniques documentaires, 9e éd., Paris, P.U.F., coll. « Que sais-je ? », 2002, 128 p.
    J. Chaumier, F. Gicquel, Les techniques documentaires au fil de l'histoire (1950-2000), Paris, Tec & Doc, 2003, 176 p. (ISBN 2-84365-064-X)
    Accart, Jean-Philippe; Réthy, Marie-Pierre, Le métier de documentaliste, Paris, Électre-Éditions du Cercle de la Librairie, 4e édition, 2015, 425 p.

Articles connexes

    Chaîne documentaire
    Document
    Documentaliste
    Document informatique
    Documentation logicielle
    Recherche d'information
    Rédacteur de documentation
    Société de l'information
    Système d'information
    Traitement de l'information
    Sciences de l'information et de la communication
        </section>

    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> FileShare Pro. Developper par Bernard. Toute injection sql est rediriger vers l'hote d'emmision /  bonne chance</p>
    </footer>

</body>
</html>
