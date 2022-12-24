<?php 
    if (!isset($_POST['payment'])) { header('Location: /common_permits/show_orders.php'); die; }
    require_once ($_SERVER['DOCUMENT_ROOT'] . '/connect.php');

    $query = pdo()->prepare('SELECT order_id FROM restaurant_table WHERE id = :id');
    $query->execute(['id' =>  $_SESSION['cur_table']]);
    $id = $query->fetchColumn();

    $query = pdo()->prepare('CALL close_order(?, ?, ?)');
    $query->bindValue(1, $id, PDO::PARAM_INT);
    $query->bindParam(2, $_POST['total'], PDO::PARAM_INT);
    $query->bindParam(3, $_POST['payment'], PDO::PARAM_INT);
    $query->execute();

    header('Location: /common_permits/show_orders.php');
?>
