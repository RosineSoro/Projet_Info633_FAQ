<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Gestion de la déconnexion
if (isset($_POST['logout'])) {
    session_unset(); // Supprimer toutes les variables de session
    session_destroy(); // Détruire la session
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>


<html lang="fr"> 

  

   <head>
		  <title>Page de Consultation</title>
		  <meta charset="UTF-8">
		  <link rel="stylesheet" type="text/css" href="consultation.css">
		  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		 
    </head> 
	
	<body>
	    
		<div = id="content">
		    
			<?php
					try
					{
						$db = new PDO('mysql:host=localhost;dbname=projetbdd;charset=utf8', 'root', '');
					}
					catch (Exception $e)
					{
						   die('erreur : ' . $e->getMessage());
					}
			?>
		
			<div class="dropdown">
				  <button class="dropbtn">
					 <span>Catégorie </span>
					 <i class="fa fa-caret-down"></i>
				  </button>
				  <div class="dropdown-content">
						<a href="#">BDD</a>
						<a href="#">HTML</a>
						<a href="#">CSS</a>
						<a href="#">PHP</a>
						<a href="#">JAVASCRIPT</a>
						<a href="#">GIT</a>
				  </div>
			</div>
			 
			<div class = "question-button">
				   <button type = "submit" name = "ask-question">Poser Une Question</button>
				   <button type = "submit" name = "pending-question">Questions En Attente</button>
			</div>
			
			<div class="question-title">
			    <!-- gérer le fait que si on clique sur BDD par exemple, on ait les éléments qui s'affichent en fonction-->
			    <!-- gérer aussi pour les dates-->
				<?php 
				$sql ="select titre from question";
				$sqlexec = $db->prepare($sql);
				$sqlexec ->execute();
				$result = $sqlexec ->fetchAll();
				foreach ($result as $row ) {
					//remplacer les liens par des liens qui renverront vers la page de Colin 
					//faire le css pour le bon affichage
					echo("<a href=\"#\">".$row['titre']."</a>");

				}

				?>
		    </div>
			</div>
			
		</div>	
		
	</body>