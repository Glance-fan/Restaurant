<?php
    session_start();
    if (empty($_SESSION['cur_user'])) $_SESSION['cur_user'] = null;
    if (!is_null($_SESSION['cur_user'])) { header('Location: /main.php'); die; }
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход</title>
    <link rel="stylesheet" href="/style/shared.css">
    <link rel="stylesheet" href="/style/login.css">
</head>
<body>
    <div id="auth-wrapper" class="blue-bg">
        <div class="title">Войти в систему ресторана</div>
        <form method="post" action="/actions/do_login.php">
            <input type="text" name="login" placeholder="Логин" autocomplete="false" spellcheck="false" required>
            <input type="password" name="password" placeholder="Пароль" autocomplete="false" spellcheck="false" required>
            <button class="pink-button" type="submit">Войти</button>
        </form>
        <div><span><?php if (!empty($_SESSION['message'])) echo $_SESSION['message']?></span></div>
    </div>
</body>
</html>

<!-- magenta_square SalmonUnderBlackChair  -->
<!-- notorius_baesitter DontEatYellowSnow  -->
<!-- illustrious_oguzok ShipTryedLayingEggs -->