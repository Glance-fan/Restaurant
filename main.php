<?php
    require_once ($_SERVER['DOCUMENT_ROOT'] . '/connect.php');
    if (is_null($_SESSION['cur_user'])) {
        header('Location: /index.php');
        die;
    }
    $role = $_SESSION['cur_user']['role_id'];
    $query = pdo($_SESSION['user'], $_SESSION['pass'])->prepare('SELECT name FROM role_classifier WHERE id = :id');
    $query->execute(['id' => $role]);
    $role_name = $query->fetchColumn();

    $name = $_SESSION['cur_user']['first_name'].' '.$_SESSION['cur_user']['last_name'];
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Claude Monet</title>
    <link rel="stylesheet" href="/style/shared.css">
    <link rel="stylesheet" href="/style/main.css">
</head>
<body>
    <div id="main-wrapper" class="blue-bg">
        <div style="font-weight: 700;">Добро пожаловать, <span><?php echo $name?></span></div>
        <div style="font-weight: 700;">Роль: <span><?php echo $role_name?></span></div>
        <div id="actions-wrapper">
            <?php if ($role == 1) echo "<div><form method=\"POST\" action=\"/manager_permits/add_user.php\"><button class=\"pink-button\" type=\"submit\" name=\"add_user\">Добавить работника</button></form></div>" ?>
            <?php if ($role == 1) echo "<div><form method=\"POST\" action=\"/manager_permits/show_users.php\"><button class=\"pink-button\" name=\"show_users\">Просмотреть работников</button></form></div>" ?>

            <?php if ($role == 1) echo "<div><form method=\"POST\" action=\"/manager_permits/add_dish.php\"><button class=\"pink-button\" type=\"submit\" name=\"add_dish\">Добавить блюдо</button></form></div>" ?>
            
            <div><button class="pink-button"><a href="/common_permits/show_orders.php">Заказы</a></button></div>
            <div><button class="pink-button"><a href="/common_permits/show_menu.php">Посмотреть меню</a></button></div>
            <?php if ($role == 1) echo "<div><button class=\"pink-button\"><a href=\"/manager_permits/statistics_day.php\">Статистика за день</a></button></div>" ?>
            <?php if ($role == 1) echo "<div><button class=\"pink-button\"><a href=\"/manager_permits/statistics_week.php\">Статистика за неделю</a></button></div>" ?>

            <div><form action="/actions/do_logout.php"><button class="purple-button" type="submit">Выйти</button></form></div>
        </div>
    </div>
    <script>
        var el = document.getElementById('main-wrapper');
        var elTop = el.offsetHeight / 2;
        var elLeft = el.offsetWidth / 2;
        el.style.top = `calc(50% - ${elTop}px)`;
        el.style.left = `calc(50% - ${elLeft}px)`;
    </script>
</body>
</html>