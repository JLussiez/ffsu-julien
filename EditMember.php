<?php
require('Connexion.php');
require('Menu.php');

if (isset($_GET['id'])) {
    $memberId = $_GET['id'];
    $pdo = connect();

    $query = "SELECT * FROM license_member WHERE id_member = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$memberId]);

    $member = $stmt->fetch(PDO::FETCH_ASSOC);

    $pdo = null;
} else {
    header('Location: ListMember.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Membre</title>
</head>
<body>
    <h2>Modifier Membre</h2>
    <form action="ListMember.php" method="post">
        <input type="hidden" name="id" value="<?= $member['id_member'] ?>">
        <label>Nom :</label>
        <input type="text" name="name" value="<?= $member['name'] ?>">
        <br>
        <label>Prénom :</label>
        <input type="text" name="first_name" value="<?= $member['first_name'] ?>">
        <br>
        <label>Date de naissance :</label>
        <input type="date" name="birthdate" value="<?= $member['birthdate'] ?>">
        <br>
        <label>Numéro de licence :</label>
        <input type="text" name="license_number" value="<?= $member['license_number'] ?>">
        <br>
        <input type="submit" value="Enregistrer les modifications">
    </form>
</body>
</html>
