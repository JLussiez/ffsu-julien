<?php
require('Connexion.php');
require('Menu.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Your existing code for database connection
    $pdo = connect();

    // Check if file is uploaded
    if (isset($_FILES['excel_file']) && $_FILES['excel_file']['error'] === UPLOAD_ERR_OK) {
        // Process the uploaded Excel file
        $excelFile = $_FILES['excel_file']['tmp_name'];

        // Use a library like PHPExcel or PhpSpreadsheet to read Excel files
        // Example using PhpSpreadsheet:
        require 'vendor/autoload.php'; // Include PhpSpreadsheet library

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($excelFile);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        // Process the data and insert into the database
        foreach ($sheetData as $index => $row) {
            // Skip the header (first row)
            if ($index === 1) {
                continue;
            }

            // Cast values to appropriate types
            $user_licence_number = (int) $row['A'];
            $user_firstname = $row['B'];
            $user_lastname = $row['C'];
            $user_phone = (int) $row['D'];
            $user_email = $row['E'];
            $role_id = (int) $row['F'];

            // Validate or sanitize data if necessary

            $stmt = $pdo->prepare("INSERT INTO users (user_licence_number, user_firstname, user_lastname, user_phone, user_email, role_id) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$user_licence_number, $user_firstname, $user_lastname, $user_phone, $user_email, $role_id]);
        }

        echo "Data from Excel file added to the database successfully.";
    } else {
        echo "Please upload a valid Excel file.";
    }
}
?>

<form action="" method="post" enctype="multipart/form-data">
    <!-- Your existing form fields -->

    <label for="excel_file">Excel File:</label>
    <input type="file" name="excel_file" accept=".xlsx, .xls">
    <br>

    <input type="submit" value="Ajouter">
</form>