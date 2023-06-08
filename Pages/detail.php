<?php
	session_start();

	// Vérifier si l'utilisateur est connecté
	if (!isset($_SESSION['pseudo'])) {
		header("Location: login.php");
		exit();
	}

	if (!isset($_GET['id'])) {
		echo 'Vous devez avoir choisi une question dans le forum pour voir sa réponse. Redirection...';
		echo '<meta http-equiv="refresh" content="3;URL=consultation_2.php">';
		exit();
	}


	/* Connexion à la base de données */
	$conn = @mysqli_connect("tp-epua:3308", "chafikya", "61md4vj3");

	if (mysqli_connect_errno()) {
	$msg = "Erreur de connexion à la base de données : " . mysqli_connect_error();
	} else {
	$msg = "Connecté au serveur " . mysqli_get_host_info($conn);

	/* Sélection de la base de données */
	mysqli_select_db($conn, "chafikya");

	/* Encodage UTF8 pour les échanges avec la BD */
	mysqli_query($conn, "SET NAMES UTF8");
	}

	$id_Question = $_GET['id'];
	$sql = "SELECT * FROM question WHERE id_question = $id_Question";
	$result = mysqli_query($conn, $sql);
	$ligne = mysqli_fetch_assoc($result);

	$sql2 = "SELECT * FROM reponse WHERE id_question = $id_Question";
	$result2 = mysqli_query($conn, $sql2);
	$rep = mysqli_fetch_assoc($result2);
                            
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Détail de la question</title>
    <!-- Inclure les fichiers CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body id="page-top">
    <div id="wrapper">
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid">
                    <a href="consultation_2.php" class="btn btn-primary mt-3 mb-4"><i class="fas fa-arrow-left me-2"></i>Retourner au forum</a>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h1 class="h3 mb-0"><?= $ligne['titre'] ?></h1>
							<p><em><small>Date de publication : <?= $ligne['date_question'] ?></small></em></p>
                        </div>
                        <div class="card-body">
                            <h2 class="h4 mb-3">Contenu de la question : </h2>
							<p><?= $ligne['contenu'] ?></p>
                            <hr>
                            <h3 class="h4 mb-3">Réponse : </h3>
							<p><?= $rep['contenu_rep'] ?></p>
                        </div>
                        <?php
                        if ($_SESSION['statut'] == 1) {
                            echo "<div class=\"card-footer\"><a href=\"modif.php?id=" . $id_Question . "\" class=\"btn btn-primary\">Modifier la question</a></div>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>