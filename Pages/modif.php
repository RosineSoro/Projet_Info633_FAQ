<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['pseudo'])) {
	header("Location: login.php");
	exit();
}


if ($_SESSION['statut'] == 0) {
    echo "Tu n'as pas accès à cette page en tant qu'étudiant. Redirection vers le forum...";
    echo '<meta http-equiv="refresh" content="3;URL=consultation_2.php">';
    exit();
}

/* Connexion à la base de données */
$conn = @mysqli_connect("tp-epua:3308", "chafikya", "61md4vj3");

if (mysqli_connect_errno()) {
    $msg = "Erreur de connexion à la base de données : " . mysqli_connect_error();
    exit($msg);
}

/* Sélection de la base de données */
mysqli_select_db($conn, "chafikya");
mysqli_query($conn, "SET NAMES UTF8");

$error = ""; // Variable pour stocker les éventuelles erreurs

if (isset($_POST['valider'])) {
    $id_Question = $_GET['id'];
    $id_compte = $_SESSION['id_compte'];
    $titre = $_POST['titre'];
    $question = $_POST['question'];
    $reponse = $_POST['reponse'];

    if (empty(trim($reponse))) {
        $error_empty_answer = "Veuillez saisir une réponse.";
    } else {
        $sql1 = "UPDATE question SET titre = '$titre', contenu = '$question', verif = 1 WHERE id_question = $id_Question";
        $sql2 = "UPDATE reponse SET contenu_rep = '$reponse' WHERE id_question = $id_Question";
        $sql3 = "INSERT INTO log_rep (id_compte, id_question, date_rep) VALUES ('$id_compte', '$id_Question', NOW())";

        $result1 = mysqli_query($conn, $sql1);
        if (!$result1) {
            $error = 'Erreur SQL : ' . mysqli_error($conn);
        }

        $result2 = mysqli_query($conn, $sql2);
        if (!$result2) {
            $error = 'Erreur SQL : ' . mysqli_error($conn);
        }

        $result3 = mysqli_query($conn, $sql3);
        if (!$result2) {
            $error = 'Erreur SQL : ' . mysqli_error($conn);
        }

        if (empty($error)) {
            header("Location: attente_2.php");
            exit();
        }
    }
}

if (isset($_POST['supprimer'])) {
    $id_Question = $_GET['id'];

    $sql = "DELETE FROM question WHERE id_question = $id_Question";
    $result1 = mysqli_query($conn, $sql);
    if (!$result1) {
        $error = 'Erreur SQL : ' . mysqli_error($conn);
    }

    if (empty($error)) {
        header("Location: attente_2.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modifier les questions</title>
    <link rel="stylesheet" type="text/css" href="modif.css">
</head>
<body>
    <h1>Page de modification</h1>

    <?php
    $id_Question = $_GET['id'];
    $id_compte = $_SESSION['id_compte'];
    $sql = "SELECT * FROM question WHERE id_question = $id_Question";
    $result = mysqli_query($conn, $sql);
    $ligne = mysqli_fetch_assoc($result);
    $sql2 = "SELECT * FROM reponse WHERE id_question = $id_Question";
    $result2 = mysqli_query($conn, $sql2);
    $rep = mysqli_fetch_assoc($result2);
    ?>

    <div id='form-content'>
        <form method="post">
            <div class='mb-3'>
                <label class="form-label">Titre de la question :</label>
                <textarea cols='40' rows='5' class='modif' name='titre'><?= $ligne['titre'] ?></textarea>
            </div>
            <div class='mb-3'>
                <label class="form-label">Contenu de la question :</label>
                <textarea cols='40' rows='5' class='modif' name='question'><?= $ligne['contenu'] ?></textarea>
            </div>
            <div class='mb-3'>
                <label class="form-label">Réponse à la question :</label>
				<?php
				if (!empty($error_empty_answer)) {
					echo '<p style="color: red;">' . $error_empty_answer . '</p>';
				}
				?>
                <textarea cols='40' rows='5' class='modif' name='reponse' placeholder='Tapez votre réponse ici'><?= $rep['contenu_rep'] ?></textarea>
            </div>
            <div class='bouton'>
                <button type='submit' class='btn' name='valider'>Submit</button>
                <button name='supprimer' type='submit'>Supprimer</button>
            </div>
        </form>
    </div>
</body>
</html>