<?php
    function category_data($index) {
        require_once ($_SERVER['DOCUMENT_ROOT'] . '/connect.php');

        if ($index != 0) {
            $query = pdo()->prepare("SELECT * FROM dish WHERE category_id = :idx ORDER BY id");
            $query->execute(['idx' => $index]);
        } else {
            $query = pdo()->prepare("SELECT * FROM dish WHERE ordered_time <> 0 ORDER BY ordered_time DESC LIMIT 10");
            $query->execute();
        }
        

        $i = 0;
        $data = [];
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $data[$i] = array($row['id'], $row['name'], $row['price'], $row['available']);
            $i++;
        }
        return $data;
    } 

    if (isset($_POST['category_get'])) {
        echo json_encode(category_data(intval($_POST['category_get'])));
    } else header('Location: /index.php');

?>