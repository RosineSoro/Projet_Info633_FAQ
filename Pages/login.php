<?php
	session_start();

	// Vérifier si l'utilisateur est déjà connecté
	if (isset($_SESSION['pseudo'])) {
		header("Location: consultation_2.php");
		exit();
	}

	// Vérifier si le formulaire de login a été soumis
	if (isset($_POST['button'])) {
		$pseudo = $_POST['pseudo'];
		$pw = $_POST['password'];

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

		// Requête pour vérifier si le compte existe dans la table compte:
		$sql = "SELECT * FROM compte WHERE pseudo = '$pseudo' AND pw = '$pw'";
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
				$error_message = 'Identifiants incorrects. Veuillez réessayer.';
				unset($_POST);
			}
			$conn->close();
		} else {
			$error_message = "Erreur lors de l'exécution de la requête: " . $conn->error;
			unset($_POST);
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Page de login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="login.css">
</head>
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="text-center mb-4">FORUM BDTW</h2>
                        <?php
                        if (isset($error_message)) {
                            echo '<div class="alert alert-danger mb-4">' . $error_message . '</div>';
                        }
                        ?>
                        <form action="login.php" method="POST">
                            <div class="field">
                                <label for="pseudo" class="form-label">Pseudo :</label>
                                <input type="text" name="pseudo" class="form-control" required>
                            </div>
                            <div class="field">
                                <label for="password" class="form-label">Mot de passe :</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="field">
                                <button type="submit" class="btn btn-primary" name="button">Se connecter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>