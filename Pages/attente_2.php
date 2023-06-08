<?php   
	session_start();

	// Vérifier si l'utilisateur est connecté
	if (!isset($_SESSION['pseudo'])) {
		header("Location: login.php");
		exit();
	} else {
		$pseudo = $_SESSION['pseudo'];
		$statut = $_SESSION['statut'];
		$id_compte = $_SESSION['id_compte'];	
	}
	
	// Gestion de la déconnexion
	if (isset($_POST['logout'])) {
		session_unset(); // Supprimer toutes les variables de session
		session_destroy(); // Détruire la session
		header("Location: login.php");
		exit();
	}
	
	// Connexion à la base de données
	$servername = "tp-epua:3308";
	$username = "chafikya";
	$password = "61md4vj3";
	$dbname = "chafikya";
?> 

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Questions en attente</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="consultation.css">
</head>

  
  
<body>
  <div class="container-fluid">
  <div class="row">
      <div class="col-md-3 sidebar">
          <div class="sidebar-content">
			<form method="post">
				<button type="submit" class="btn btn-primary btn-block button-spacing" name="logout">Se déconnecter</button>
			</form>
			<a href="page_quest.php" class="btn btn-primary btn-block button-spacing">Poser une question</a>
			<a href="consultation_2.php" class="btn btn-primary btn-block button-spacing">Retourner sur le forum</a>
			<form method="post">
            <select class="form-control" name ="cat">
              <option value="">Toutes les catégories</option>
              <?php

                $conn = new mysqli($servername, $username, $password, $dbname);
				$conn->query("SET NAMES UTF8");

                  // Vérification de la connexion
                  if ($conn->connect_error) {
                    die("Connexion échouée: " . $conn->connect_error);
                  }

                  // Exécution de la requête SQL pour récupérer les catégories
                  $sql = "SELECT nom_cat FROM categorie";
                  $result = $conn->query($sql);

                  // Affichage des catégories dans la liste déroulante
                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                      $selected = ($_POST['cat'] == $row["nom_cat"]) ? 'selected' : '';
                      echo '<option value="' . $row["nom_cat"] . '"' . $selected . '>' . $row["nom_cat"] . '</option>';
                    }
                  }

                  // Fermeture de la connexion à la base de données
                  $conn->close();
                ?>
              </select>
              <input type="submit" value="Filtrer" class="btn btn-primary btn-block">
            </form>
          </div>
      </div>
      <div class="col-md-9 offset-md-3">
	  <h1 class="main_title">Questions en attente</h1>
        <div class="question-list">
          <?php
            // Connexion à la base de données
            $conn = new mysqli($servername, $username, $password, $dbname);
			$conn->query("SET NAMES UTF8");

            // Vérification de la connexion
            if ($conn->connect_error) {
              die("Connexion échouée: " . $conn->connect_error);
            }

            // Construction de la requête SQL pour récupérer les questions
            if(isset($_POST['cat']) && !empty($_POST['cat']) && ($_POST['cat']!="Toutes les catégories")) {
				$cat = $_POST['cat'];
				if ($statut == 0){
					$sql = "SELECT question.* FROM question, categorie 
						  WHERE question.id_cat = categorie.id_cat AND 
						  categorie.nom_cat = '$cat' AND
						  question.verif = 0 AND
						  question.id_compte = '$id_compte'
						  ORDER BY question.date_question DESC";
				} else {
					$sql = "SELECT question.* FROM question, categorie 
				    WHERE question.id_cat = categorie.id_cat AND 
				    categorie.nom_cat = '$cat' AND
					question.verif = 0
					ORDER BY question.date_question DESC";
				}
			} else {
				if ($statut == 0){
					$sql = "SELECT * FROM question 
							WHERE question.verif = 0 AND
							id_compte = '$id_compte'
							ORDER BY question.date_question DESC";
				} else {
					$sql = "SELECT * FROM question 
							WHERE question.verif = 0
							ORDER BY question.date_question DESC";		
				}
			}
			
            // Exécution de la requête SQL pour récupérer les questions
            $result = $conn->query($sql);

            // Affichage des questions
            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                echo '<div class="question">';
                echo '<h2>' . $row["titre"] . '</h2>';
				echo '<p><em><small>' . $row["date_question"] . '</small></em></p>';
                echo '<p>' . $row["contenu"] . '</p>';
				if ($statut == 1){
					echo '<a href="modif.php?id=' . $row["id_question"] . '">Modifier la question</a>';
				}
                echo '</div>';
              }
            } else {
				echo '<p> Aucune question en attente de validation pour le moment.</p>';
			}

            // Fermeture de la connexion à la base de données (à nouveau)
            $conn->close();
			//unset($_POST['cat']);
          ?>
        </div>
      </div>
	 </div>
</body>
</html>