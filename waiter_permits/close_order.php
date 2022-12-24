<?php if (!isset($_POST['table_id'])) { header('Location: /index.php'); die;}?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Создать чек</title>
    <link rel="stylesheet" href="/style/shared.css">
    <link rel="stylesheet" href="/style/close_order.css">
</head>
<body>
    <div id="receipt-wrapper" class="blue-bg">
        <div><span>Чек столика #<?php echo $_POST['table_id']?></span></div>
        <div id="receipt-scrollable">
        <?php
            require_once ($_SERVER['DOCUMENT_ROOT'] . '/connect.php');
            $_SESSION['cur_table'] = $_POST['table_id'];

            $query = pdo()->prepare('SELECT order_id FROM restaurant_table WHERE id = :id');
            $query->execute(['id' => $_SESSION['cur_table']]);
            $id = $query->fetchColumn();

            $query = pdo()->prepare('SELECT dish_id FROM ordered_dish WHERE order_id = :id AND ready = TRUE ORDER BY dish_id');
            $query->execute(['id' => $id]);

            $total = 0;
            while ($id = $query->fetchColumn()) {
                $get_dish = pdo()->prepare('SELECT name, price FROM dish WHERE id = :id');
                $get_dish->execute(['id' => $id]);
                while ($dish = $get_dish->fetch(PDO::FETCH_ASSOC)) {
                    echo '<div class="ordered-elem"><p>'.$dish['name'].'</p><span>'.$dish['price'].'</span></div>';       
                    $total += intval($dish['price']);
                }
            }
        ?>
        </div>
        <?php  echo "<div class=\"title\">Всего: ".$total."</div>"; ?>
        <form action="/actions/do_close_order.php" method="post"> 
            <?php echo "<input name=\"total\" type=\"hidden\" value=\"".$total."\">"?>
            <div>Оплата: 
            <select name="payment"><?php
            $query = pdo()->prepare("SELECT * FROM payment_classifier");
            $query->execute();
            while($row = $query->fetch(PDO::FETCH_ASSOC)) 
                echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
            ?></select></div>
            <div>
                <button class="pink-button" type="submit">Закрыть заказ</button>
                <button class="purple-button"><a href="/common_permits/show_orders.php">Назад</a></button>
            </div>
        </form>
    </div>
</body>
</html>