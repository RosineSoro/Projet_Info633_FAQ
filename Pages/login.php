<?php
	session_start();

	// Vérifier si l'utilisateur est déjà connecté
	if (isset($_SESSION['pseudo'])) {
		header("Location: consultation_2.php");
		exit();
	}

	// Vérifier si le formulaire de login a été soumis
	if (isset($_POST['pseudo'])) {
		$pseudo = $_POST['pseudo'];

		// Connexion à la base de données
		$servername = "tp-epua:3308";
		$username = "chafikya";
		$password = "61md4vj3";
		$dbname = "chafikya";

		$conn = new mysqli($servername, $username, $password, $dbname);
		$conn->query("SET NAMES UTF8");

		// Vérification de la connexion
		if ($conn->connect_error) {
		  die("Connexion échouée: " . $conn->connect_error);
		}

		// Requête pour vérifier si le username existe dans la table user_forum:
		$sql = "SELECT * FROM compte WHERE pseudo = '$pseudo'";
		$result = $conn->query($sql);

		if ($result) {
			if ($result->num_rows > 0) {
				$row = $result->fetch_assoc();
				$_SESSION['pseudo'] = $row['pseudo'];
				$_SESSION['id_compte'] = $row['id_compte'];
				$_SESSION['statut'] = $row['statut'];
				$conn->close();
				header("Location: consultation_2.php");
				exit();
			} else {
				echo "<span>Pseudo incorrect. Veuillez réessayer.</span>";
				unset($_POST);
			}
			$conn->close();
		} else {
			echo "Erreur lors de l'exécution de la requête: " . $conn->error;
			unset($_POST);
		}
	} else {
		echo "<span>Not connected.</span>";
	}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Page de login</title>
</head>
<body>
    <h2>Page de login</h2>
    <form action="login.php" method="POST">
		<div class='formulaire'>
			<span> Pseudo : </span>
			<input type="text" name="pseudo" required="required"><br><br>
			<input type="submit" value="Se connecter" name="loginButton">
		</div>
	</form>
</body>
</html>