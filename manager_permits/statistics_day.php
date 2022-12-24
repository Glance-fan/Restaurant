<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Статистика за день</title>
    <link rel="stylesheet" href="/style/shared.css">
    <link rel="stylesheet" href="/style/statistics.css">
</head>
<body>
    <div class="blue-bg statistic-wrapper">
        <div><span>Прибыль за день</span></div>
        <div class="statistic-scrollable"><?php 
            require_once ($_SERVER['DOCUMENT_ROOT'] . '/connect.php');
            if ($_SESSION['cur_user']['role_id'] != 1) { header('Location: /index.php'); die; }

            $query = pdo()->prepare('SELECT * FROM waiter_day');
            $query->execute();

            echo "<table>";
            echo "<tr class=\"title\"><td>Имя</td><td>Фамилия</td><td>заработано</td></tr>";
            while($row = $query->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo '<td>'.$row['first_name'].'</td><td>'.$row['last_name'].'</td><td>'.$row['sum'].'</td>';
                echo "</tr>";
            }
            echo "</table></div>";

            $query = pdo()->prepare('SELECT * FROM total_day');
            $query->execute();
            echo '<div class="title">Всего за день: '.$query->fetchColumn().'</div>';
        ?>
        <div><button class="purple-button"><a href="/main.php">Назад</a></button></div>
    </div>
</body>
</html>
