<html>
    <head>
		  <title>Questions en attente</title>
	
		  <!--definition de l encodage-->
		  <meta charset="UTF-8">
		  <!--mise en lien du fichier html avec le fichier css-->
		  <link rel="stylesheet" type="text/css" href="attente.css">
		  <!--recuperer l'icone de recherche-->
	      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   </head> 

   <body>

        <h1>Liste des questions en attente</h1>

        <?php
            $conn = @mysqli_connect("tp-epua:3308", "chafikya", "61md4vj3");
            mysqli_select_db($conn, "chafikya");
            $sql = "SELECT id_question, titre, contenu, id_compte, id_cat FROM question WHERE verif = 0";
            $result = mysqli_query($conn, $sql) or die("Requête invalide: ". mysqli_error()."\n".$sql);
            $val = mysqli_fetch_array($result);
            //catégorie
            $sqlcat = "SELECT nom_cat FROM categorie WHERE id_Cat = ".$val['id_cat'];
            $resultcat = mysqli_query($conn, $sqlcat) or die("Requête invalide: ". mysqli_error()."\n".$sqlcat);
            $rescat = mysqli_fetch_array($resultcat);
            //compte
            $sqlacc = "SELECT nom, prenom FROM compte WHERE id_compte = ".$val['id_compte'];
            $resultacc = mysqli_query($conn, $sqlacc) or die("Requête invalide: ". mysqli_error()."\n".$sqlacc);
            $resacc = mysqli_fetch_array($resultacc);
            while ($val != FALSE) {
                echo "<a href='modif.php?id_question=".$val['id_question']."'><div class='question'><h3 class='question_titre'>".$val['titre']."</h3><c>".$rescat['nom_cat']."</c><p>".$resacc['prenom']." ".$resacc['nom']."</p><t>".$val['contenu']."</t></div></a>";
                $val = mysqli_fetch_array($result);
            }
        ?>
   </body>