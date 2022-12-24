<?php
    if (!isset($_POST['login'])) { header('Location: /index.php'); die; }
    require_once ($_SERVER['DOCUMENT_ROOT'] . '/connect.php');

    $query = pdo()->prepare("SELECT * FROM account WHERE login = :login");
    $query->execute(['login' => $_POST['login']]);
    if (!$query->rowCount()) {
        $_SESSION['message'] = 'Ошибка! Пользователь не существует.';
        session_write_close();
        header('Location: /index.php');
        die;
    }

    $query = pdo()->prepare("SELECT password FROM account WHERE login = :login");
    $query->execute(['login' => $_POST['login']]);

    if ($query->fetchColumn() === md5($_POST['password'])){
        $employed = pdo()->prepare("SELECT is_employed FROM employee WHERE login = :login");
        $employed->execute(['login' => $_POST['login']]);
        if (!$employed->fetchColumn()) {
            $_SESSION['message'] = 'Ошибка! Вы уволены.';
            session_write_close();
            header('Location: /index.php');
            die;
        }
        $_SESSION['user'] = $_POST['login'];
        $_SESSION['pass'] = md5($_POST['password']);
        $_SESSION['cur_user'] = getUser($_POST['login']);
        session_write_close();
        header('Location: /main.php');
    } else {
        $_SESSION['message'] = 'Ошибка! Неверный пароль.';
        session_write_close();
        header('Location: /index.php');
    }
?>