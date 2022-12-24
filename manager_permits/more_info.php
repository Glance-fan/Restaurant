<?php if (!isset($_POST['id'])) { header('Location: /main.php'); die; }?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Контакты</title>
    <link rel="stylesheet" href="/style/shared.css">
    <link rel="stylesheet" href="/style/more_info.css">
</head>
<body>
    <div id="info-wrapper" class="blue-bg">
        <?php
            require_once ($_SERVER['DOCUMENT_ROOT'] . '/connect.php');

            $query = pdo()->prepare('SELECT * FROM employee WHERE id = :id');
            $query->execute(['id' => $_POST['id']]);
            $info = $query->fetch(PDO::FETCH_ASSOC);

            echo 
                '<div style="text-transform:capitalize;"><span>Имя</span>'.$info['first_name'].'</div>'.
                '<div style="text-transform:capitalize;"><span>Фамилия</span>'.$info['last_name'].'</div>'.
                '<div><span>Номер телефона</span>'.$info['phone_number'].'</div>'.
                '<div><span>Электронная почта</span>'.$info['email'].'</div>';
            echo "<form method=\"POST\" action=\"/manager_permits/show_users.php\"><button class=\"purple-button\" name=\"show_users\">Назад</button></form>";

        ?>
    </div>
    <script>
        var el = document.getElementById('info-wrapper');
        var left = el.offsetWidth / 2;
        el.style.left = `calc(50% - ${left}px)`;
    </script>
</body>
</html>