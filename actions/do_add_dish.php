<?php
    if (!isset($_POST['ctg_id'])) { header('Location: /index.php'); die; }
    require_once ($_SERVER['DOCUMENT_ROOT'] . '/connect.php');
    
    $_POST['name'] = trim($_POST['name']);
    $query = pdo()->prepare("SELECT * FROM dish WHERE (category_id = :ctg_id) AND (name = :name)");
    $query->execute(['ctg_id' => $_POST['ctg_id'], 'name' => $_POST['name']]);
    if ($query->rowCount() > 0) {
        $_SESSION['error'] = "Ошибка! Блюдо уже существует.";
        header('Location: /index.php');
        die;
    } 

    $query = pdo()->prepare("CALL new_dish(?, ?, ?)");
    $query->bindParam(1, $_POST['ctg_id'], PDO::PARAM_INT); 
    $query->bindParam(2, $_POST['name'], PDO::PARAM_STR); 
    $query->bindParam(3, $_POST['price'], PDO::PARAM_INT); 
    $query->execute();

    header('Location: /index.php');
?>