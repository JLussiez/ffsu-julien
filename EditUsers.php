<?php
require('Connexion.php');
require('Menu.php');

// Fonction pour récupérer les informations d'un utilisateur par son ID
function getUserById($userId)
{
    try {
        $pdo = connect();

        // Sélectionner l'utilisateur avec l'ID spécifié
        $query = "SELECT * FROM users WHERE user_id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$userId]);

        // Récupérer les informations de l'utilisateur
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        $pdo = null;

        return $user;
    } catch (PDOException $e) {
        echo "Erreur lors de la récupération des informations de l'utilisateur : " . $e->getMessage();
        return false;
    }
}

// Fonction pour mettre à jour les informations d'un utilisateur
function updateUser($userId, $userData)
{
    try {
        $pdo = connect();

        // Mettre à jour l'utilisateur avec les nouvelles données
        $query = "UPDATE users SET user_licence_number = ?, user_firstname = ?, user_lastname = ?, user_phone = ?, user_email = ?, role_id = ? WHERE user_id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$userData['user_licence_number'], $userData['user_firstname'], $userData['user_lastname'], $userData['user_phone'], $userData['user_email'], $userData['role_id'], $userId]);

        echo "Utilisateur mis à jour avec succès.";

        $pdo = null;
    } catch (PDOException $e) {
        echo "Erreur lors de la mise à jour de l'utilisateur : " . $e->getMessage();
    }
}

// Fonction pour supprimer un utilisateur
function deleteUser($userId)
{
    try {
        $pdo = connect();

        // Supprimer l'utilisateur avec l'ID spécifié
        $query = "DELETE FROM users WHERE user_id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$userId]);

        echo "Utilisateur supprimé avec succès.";

        $pdo = null;
    } catch (PDOException $e) {
        echo "Erreur lors de la suppression de l'utilisateur : " . $e->getMessage();
    }
}

// Traitement de la mise à jour ou de la suppression si un ID est passé en paramètre
if (isset($_GET['edit_user_id'])) {
    $editUserId = $_GET['edit_user_id'];

    // Récupérer les informations de l'utilisateur
    $user = getUserById($editUserId);

    if (!$user) {
        echo "Utilisateur non trouvé.";
        exit;
    }

    // Traitement du formulaire de mise à jour
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_user'])) {
        $userData = [
            'user_licence_number' => $_POST['user_licence_number'],
            'user_firstname' => $_POST['user_firstname'],
            'user_lastname' => $_POST['user_lastname'],
            'user_phone' => $_POST['user_phone'],
            'user_email' => $_POST['user_email'],
            'role_id' => $_POST['role_id'],
        ];

        // Mettre à jour les informations de l'utilisateur
        updateUser($editUserId, $userData);
    }

    // Afficher le formulaire d'édition
    ?>
    <h2>Modifier les informations de l'utilisateur :</h2>
    <form method="post">
        <!-- Ajoutez les champs du formulaire avec les valeurs actuelles de l'utilisateur -->
        <label for="user_licence_number">Numéro de licence :</label>
        <input type="text" name="user_licence_number" value="<?= $user['user_licence_number'] ?>" required>

        <label for="user_firstname">Prénom :</label>
        <input type="text" name="user_firstname" value="<?= $user['user_firstname'] ?>" required>

        <label for="user_lastname">Nom :</label>
        <input type="text" name="user_lastname" value="<?= $user['user_lastname'] ?>" required>

        <label for="user_phone">Téléphone :</label>
        <input type="text" name="user_phone" value="<?= $user['user_phone'] ?>" required>

        <label for="user_email">Email :</label>
        <input type="email" name="user_email" value="<?= $user['user_email'] ?>" required>

        <label for="role_id">Rôle :</label>
        <input type="text" name="role_id" value="<?= $user['role_id'] ?>" required>

        <button type="submit" name="update_user">Enregistrer les modifications</button>
    </form>

    <!-- Ajouter un lien pour supprimer l'utilisateur -->
    <p><a href="EditUser.php?delete_user_id=<?= $editUserId ?>&confirm=true">Supprimer l'utilisateur</a></p>
    <?php
} elseif (isset($_GET['delete_user_id']) && isset($_GET['confirm']) && $_GET['confirm'] === 'true') {
    // Traitement de la suppression si un ID est passé en paramètre
    $deleteUserId = $_GET['delete_user_id'];
    deleteUser($deleteUserId);
} else {
    echo "ID d'utilisateur non spécifié.";
}
?>