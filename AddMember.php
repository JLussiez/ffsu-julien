<?php
require('Connexion.php');
require('Menu.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $first_name = $_POST['first_name'];
    $birthdate = $_POST['birthdate'];
    $license_number = $_POST['license_number'];

    $pdo = connect();

    $query = "INSERT INTO license_member (name, first_name, birthdate, license_number) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);
    
    $stmt->execute([$name, $first_name, $birthdate, $license_number]);

    $pdo = null;

    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire</title>
</head>
<body>
    <form action="" method="post">
        <label>Nom :</label>
        <input type="text" name="name">
        <br>
        <label>Prenom :</label>
        <input type="text" name="first_name">
        <br>
        <label>Date de naissance :</label>
        <input type="date" name="birthdate">
        <br>
        <label>Numéro de licence :</label>
        <input type="text" name="license_number">
        <br>
        <input type="submit" value="Ajouter">
    </form>
</body>
</html>

<?php 
connect()
?>
