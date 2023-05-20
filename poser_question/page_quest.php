<!DOCTYPE html>
<html>

  <head>
    <title></title>
    <meta content="info">
    <meta charset="UTF-8">
    
  </head>
<body>
<?php
session_start();


// Vérifier si l'utilisateur est connecté en tant que professeur
function estProfesseur()
{
    
    
   
    $conn = @mysqli_connect("tp-epua:3308", "chafikya", "61md4vj3");    
    
    
    if (mysqli_connect_errno()) {
            $msg = "erreur ". mysqli_connect_error();
        } else {  
            $msg = "connecté au serveur " . mysqli_get_host_info($conn);
            mysqli_select_db($conn, "chafikya"); 
            mysqli_query($conn, "SET NAMES UTF8");
        }
        if (isset($_SESSION['utilisateur_id'])) {
            $utilisateurId = $_SESSION['utilisateur_id'];}
        $sql_1 = " select statut from compte where $utilisateurId=id_compte ";
        $result = mysqli_query($conn, $sql_1) or die("Requête invalide: ". mysqli_error()."\n".$sql_1);
       
        if ($result == 1) {
            return true; 
        }
    

    return false; 
    }

// Vérifier si l'utilisateur est connecté en tant qu'étudiant
function estEtudiant()
{ 
    $conn = @mysqli_connect("tp-epua:3308", "chafikya", "61md4vj3");    
    
    
    if (mysqli_connect_errno()) {
            $msg = "erreur ". mysqli_connect_error();
        } else {  
            $msg = "connecté au serveur " . mysqli_get_host_info($conn);
            mysqli_select_db($conn, "chafikya"); 
            mysqli_query($conn, "SET NAMES UTF8");
        }
        if (isset($_SESSION['utilisateur_id'])) {
            $utilisateurId = $_SESSION['utilisateur_id'];}
        $sql_1 = " select statut from compte where $utilisateurId=id_compte";
        $result = mysqli_query($conn, $sql_1) or die("Requête invalide: ". mysqli_error()."\n".$sql_1);
       
        if ($result == 0) {
            return true; 
        }
    

    return false;
}

// Affichage du formulaire de question
// Affichage du formulaire de question pour les professeurs
function afficherFormulaireQuestionProf()
{
    echo '<form method="post" action="traitement_questions.php">';
    echo '<label for="titre">Titre :</label><br>';
    echo '<input type="text" id="titre" name="titre"><br><br>';
    echo '<label for="contenu">Contenu :</label><br>';
    echo '<textarea id="contenu" name="contenu"></textarea><br><br>';
    echo '<input type="submit" name="poser" value="Poser une question">';
    echo '<input type="submit" name="modifier" value="Modifier une question">';
    echo '<input type="submit" name="valider" value="Valider les questions">';
    echo '</form>';
}
// Affichage du formulaire de question pour les étudiants
function afficherFormulaireQuestionEtudiant()
{
    echo '<form method="post" action="traitement_questions.php">';
    echo '<label for="titre">Titre :</label><br>';
    echo '<input type="text" id="titre" name="titre"><br><br>';
    echo '<label for="contenu">Contenu :</label><br>';
    echo '<textarea id="contenu" name="contenu"></textarea><br><br>';
    echo '<input type="submit" name="poser" value="Poser une question">';
    echo '</form>';
}


// Affichage de la page de questions
function afficherPageQuestions()
{
    
    if (estConnecteEnTantQueProfesseur()) {
        afficherFormulaireQuestionProf();
    } elseif (estConnecteEnTantQuEtudiant()) {
        afficherFormulaireQuestionEtudiant();
    } 
}
?>
</body>