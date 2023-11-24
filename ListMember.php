<?php
require('Connexion.php');
require('Menu.php');

$pdo = connect();

if (isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];
    
    $deleteQuery = "DELETE FROM license_member WHERE id_member = ?";
    $deleteStmt = $pdo->prepare($deleteQuery);
    $deleteStmt->execute([$deleteId]);
}

$query = "SELECT id_member, name, first_name, birthdate, license_number FROM license_member";
$stmt = $pdo->query($query);

$licenses = $stmt->fetchAll(PDO::FETCH_ASSOC);

$pdo = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Licences</title>
</head>
<body>
    <h2>Liste des Licences</h2>
    <table border="1">
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Date de Naissance</th>
            <th>Numéro de Licence</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($licenses as $license) : ?>
            <tr>
                <td><?= $license['name'] ?></td>
                <td><?= $license['first_name'] ?></td>
                <td><?= $license['birthdate'] ?></td>
                <td><?= $license['license_number'] ?></td>
                <td>
                    <a href="?delete_id=<?= $license['id_member'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce membre?')">Supprimer</a>
                    <a href="EditMember.php?id=<?= $license['id_member'] ?>">Modifier</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
