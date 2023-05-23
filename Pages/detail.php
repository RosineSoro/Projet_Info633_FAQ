<!DOCTYPE html>
<html>
<head>
	<title></title>
    <link rel="stylesheet" type="text/css" href="detail.css">
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

<h1>Detail question</h1>    
<?php
    $id_Question=$_GET['id_question'];
    $sql="select * from question where id_question =".$id_Question; // récupère le titre de la question et la question
   
    $result=  mysqli_query($conn, $sql);
    $ligne = mysqli_fetch_assoc($result);
    $sql2="select * from reponse where id_question=".$id_Question; //récupère réponse de la question.
    $result= mysqli_query($conn, $sql);
    $rep = mysqli_fetch_assoc($result);
    
    echo("<h2>".$ligne['titre']."</h2>");
    echo("<p>".$ligne['contenu']."</p>");
    echo("<p>".$rep['contenu_rep']."</p>");

?>

</body>
</html>