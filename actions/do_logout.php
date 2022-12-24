<?php
    session_start();
    session_unset();
    $_SESSION['cur_user'] = null;
    session_write_close();
    header('Location: /');
?>