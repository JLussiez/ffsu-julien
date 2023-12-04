<?php
require('Connexion.php');
require('Menu.php');

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

// Traitement de la suppression si un ID est passé en paramètre
if (isset($_GET['delete_user_id'])) {
    $deleteUserId = $_GET['delete_user_id'];

    // Supprimer l'utilisateur si la confirmation est donnée
    if (isset($_GET['confirm']) && $_GET['confirm'] === 'true') {
        deleteUser($deleteUserId);
    } else {
        // Afficher le lien de confirmation
        echo "<a href='DeleteUser.php?delete_user_id=" . $deleteUserId . "&confirm=true'>Confirmer la suppression</a>";
        exit;
    }
}
?>