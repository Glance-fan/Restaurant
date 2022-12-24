<?php
    if (!isset($_POST['login'])) { header('Location: /index.php'); die; }
    require_once ($_SERVER['DOCUMENT_ROOT'] . '/connect.php');

    $query = pdo()->prepare("SELECT * FROM account WHERE login = :login");
    $query->execute(['login' => $_POST['login']]);
    if ($query->rowCount() > 0) {
        $_SESSION['error'] = "Ошибка! Пользователь уже существует.";
        header('Location: /index.php');
        die;
    } 

    $query = pdo()->prepare("CALL new_employee(?, ?, ?, ?, ?, ?, ?)");
    $query->bindParam(1, $_POST['login'], PDO::PARAM_STR); 
    $query->bindParam(2, $_POST['password'], PDO::PARAM_STR); 
    $query->bindParam(3, $_POST['first_name'], PDO::PARAM_STR); 
    $query->bindParam(4, $_POST['last_name'], PDO::PARAM_STR); 
    $query->bindParam(5, $_POST['phone_number'], PDO::PARAM_STR); 
    $query->bindParam(6, $_POST['email'], PDO::PARAM_STR); 
    $query->bindParam(7, $_POST['role'], PDO::PARAM_INT); 
    $query->execute();

    header('Location: /index.php');
?>