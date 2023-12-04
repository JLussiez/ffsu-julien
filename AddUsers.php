<?php
require('Connexion.php');
require('Menu.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_licence_number = isset($_POST['user_licence_number']) ? $_POST['user_licence_number'] : null;

    // Vérifier si le numéro de licence est renseigné
    if ($user_licence_number !== null) {
        try {
            $pdo = connect();

            // Vérifier si le numéro de licence existe déjà (en tenant compte de la sensibilité à la casse)
            $checkQuery = "SELECT COUNT(*) FROM users WHERE BINARY user_licence_number = ?";
            $checkStmt = $pdo->prepare($checkQuery);
            $checkStmt->execute([$user_licence_number]);

            $count = $checkStmt->fetchColumn();

            if ($count > 0) {
                echo "Erreur : Le numéro de licence existe déjà dans la base de données.";
            } else {
                // Le numéro de licence n'existe pas encore, effectuer l'insertion
                $user_firstname = $_POST['user_firstname'];
                $user_lastname = $_POST['user_lastname'];
                $user_phone = $_POST['user_phone'];
                $user_email = $_POST['user_email'];
                $role_id = $_POST['role_id'];

                $insertQuery = "INSERT INTO users (user_licence_number, user_firstname, user_lastname, user_phone, user_email, role_id) VALUES (?, ?, ?, ?, ?, ?)";
                $insertStmt = $pdo->prepare($insertQuery);
                $insertStmt->execute([$user_licence_number, $user_firstname, $user_lastname, $user_phone, $user_email, $role_id]);

                echo "Enregistrement ajouté avec succès.";
            }

            $pdo = null;
        } catch (PDOException $e) {
            echo "Erreur lors de l'ajout de l'enregistrement : " . $e->getMessage();
        }
    } else {
        echo "Erreur : Le numéro de licence n'a pas été renseigné.";
    }
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
        <br>
        <label>Numéro de licence :</label>
        <input type="text" name="user_licence_number">
        <br>
        <label>Prénom :</label>
        <input type="text" name="user_firstname">
        <br>
        <label>Nom :</label>
        <input type="text" name="user_lastname">
        <br>
        <label>Téléphone :</label>
        <input type="text" name="user_phone">
        <br>
        <label>Email :</label>
        <input type="text" name="user_email">
        <br>
        <label>Rôle :</label>
        <select name="role_id">
            <option value="1">Arbitre</option>
            <option value="2">Coach</option>
            <option value="3">Joueur</option>
        </select>
        <br>
        <input type="submit" value="Ajouter">
    </form>
</body>

</html>