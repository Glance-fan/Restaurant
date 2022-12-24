<?php
    if (isset($_POST['id'])) {
        require_once ($_SERVER['DOCUMENT_ROOT'] . '/connect.php');
        $query = pdo()->prepare("UPDATE ordered_dish SET ready = true WHERE uid = :id");
        $query->execute(['id' => $_POST['id']]);
    } else header('Location: /main.php');
?>
