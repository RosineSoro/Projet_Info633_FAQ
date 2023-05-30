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



<h1>Modifier les questions</h1>    


<?php

    

    $id_Question=$_GET['id_question'];
    $id_compte=3;
    $sql="select * from question where id_question =".$id_Question;
    $result=  mysqli_query($conn, $sql);
    $ligne = mysqli_fetch_assoc($result);
        /*echo ("<form  method=\"post\">");
    echo("<textarea class='modif' name='titre'>".$ligne['titre']."</textarea>");
    echo("<textarea  class='modif' name='question'>".$ligne['contenu']."</textarea>");
    echo("<textarea  class='modif' name='reponse' placeholder='tapez votre reponse ici'></textarea>");
    echo("<div class='bouton' >");
    echo("<button  name='valider' type= 'submit'>valider</button>");
    echo("<button  name='supprimer' type= 'submit'>supprimer</button>");
    echo("</div>");
    echo("</form>");*/
    echo("<div id ='form-content'>");
    echo ("<form action='attente.php'  method=\"post\">");
    
    echo "<div class='mb-3'>";
    echo '<label class="form-label">Titre de la question : </label>';
    echo("<textarea cols='40' rows='5' class='modif' name='titre'>".$ligne['titre']."</textarea>");
    echo "</div>";
    echo "<div class='mb-3'>";
    echo '<label class="form-label">Contenu de la question : </label>';
    echo("<textarea  cols='40' rows='5'  class='modif' name='question'>".$ligne['contenu']."</textarea>");
    echo "</div>";
    echo "<div class='mb-3'>";
    echo '<label class="form-label">Réponse à la question : </label>';
    echo("<textarea cols='40' rows='5'  class='modif' name='reponse' placeholder='tapez votre reponse ici'></textarea>");;
    echo "</div >";
    echo("<div class='bouton' >");
    echo("<button type='submit' class = 'btn' name ='valider'>Submit</button>");
    echo("<button  name='supprimer'  type= 'submit'>Supprimer</button>");
    echo("</div>");
  echo"</form>";
  echo("</div>");
if (isset($_POST['valider'])){
    $sql1="update question set titre =\"".$_POST['titre']. "\",contenu=\"".$_POST['question']."\", verif=1 where id_question = ".$id_Question;
    $sql2="update reponse set contenu_rep=\"".$_POST['reponse']."\" where id_question=".$id_Question;
    $sql3="INSERT INTO log_rep (id_compte, id_question, date_rep) VALUES ('$id_compte', '$id_Question', NOW())";
    
    $result1 = mysqli_query($conn, $sql1);
    if (!$result1) {
        die('Erreur SQL : ' . mysqli_error($conn));
    }

    $result2=mysqli_query($conn, $sql2);
    if (!$result2) {
        die('Erreur SQL : ' . mysqli_error($conn));
    }
    $result3=mysqli_query($conn, $sql3);
    if (!$result2) {
        die('Erreur SQL : ' . mysqli_error($conn));
    }
}
if (isset($_POST['supprimer'])){
    $sql="delete from question where id_question=".$id_Question;
    $result1 = mysqli_query($conn, $sql);
    if (!$result1) {
        die('Erreur SQL : ' . mysqli_error($conn));
    }
    header("Location: consultation.php");
}


?>


</body>
</html>