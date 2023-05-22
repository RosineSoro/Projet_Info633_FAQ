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
        <?php
            $conn = @mysqli_connect("tp-epua:3308", "chafikya", "61md4vj3");
            mysqli_select_db($conn, "chafikya");
            $sql = "SELECT titre FROM question WHERE verif = 0";
            $result = mysqli_query($conn, $sql) or die("Requête invalide: ". mysqli_error()."\n".$sql);
            $val = mysqli_fetch_array($result);
            while ($val != FALSE) {
                echo "<div class='question'><a href=''>".$val[0]."</a></div>";
                $val = mysqli_fetch_array($result);
            }
        ?>
   </body>