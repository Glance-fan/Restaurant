<?php
    require_once ($_SERVER['DOCUMENT_ROOT'] . '/connect.php');
    if ($_SESSION['cur_user']['role_id'] != 1) { header('Location: /index.php'); die; } 

    $query = pdo()->prepare("CALL fire_employee(?, ?)");
    $query->bindParam(1, $_POST['id'], PDO::PARAM_INT); 
    $query->bindValue(2, intval($_POST['emp_state']), PDO::PARAM_BOOL); 
    $query->execute();
    
    header('Location: /manager_permits/show_users.php');
?>