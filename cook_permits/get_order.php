<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Заказ</title>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/style/shared.css">
    <link rel="stylesheet" href="/style/get_order.css">
</head>
<body>
    <div class="blue-bg" id="order-wrapper">
        <div><span>Заказ столика #<?php echo $_POST['table_id']; ?></span></div>
        <div id="order-scrollable">
        <?php
            require_once ($_SERVER['DOCUMENT_ROOT'] . '/connect.php');
            $query = pdo()->prepare('SELECT order_id FROM restaurant_table WHERE id = :id');
            $query->execute(['id' => $_POST['table_id']]);
            $id = $query->fetchColumn();
            
            $query = pdo()->prepare('SELECT * FROM ordered_dish WHERE order_id = :id ORDER  BY dish_id');
            $query->execute(['id' => $id]);
            
            $i=0;
            while ($dish = $query->fetch(PDO::FETCH_ASSOC)) {
                $name = pdo()->prepare('SELECT name FROM dish WHERE id = :id');
                $name->execute(['id' => $dish['dish_id']]);
                $isChecked = $dish['ready'] ? 'checked' : ''; 

                echo '<div><input id='.$dish['uid'].' type="checkbox" '.$isChecked.' onclick="onchbx(this)">'.$name->fetchColumn().'</div>';       
            }
        ?>
        </div>
        <div><button class="purple-button"><a href="/common_permits/show_orders.php">Назад</a></button></div>
    </div>
</body>
<script>
    function onchbx(elem) {
        if (!elem.checked) {
            elem.checked = true;
            return;
        } 
        
        $.ajax({
            url: '/actions/do_cook_dish.php',
            type: 'post',
            dataType: 'json',
            data: { "id": parseInt(elem.id)},
            success: function(data) { 
                alert(data);
                }
        });
    }
</script>
</html>