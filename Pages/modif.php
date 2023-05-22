<!DOCTYPE html>
<html>
<head>
	<title></title>
    <link rel="stylesheet" type="text/css" href="modif.css">
</head>
<body>

<?php   
        /*Connexion à la base de données sur le serveur tp-epua*/
    $conn = @mysqli_connect("tp-epua:3308", "chafikya", "61md4vj3");    
    
    /*connexion à la base de donnée depuis la machine virtuelle INFO642*/
    /*$conn = @mysqli_connect("localhost", "etu", "bdtw2021");*/  

    if (mysqli_connect_errno()) {
            $msg = "erreur ". mysqli_connect_error();
        } else {  
            $msg = "connecté au serveur " . mysqli_get_host_info($conn);
            /*Sélection de la base de données*/
            mysqli_select_db($conn, "chafikya"); 
            /*mysqli_select_db($conn, "etu"); */ /*sélection de la base sous la VM info642*/
    
            /*Encodage UTF8 pour les échanges avecla BD*/
            mysqli_query($conn, "SET NAMES UTF8");
        }
        ?>

    
<?php
    $id_Question=$_GET['id_question'];
    $sql="select * from question where id_question =".$id_Question;
    $result=  mysqli_query($conn, $sql);
    $ligne = mysqli_fetch_assoc($result);
        echo ("<form method=\"post\">");
    echo("<textarea name=\"titre\">".$ligne['titre']."</textarea>");
    echo("<textarea name='question'>".$ligne['contenu']."</textarea>");
    echo("<textarea name='reponse' placeholder='tapez votre reponse ici'></textarea>");
    echo("<button type=\"submit\">valider</button>");
    echo("</form>");
    
if (isset($_POST['reponse'])){
    $sql="update question set titre =".$_POST['titre']. ",contenu=".$_POST['question']."where id_question=".$id_Question;
    $sql1="update reponse set contenu_rep=".$_POST['reponse']."where id_question=".$id_Question;
}

?>

</body>
</html>