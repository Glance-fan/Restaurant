<?php
    require_once ($_SERVER['DOCUMENT_ROOT'] . '/connect.php');
    if ($_SESSION['cur_user']['role_id'] != 1 || !isset($_POST['add_user'])) {
        header('Location: /index.php');
        die;
    }
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавить работника</title>
    <link rel="stylesheet" href="/style/shared.css">
    <link rel="stylesheet" href="/style/add_user.css">
</head>
<body>
    <div class="blue-bg" id="new-user-wrapper">
        <form action="/actions/do_add_user.php" method="post">
            <div>
                <span>Учетные данные</span>
                <input type="text" placeholder="Логин" name="login" autocomplete="false" spellcheck="false" required>
                <input type="text" placeholder="Пароль" name="password" autocomplete="false" spellcheck="false" required>
                <select name="role"><?php
                    $query = pdo()->prepare("SELECT * FROM role_classifier");
                    $query->execute();
                    while($row = $query->fetch(PDO::FETCH_ASSOC)) 
                        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                ?></select>
            </div>
            <div>
                <span>Контактная информация</span>
                <input type="text" placeholder="Имя" name="first_name" autocomplete="false" spellcheck="false" required>
                <input type="text" placeholder="Фамилия" name="last_name" autocomplete="false" spellcheck="false" required>
                <input type="text" placeholder="Номер телефона" name="phone_number" autocomplete="false" spellcheck="false" required>
                <input type="text" placeholder="Электронная почта" name="email" autocomplete="false" spellcheck="false" required>
            </div>
            <div>
                <button type="submit" class="pink-button">Добавить</button>
                <button class="purple-button"><a href="/main.php">Назад</a></button>
            </div>
        </form>
    </div>
</body>
</html>