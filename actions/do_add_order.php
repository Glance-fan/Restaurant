<?php
    if (!isset($_POST['order_ids'])) { header('Location: /common_permits/show_orders.php'); die; }

    require_once ($_SERVER['DOCUMENT_ROOT'] . '/connect.php');
    $dishes = json_decode($_POST['order_ids']);
    $quantites = json_decode($_POST['order_counter'], true);
    
    $query = pdo()->prepare('SELECT new_order(?)');
    $query->bindParam(1, $_SESSION['cur_user']['id'], PDO::PARAM_INT); 
    $query->execute();
    $order_id = $query->fetch(PDO::FETCH_ASSOC);

    $query = pdo()->prepare('CALL fill_ordered_dish(?, ?)');
    $query->bindValue(1, $order_id['new_order'], PDO::PARAM_INT);    
    for ($i=0; $i < count($dishes); $i++) {
        for ($j=0; $j < $quantites[$dishes[$i].'-count']; $j++) { 
            $query->bindValue(2, $dishes[$i], PDO::PARAM_INT);
            $query->execute();
        }
    }

    $query = pdo()->prepare('UPDATE Restaurant_table SET order_id = :id, waiter_id = :waiter WHERE id = :table_id');
    $query->execute([
        'id' => $order_id['new_order'], 
        'waiter' => $_SESSION['cur_user']['id'],
        'table_id' => $_SESSION['cur_table'],
    ]);

    $_SESSION['cur_table'] = null;
    header('Location: /common_permits/show_orders.php');
?>