<?php
function connect()
{
      try {
            $pdo = new PDO('mysql:host=localhost;dbname=ffsu_new', 'root', '', [
                  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
            return $pdo;
      } catch (PDOException $e) {
            throw $e;
      }
}

?>