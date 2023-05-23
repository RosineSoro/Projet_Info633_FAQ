<?php   
	session_start();

	// Vérifier si l'utilisateur est connecté
	if (!isset($_SESSION['pseudo'])) {
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
	<title>Forum de questions</title>
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
			<button class="btn btn-primary btn-block button-spacing">Poser une question</button>
            <button class="btn btn-primary btn-block button-spacing">Mes questions en attente</button>
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
    </div> 
      <div class="col-md-9">
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
              $sql = "SELECT question.* FROM question, categorie 
					  WHERE question.id_cat = categorie.id_cat AND 
					  categorie.nom_cat = '$cat' AND
					  question.verif = 1;
					  ";
			  $unset($_POST);
			} else {
              $sql = "SELECT * FROM question";
            }
			

            // Exécution de la requête SQL pour récupérer les questions
            $result = $conn->query($sql);

            // Affichage des questions
            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                echo '<div class="question">';
                echo '<h2>' . $row["titre"] . '</h2>';
                echo '<p>' . $row["contenu"] . '</p>';
                echo '<a href="repondre.php?id=' . $row["id_question"] . '">Voir réponse</a>';
                echo '</div>';
              }
            }

            // Fermeture de la connexion à la base de données (à nouveau)
            $conn->close();
          ?>
        </div>
      </div>
	 </div>
</body>
</html>