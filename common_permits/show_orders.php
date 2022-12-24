<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Столики</title>
    <link rel="stylesheet" href="/style/shared.css">
    <link rel="stylesheet" href="/style/show_orders.css">
</head>
<body>
    <div id="tables-wrapper" class="blue-bg">
        <div id="tables-scrollable">
            <div style="width: 950px;">
                <?php 
                    require_once ($_SERVER['DOCUMENT_ROOT'] . '/connect.php');
                    $role = $_SESSION['cur_user']['role_id'];
                    $query = pdo()->prepare("SELECT * FROM restaurant_table ORDER BY id");
                    $query->execute();
                    
                    $i = 0;
                    while($row = $query->fetch(PDO::FETCH_ASSOC)){
                        $background = is_null($row['order_id']) ? '#478517' : '#C7007D';
                        if ($i == 0) echo "<div class=\"tables-row\">";
                        echo '<div class="tables-elem title" onclick="ontable(this)" style="background:'.$background.'" id="'.$row['id'].'" waiter="'.$row['waiter_id'].'">Столик #'.$row['id'].'</div>';
                        if ($i == 3) echo "</div>";
                        $i = $i == 3 ? 0 : $i + 1;
                    }
                ?>
            <div>
        </div>
    </div>
</body>
<script>
    function ontable(elem) {
        var row = document.querySelector('.btn-row');
        if (row) row.remove();
        if (elem.style.background == 'rgb(71, 133, 23)') document.body.innerHTML += /*html*/ `
            <div class="btn-row">
                <?php if (in_array($role, [1, 2])) echo
                    "<form action=\"/waiter_permits/add_order.php\" method=\"POST\">
                        <input type=\"hidden\" name=\"table_id\">
                        <button class=\"pink-button\" type=\"submit\" name=\"create\">Создать заказ</button> 
                    </form>"; ?> 
                <button class="purple-button"><a href="/main.php">Назад</a></button>
            </div>`;
        else  document.body.innerHTML += /*html*/ `
            <div class="btn-row">
                <?php if (in_array($role, [1, 2])) { echo
                "<form action=\"/waiter_permits/add_order.php\" method=\"POST\">
                    <input type=\"hidden\" name=\"table_id\">
                    <button class=\"pink-button\" type=\"submit\" name=\"edit\">Дополнить заказ</button> 
                </form>".
                
                "<form action=\"/waiter_permits/close_order.php\" method=\"POST\">
                    <input type=\"hidden\" name=\"table_id\">
                    <button class=\"pink-button\" type=\"submit\">Закрыть заказ</button> 
                </form>"; 
                } else if ($role == 3) echo 
                "<form action=\"/cook_permits/get_order.php\" method=\"POST\">
                    <input type=\"hidden\" name=\"table_id\">
                    <button class=\"pink-button\" type=\"submit\">Просмотреть заказ</button> 
                </form>"; ?> 
                <button class="purple-button"><a href="/main.php">Назад</a></button>
            </div>`;
        try {document.querySelectorAll('input').forEach(el => { el.value = elem.id; })} catch (error){};

        var closeOrder = document.querySelector("form[action='/waiter_permits/close_order.php']");
        if (elem.getAttribute('waiter') != <?php echo $_SESSION['cur_user']['id']?>) {
            try {closeOrder.style.display = 'none';} catch (error) {};
        }
    }

    setTimeout(() => {
        document.body.innerHTML += /*html*/ 
            `<div class="btn-row"><button class="purple-button"><a href="/main.php">Назад</a></button></div>`;
    }, 0);
</script>
</html>