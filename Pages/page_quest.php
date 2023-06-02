<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Poser Questions</title>
  <meta content="info">
  <meta charset="UTF-8">
  <link rel="stylesheet" href="page_quest.css">
</head>

<body>
  <h1>Poser Questions</h1>
  <?php
  function connexion()
  {
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
    $conn = connexion();
    if (($_SESSION['statut']) == 1) {
      return true;
    }
    return false;
  }

  // Vérifier si l'utilisateur est connecté en tant qu'étudiant
  function estEtudiant()
  {
    $conn = connexion();
    if (($_SESSION['statut']) == 0) {
      return true;
    }
    return false;
  }

  // Récupérer les catégories de la base de données
  function getCategories()
  {
    $conn = connexion();
    $query = "SELECT * FROM categorie";
    $result = mysqli_query($conn, $query);
    return $result;
  }

  // Affichage du formulaire de question
  // Affichage du formulaire de question pour les professeurs
  function afficherFormulaireQuestionProf()
  {
    $conn = connexion();
	
    $erreur = '';
    $titreValue = '';
    $contenuValue = '';
    
    if (isset($_GET["poser"])) {
        $selectedCategory = $_GET["categorie"];
        $titre = $_GET["titre"];
        $contenu = $_GET["contenu"];
        if (empty($selectedCategory)) {
            $erreur = 'Please choose a category.';
            $titreValue = $titre;
            $contenuValue = $contenu;
        } else {
            $sql_4 = "INSERT INTO question (titre, contenu, id_compte, id_cat, verif) VALUES ('" . mysqli_real_escape_string($conn, $titre) . "', '" . mysqli_real_escape_string($conn, $contenu) . "', '" . $_SESSION['id_compte'] . "', '" . mysqli_real_escape_string($conn, $selectedCategory) . "', '0')";
            $result = mysqli_query($conn, $sql_4) or die("Requête invalide: " . mysqli_error($conn) . "\n" . $sql_4);
            
            // Redirection vers consultation_2.php
			echo '<meta http-equiv="refresh" content="0; URL=consultation_2.php">';
            exit();
        }
    }

    echo '<form method="get" action="page_quest.php">';
    echo '<label for="titre">Titre :</label><br>';
    echo '<input type="text" id="titre" name="titre" value="' . htmlspecialchars($titreValue) . '"><br><br>';
    echo '<label for="contenu">Contenu :</label><br>';
    echo '<textarea id="contenu" name="contenu">' . htmlspecialchars($contenuValue) . '</textarea><br><br>';
    echo '<form method="get">';
    echo '<label for="categorie">Categorie</label>';
    echo '<select name="categorie">';
    echo '<option value="" selected>Please choose a category</option>';

    $categories = getCategories();
    while ($row = mysqli_fetch_assoc($categories)) {
      echo "<option value=\"{$row['id_Cat']}\">{$row['nom_cat']}</option>";
    }

    echo '</select>';
    echo '<input type="submit" name="poser" value="Poser une question">';
	if (!empty($erreur)) {
        echo '<p style="color: red;">' . $erreur . '</p>';
    }
    echo '</form>';

    echo '<a href="consultation_2.php">Cliquez ici pour aller vers la page principale</a>';
    echo '</form>';
  }

  // Affichage du formulaire de question pour les étudiants
  function afficherFormulaireQuestionEtudiant()
  {
    $conn = connexion();
	
    $erreur = '';
    $titreValue = '';
    $contenuValue = '';
    
    if (isset($_GET["poser"])) {
        $selectedCategory = $_GET["categorie"];
        $titre = $_GET["titre"];
        $contenu = $_GET["contenu"];
        if (empty($selectedCategory)) {
            $erreur = 'Please choose a category.';
            $titreValue = $titre;
            $contenuValue = $contenu;
        } else {
            $sql_4 = "INSERT INTO question (titre, contenu, id_compte, id_cat, verif) VALUES ('" . mysqli_real_escape_string($conn, $titre) . "', '" . mysqli_real_escape_string($conn, $contenu) . "', '" . $_SESSION['id_compte'] . "', '" . mysqli_real_escape_string($conn, $selectedCategory) . "', '0')";
            $result = mysqli_query($conn, $sql_4) or die("Requête invalide: " . mysqli_error($conn) . "\n" . $sql_4);
            
            // Redirection vers consultation_2.php
            header("Location: consultation_2.php");
            exit();
        }
    }

	
    echo '<form method="get" action="page_quest.php">';
    echo '<input type="text" id="titre" name="titre" value="' . htmlspecialchars($titreValue) . '"><br><br>';
    echo '<label for="contenu">Contenu :</label><br>';
    echo '<textarea id="contenu" name="contenu">' . htmlspecialchars($contenuValue) . '</textarea><br><br>';
    echo '<form method="get">';
    echo '<label for="categorie">Categorie</label>';
    echo '<select name="categorie">';
    echo '<option value="" selected>Please choose a category</option>';

    $categories = getCategories();
    while ($row = mysqli_fetch_assoc($categories)) {
      echo "<option value=\"{$row['id_Cat']}\">{$row['nom_cat']}</option>";
    }

    echo '</select>';
    echo '<input type="submit" name="poser" value="Poser une question">';
	if (!empty($erreur)) {
		echo '<p style="color: red;">' . $erreur . '</p>';
    }
    echo '</form>';
    echo '<a href="consultation_2.php">Cliquez ici pour aller vers la page principale</a>';
    echo '</form>';
  }

  // Vérifier si l'utilisateur est connecté
  if (isset($_SESSION['id_compte'])) {
    // Vérifier si l'utilisateur est un professeur
    if (estProfesseur()) {
      afficherFormulaireQuestionProf();
    } else if (estEtudiant()) {
      afficherFormulaireQuestionEtudiant();
    }
  } else {
    echo 'Veuillez vous connecter pour poser une question.';
  }
  ?>

</body>
</html>