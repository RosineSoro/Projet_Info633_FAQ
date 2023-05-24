<?php
session_start();

?>
<!DOCTYPE html>
<html>

  <head>
    <title></title>
    <meta content="info">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="page_quest.css">
    
    
  </head>
  
  
<body>

<?php



function connexion() {
    
    $conn = @mysqli_connect("tp-epua:3308", "chafikya", "61md4vj3");

    if (mysqli_connect_errno()) {
        $msg = "erreur " . mysqli_connect_error();
    } else {
        $msg = "connecté au serveur " . mysqli_get_host_info($conn);
        mysqli_select_db($conn, "chafikya");
        mysqli_query($conn, "SET NAMES UTF8");
    }

    return $conn;
}


// Vérifier si l'utilisateur est connecté en tant que professeur
function estProfesseur()
{
    $conn=connexion();
    
   
    
        if (isset($_SESSION['utilisateur_id'])) {
            $utilisateurId = $_SESSION['utilisateur_id'];}
        $sql_1 = " select statut from compte where id_compte= ".$utilisateurId ;
        $result = mysqli_query($conn, $sql_1) or die("Requête invalide: ". mysqli_error($conn)."\n".$sql_1);
       
        while ($row = mysqli_fetch_assoc($result)){  
          if ($row["statut"] == 1) {
            return true; 
          }}
    

    return false; 
    }

// Vérifier si l'utilisateur est connecté en tant qu'étudiant
function estEtudiant()
{   $conn=connexion();
        if (isset($_SESSION['utilisateur_id'])) {
            $utilisateurId = $_SESSION['utilisateur_id'];}
        $sql_1 = " select statut from compte where id_compte=".$utilisateurId;
        $result = mysqli_query($conn, $sql_1) or die("Requête invalide: ". mysqli_error($conn)."\n".$sql_1);
        
        while ($row = mysqli_fetch_assoc($result)){  
            if ($row["statut"] == 0) {
              return true; 
            }}
        
    

    return false;
}

// Affichage du formulaire de question
// Affichage du formulaire de question pour les professeurs
function afficherFormulaireQuestionProf()
{    
    $conn=connexion();
    echo '<form method="get" action="page_quest.php">';
    echo '<label for="titre">Titre :</label><br>';
    echo '<input type="text" id="titre" name="titre"><br><br>';
    echo '<label for="contenu">Contenu :</label><br>';
    echo '<textarea id="contenu" name="contenu"></textarea><br><br>';
    echo '<form method="get">';
    echo '<label for="categorie">categorie</label>';

    echo '<select name="categorie">';
    echo '<option value="">--Please choose an option--</option>';
    echo '<option value="1">java</option>';
    echo '<option value="2">php</option>';
    echo '<option value="3">html</option>';
    echo '<option value="4">css</option>';
    echo '<option value="5">divers</option>';
    echo '</select>';

    echo '<input type="submit" name="poser" value="Poser une question">';
    echo '<a href="consultation_2.php">Cliquez ici pour aller vers la page principale</a>  ';
    
            if (isset($_GET["poser"])){
                
                if (isset($_SESSION['utilisateur_id'])) {
                    $utilisateurId = $_SESSION['utilisateur_id'];}
                
            $sql_4 = "INSERT INTO question (titre, contenu, id_compte, id_cat, verif) VALUES ('{$_GET["titre"]}', '{$_GET["contenu"]}', '.$utilisateurId.', '{$_GET["categorie"]}', '1')";
            echo $sql_4;
        $result = mysqli_query($conn, $sql_4) or die("Requête invalide: ". mysqli_error($conn)."\n".$sql_4);}
    echo '</form>';
}
// Affichage du formulaire de question pour les étudiants
function afficherFormulaireQuestionEtudiant()
{
    $conn=connexion();
    echo '<form method="get" action="page_quest.php">';
    echo '<label for="titre">Titre :</label><br>';
    echo '<input type="text" id="titre" name="titre"><br><br>';
    echo '<label for="contenu">Contenu :</label><br>';
    echo '<textarea id="contenu" name="contenu"></textarea><br><br>';
    echo '<form method="get">';
    echo '<label for="categorie">categorie</label>';

echo '<select name="categorie">';
echo '<option value="">--Please choose an option--</option>';
echo '<option value="1">java</option>';
echo '<option value="2">php</option>';
echo '<option value="3">html</option>';
echo '<option value="4">css</option>';
echo '<option value="5">divers</option>';
echo '</select>';
echo '<input type="submit" name="poser" value="Poser une question">';
echo '<a href="consultation_2.php">Cliquez ici pour aller vers la page principale</a>  ';
    
    
            if (isset($_GET["poser"])){
                if (isset($_SESSION['utilisateur_id'])) {
                    $utilisateurId = $_SESSION['utilisateur_id'];}
                
                $sql_4 = " INSERT INTO question (titre,contenu,id_compte,id_cat,verif) VALUES ('{$_GET['titre']}', '{$_GET["contenu"]}', '.$utilisateurId.', '{$_GET["categorie"]}','{0})";
                echo $sql_4;
        $result = mysqli_query($conn, $sql_4) or die("Requête invalide: ". mysqli_error($conn)."\n".$sql_4);}
    echo '</form>';
}


// Affichage de la page de questions
function afficherPageQuestions()
{
    if (estProfesseur()) {
        afficherFormulaireQuestionProf();
    } elseif (estEtudiant()) {
        afficherFormulaireQuestionEtudiant();
    } 
}
afficherPageQuestions()
?>


</body>