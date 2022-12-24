<?php
    require_once ($_SERVER['DOCUMENT_ROOT'] . '/connect.php');
    if ($_SESSION['cur_user']['role_id'] != 1 || !isset($_POST['add_dish'])) {
        header('Location: /index.php');
        die;
    }
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавить блюдо</title>
    <link rel="stylesheet" href="/style/shared.css">
    <link rel="stylesheet" href="/style/add_dish.css">
</head>
<body>
    <div class="blue-bg" id="new-dish-wrapper">
        <div><span>Новое блюдо</span></div>
        <form action="/actions/do_add_dish.php" method="post">
            <select name="ctg_id"><?php
                $query = pdo()->prepare("SELECT * FROM dish_classifier");
                $query->execute();
                while($row = $query->fetch(PDO::FETCH_ASSOC)) 
                    echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
            ?></select>
            <input name="name" placeholder="Название" autocomplete="false" spellcheck="false" required>
            <input name="price" placeholder="Цена" autocomplete="false" spellcheck="false" maxlength="6" onkeydown="javascript: return [8,46,37,39].includes(event.keyCode) ? true : !isNaN(Number(event.key)) && event.keyCode!=32" required>
            <div>
                <button type="submit" class="pink-button">Добавить</button>
                <button class="purple-button"><a href="/main.php">Назад</a></button>
            </div>
        </form>
    </div>
</body>
</html>