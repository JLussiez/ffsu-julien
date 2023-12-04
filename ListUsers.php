<?php
require('Connexion.php');
require('Menu.php');

try {
    $pdo = connect();

    // Sélectionner toutes les informations de la table users
    $query = "SELECT * FROM users";
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    // Récupérer toutes les lignes de résultats
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Afficher les informations
    if ($users) {
        echo "<h2>Informations de la table users :</h2>";
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Numéro de licence</th><th>Prénom</th><th>Nom</th><th>Téléphone</th><th>Email</th><th>Rôle</th><th>Action</th></tr>";
        foreach ($users as $user) {
            echo "<tr>";
            echo "<td>" . $user['user_id'] . "</td>";
            echo "<td>" . $user['user_licence_number'] . "</td>";
            echo "<td>" . $user['user_firstname'] . "</td>";
            echo "<td>" . $user['user_lastname'] . "</td>";
            echo "<td>" . $user['user_phone'] . "</td>";
            echo "<td>" . $user['user_email'] . "</td>";
            echo "<td>" . $user['role_id'] . "</td>";
            echo "<td><a href='EditUsers.php?edit_user_id=" . $user['user_id'] . "'>Modifier</a> | <a href='DeleteUser.php?delete_user_id=" . $user['user_id'] . "'>Supprimer</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Aucun enregistrement trouvé dans la table users.";
    }

    $pdo = null;
} catch (PDOException $e) {
    echo "Erreur lors de la récupération des informations : " . $e->getMessage();
}
?>