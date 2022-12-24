<?php
    require_once ($_SERVER['DOCUMENT_ROOT'] . '/connect.php');
    if ($_SESSION['cur_user']['role_id'] != 1 || !isset($_POST['id'])) {
        header('Location: /index.php');
        die;
    }

    $query = pdo()->prepare('SELECT first_name, last_name FROM employee WHERE id = :id');
    $query->execute(['id' => $_POST['id']]);
    $name = $query->fetch(PDO::FETCH_ASSOC);
    $name = $name['first_name'].' '.$name['last_name'];
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Поменять зарплату работника</title>
    <link rel="stylesheet" href="/style/change_salary.css">
    <link rel="stylesheet" href="/style/shared.css">
</head>
<body>
    <div id="new-salary-wrapper" class="blue-bg">
        <div>Зарплата <span><?php echo $name?></span></div>
        <form action="/actions/do_change_salary.php" method="post">
            <div>
                <div class="old-salary"><?php echo $_POST['salary']?></div>
                <div style="font-size: 20px">🠚</div>
                <input type="text" placeholder="Зарплата" name="new_salary" maxlength="10" onkeydown="javascript: return [8,46,37,39].includes(event.keyCode) ? true : !isNaN(Number(event.key)) && event.keyCode!=32" required>
            </div>
            <div>
                <button class="pink-button" type="submit" name="id" value="<?php echo $_POST['id'] ?>">Изменить</button>
                <button class="purple-button"><a href="/main.php">Назад</a></button>
            </div>
        </form>
    </div>
</body>
</html>