<?php if (!isset($_POST['table_id'])) { header('Location: /main.php');die; } ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Меню</title>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/style/shared.css">
    <link rel="stylesheet" href="/style/show_menu.css">
    <link rel="stylesheet" href="/style/menu.css">
</head>
<body>
    <div id="menu-wrapper">    
        <div id="category-wrapper" class="blue-bg">
            <div style="margin-bottom: 5px"><span>Категория</span></div>
            <button class="pink-button" name="0" onclick="onbutton(this)">Популярное</button>
            <?php
                require_once ($_SERVER['DOCUMENT_ROOT'] . '/connect.php');
                $_SESSION['cur_table'] = $_POST['table_id'];
                $query = pdo()->prepare("SELECT * FROM dish_classifier");
                $query->execute();
                while($row = $query->fetch(PDO::FETCH_ASSOC)) 
                    echo '<button class="pink-button" name="'.$row['id'].'" onclick="onbutton(this)">'.$row['name'].'</button>';
            ?>
            
            <button class="purple-button"><a href=/common_permits/show_orders.php>Назад</a></button>
        </div>
        <div class="blue-bg container">
            <ul id="menu-container"></ul>
        </div>
        <div class="blue-bg container" style="visibility: visible;">
            <div style="margin-bottom: 5px"><span>Заказ столика #<?php echo $_POST['table_id']?></span></div>
            <ul id="order-container"></ul>
            <form action="<?php if (isset($_POST['create'])) echo "/actions/do_add_order.php"; else echo "/actions/do_edit_order.php"?>" method="post">
                <input type="hidden" name="order_ids">
                <input type="hidden" name="order_counter">
                <button style="margin: 0; visibility: hidden" class="purple-button" onclick="onorder()" disabled>Подтвердить</button>
            </form>
        </div>
    </div>
</body>
<script src="/waiter_permits/add_order.js"></script>
<script>document.getElementById('category-wrapper').children[1].click();</script>
</html>