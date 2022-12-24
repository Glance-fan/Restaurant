<?php
    if (!isset($_POST['id'])) { header('Location: /index.php'); die; } 
    require_once ($_SERVER['DOCUMENT_ROOT'] . '/connect.php');
    
    $query = pdo()->prepare("CALL change_salary(?, ?)");
    $query->bindParam(1, $_POST['id'], PDO::PARAM_INT); 
    $query->bindParam(2, $_POST['new_salary'], PDO::PARAM_INT);
    $query->execute();
    header('Location: /manager_permits/show_users.php');
?>