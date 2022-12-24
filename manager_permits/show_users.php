<?php 
    require_once ($_SERVER['DOCUMENT_ROOT'] . '/connect.php'); 
    if (($_SESSION['cur_user']['role_id'] != 1) || !isset($_POST['show_users'])) { header('Location: /index.php'); die; }
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Работники</title>
    <link rel="stylesheet" href="/style/shared.css">
    <link rel="stylesheet" href="/style/show_users.css">
</head>
<body>
    <div id="users-wrapper" class="blue-bg">
        <div><span>Работники</span></div>
        <div id="users-scrollable"><?php
            require_once ($_SERVER['DOCUMENT_ROOT'] . '/connect.php');

            $query = pdo()->prepare('SELECT * FROM Employee ORDER BY id');
            $role = pdo()->prepare('SELECT name FROM role_classifier WHERE id = :id');
            $query->execute();

            echo "<table>";
            echo "<tr class=\"title\"><td>#</td><td>Роль</td><td>Имя</td><td>Фамилия</td><td>Зарплата</td><td>Действия</td></tr>";
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $role->execute(['id' => $row['role_id']]);
                echo
                    '<tr><td>'.$row['id'].'</td>
                    <td>'.$role->fetchColumn().'</td>
                    <td>'.$row['first_name'].'</td>'.'</td>
                    <td>'.$row['last_name'].'</td>
                    <td>'.$row['salary'].'</td>';
                if ($row['is_employed']) echo '<td>'.
                    "<form action=\"/manager_permits/more_info.php\" method=\"POST\">
                        <button class=\"pink-button\" name= \"id\" value=\"$row[id]\">Контакты</button>
                    </form>".
                    "<form action=\"/manager_permits/change_salary.php\" method=\"POST\">
                        <input type=\"hidden\" name=\"salary\" value=\"$row[salary]\">
                        <button class=\"pink-button\" name= \"id\" value=\"$row[id]\">Изменить зарплату</button>
                    </form>".
                    "<form action=\"/actions/do_fire_employee.php\" method=\"POST\">
                        <input type=\"hidden\" value=\"0\" name=\"emp_state\">
                        <button class=\"purple-button\" name= \"id\" value=\"$row[id]\">Уволить</button>
                    </form>";
                else echo '<td>'.
                    "<form action=\"/actions/do_fire_employee.php\" method=\"POST\">
                        <input type=\"hidden\" value=\"1\" name=\"emp_state\">
                        <button class=\"purple-button\" name= \"id\" value=\"$row[id]\">Восстановить</button>
                    </form>";
                echo '</td></tr>';
            }
            echo "</table>";
        ?></div>
        <div><button class="purple-button"><a href="/main.php">Назад</a></button></div>
    </div>
</body>
</html>