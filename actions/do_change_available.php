<?php
    if (isset($_POST['id'])) {
        require_once ($_SERVER['DOCUMENT_ROOT'] . '/connect.php');
    
        $query = pdo()->prepare("CALL change_status_dish(?)");
        $query->bindParam(1, $_POST['id'], PDO::PARAM_INT); 
        $query->execute();
    } else header('Location: /main.php');
?>