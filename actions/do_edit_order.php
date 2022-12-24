<?php
    if (!isset($_POST['order_ids'])) { header('Location: /common_permits/show_orders.php'); die; }

    require_once ($_SERVER['DOCUMENT_ROOT'] . '/connect.php');
    $dishes = json_decode($_POST['order_ids']);
    $quantites = json_decode($_POST['order_counter'], true);
    
    $query = pdo()->prepare('SELECT order_id FROM restaurant_table WHERE id = :id');
    $query->execute(['id' => $_SESSION['cur_table']]);
    $order = $query->fetchColumn();


    $query = pdo()->prepare('CALL fill_ordered_dish(?, ?)');
    $query->bindValue(1, $order, PDO::PARAM_INT);    
    for ($i=0; $i < count($dishes); $i++) {
        for ($j=0; $j < $quantites[$dishes[$i].'-count']; $j++) { 
            $query->bindValue(2, $dishes[$i], PDO::PARAM_INT);
            $query->execute();
        }
    }

    $_SESSION['cur_table'] = null;
    header('Location: /common_permits/show_orders.php');
?>