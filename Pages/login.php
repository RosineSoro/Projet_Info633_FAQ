<?php
session_start();

// Vérifier si l'utilisateur est déjà connecté
if (isset($_SESSION['username'])) {
	header("Location: consultation.php");
    exit();
}

// Vérifier si le formulaire de login a été soumis
if (isset($_POST['username'])) {
    $username = $_POST['username'];

    //*Connexion à la base de données sur le serveur tp-epua*/
	$conn = @mysqli_connect("tp-epua:3308", " ", " ");    

	/*connexion à la base de donnée depuis la machine virtuelle INFO642*/
	/*$conn = @mysqli_connect("localhost", "etu", "bdtw2021");*/  

	if (mysqli_connect_errno()) {
		$msg = "erreur ". mysqli_connect_error();
	} else {  
		$msg = "connecté au serveur " . mysqli_get_host_info($conn);
		/*Sélection de la base de données*/
		mysqli_select_db($conn, " "); 
		/*Encodage UTF8 pour les échanges avecla BD*/
		mysqli_query($conn, "SET NAMES UTF8");
	}

    // Requête pour vérifier si le username existe dans la table user_forum:
    $sql = "SELECT * FROM user_forum WHERE name = '$username'";
    $result = $conn->query($sql);
	
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $row['name'];
        mysqli_close($conn);
        header("Location: consultation.php");
        exit();
    } else {
		echo "<span>Username incorrect. Veuillez réessayer.</span>";
    }
    mysqli_close($conn);
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
			<span> Username : </span>
			<input type="text" id="username" name="username" required="required"><br><br>
			<input type="submit" value="Sign in" name="loginButton">
		</div>
	</form>
</body>
</html>