<?php   
    session_start();

    function pdo(): PDO {
        static $pdo;
        if (!$pdo) {
            $config = [
                'db_host' => 'localhost',
                'db_port' => '5432',
                'db_name' => 'Restaurant',
                'db_user' => $_SESSION['user'] ?? 'Login',
                'db_pass' => $_SESSION['pass'] ?? 'f5234a478d8ae58ec8c0022b257cff89',
                'charset' => '\'--client_encoding=UTF8\'',
            ];
            $dsn = 'pgsql:host='.$config['db_host'].';port='.$config['db_port'].';dbname='.$config['db_name'].';options='.$config['charset'];
            try {
                $pdo = new PDO($dsn, $config['db_user'], $config['db_pass'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
                $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            } catch (Exception $e) {
                session_unset();
                header('Location: /index.php');
                die;
            }
        }
        return $pdo;
    }
    
    function getUser($login) {
        $query = pdo($login)->prepare("SELECT * FROM Employee WHERE Login = :login");
        $query->execute(['login' => $login]);
        $user = $query->fetch(PDO::FETCH_ASSOC);
        return $user;
    }
?>