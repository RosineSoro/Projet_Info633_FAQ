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
<html>
<head>
    <title>Page de consultation</title>
</head>
<body>
    <h2>Page de consultation</h2>
    <?php echo "Connected with username: " . $_SESSION['username']; ?>
	 <br><br>
	 <form method="post" action="">
        <input type="submit" name="logout" value="Se déconnecter">
    </form>
</body>
</html>