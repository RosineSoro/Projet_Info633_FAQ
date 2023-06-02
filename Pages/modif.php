<?php
session_start();

/*Connexion à la base de données sur le serveur tp-epua*/
$conn = @mysqli_connect("tp-epua:3308", "chafikya", "61md4vj3");

/*connexion à la base de donnée depuis la machine virtuelle INFO642*/
/*$conn = @mysqli_connect("localhost", "etu", "bdtw2021");*/

if (mysqli_connect_errno()) {
    $msg = "erreur " . mysqli_connect_error();
} else {
    $msg = "connecté au serveur " . mysqli_get_host_info($conn);
    /*Sélection de la base de données*/
    mysqli_select_db($conn, "chafikya");
    /*mysqli_select_db($conn, "etu"); */ /*sélection de la base sous la VM info642*/

    /*Encodage UTF8 pour les échanges avecla BD*/
    mysqli_query($conn, "SET NAMES UTF8");
}

$error = ""; // Variable pour stocker les éventuelles erreurs

if (isset($_POST['valider'])) {
    $id_Question = $_GET['id'];
    $id_compte = $_SESSION['id_compte'];
    $titre = $_POST['titre'];
    $question = $_POST['question'];
    $reponse = $_POST['reponse'];

    $sql1 = "update question set titre =\"" . $titre . "\",contenu=\"" . $question . "\", verif=1 where id_question = " . $id_Question;
    $sql2 = "update reponse set contenu_rep=\"" . $reponse . "\" where id_question=" . $id_Question;
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
        header("Location: consultation_2.php");
        exit();
    }
}

if (isset($_POST['supprimer'])) {
    $id_Question = $_GET['id'];

    $sql = "delete from question where id_question=" . $id_Question;
    $result1 = mysqli_query($conn, $sql);
    if (!$result1) {
        $error = 'Erreur SQL : ' . mysqli_error($conn);
    }

    if (empty($error)) {
        header("Location: consultation_2.php");
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
    <h1>Modifier les questions</h1>

    <?php
    if ($_SESSION['statut'] == 0) {
        echo "Tu n'as pas accès à cette page";
    } else {
        $id_Question = $_GET['id'];
        $id_compte = $_SESSION['id_compte'];
        $sql = "select * from question where id_question =" . $id_Question;
        $result = mysqli_query($conn, $sql);
        $ligne = mysqli_fetch_assoc($result);
        $sql2 = "select * from reponse where id_question=" . $id_Question; //récupère réponse de la question.
        $result2 = mysqli_query($conn, $sql2);
        $rep = mysqli_fetch_assoc($result2);
        ?>

        <div id='form-content'>
            <form method="post">
                <div class='mb-3'>
                    <label class="form-label">Titre de la question : </label>
                    <textarea cols='40' rows='5' class='modif' name='titre'><?= $ligne['titre'] ?></textarea>
                </div>
                <div class='mb-3'>
                    <label class="form-label">Contenu de la question : </label>
                    <textarea cols='40' rows='5' class='modif' name='question'><?= $ligne['contenu'] ?></textarea>
                </div>
                <div class='mb-3'>
                    <label class="form-label">Réponse à la question : </label>
                    <textarea cols='40' rows='5' class='modif' name='reponse' placeholder='tapez votre reponse ici'><?= $rep['contenu_rep'] ?></textarea>
                </div>
                <div class='bouton'>
                    <button type='submit' class='btn' name='valider'>Submit</button>
                    <button name='supprimer' type='submit'>Supprimer</button>
                </div>
            </form>
        </div>

        <?php
        if (!empty($error)) {
            echo "<p>Une erreur s'est produite : " . $error . "</p>";
        }
    }
    ?>
</body>

</html>