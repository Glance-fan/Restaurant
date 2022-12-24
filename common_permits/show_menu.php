<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Меню</title>
    <link rel="stylesheet" href="/style/shared.css">
    <link rel="stylesheet" href="/style/show_menu.css">
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
</head>
<body>
    <div id="menu-wrapper">
        <div id="category-wrapper" class="blue-bg">
            <div style="margin-bottom: 5px"><span>Категория</span></div>
            <button class="pink-button" name="0" onclick="onbutton(this)">Популярное</button>
            <?php
                require_once ($_SERVER['DOCUMENT_ROOT'] . '/connect.php');

                $query = pdo()->prepare("SELECT * FROM dish_classifier");
                $query->execute();
                while($row = $query->fetch(PDO::FETCH_ASSOC)) 
                    echo '<button class="pink-button" name="'.$row['id'].'" onclick="onbutton(this)">'.$row['name'].'</button>';
                
            ?>
            <button class="purple-button"><a href=/main.php>Назад</a></button>
        </div>
        <div class="blue-bg container">
            <div id="menu-container"></div>
        </div>
    </div>
    <script>
        function onbutton(btn) {
            $.ajax({
                url: '/actions/do_show.php',
                type: 'post',
                dataType: 'json',
                data: { "category_get": parseInt(btn.name)},
                success: function(data) { 
                    var parent = document.querySelector('.container'); 
                    parent.innerHTML = /*html*/`<div style="margin-bottom:5px"></div><div id="menu-container"></div>`;
                    var container = parent.lastElementChild;
                    var cook;
                    data.forEach(el => {
                        cook = <?php $temp = $_SESSION['cur_user']['role_id'] == 3 ? 1 : 0; echo $temp;?>;
                        if (cook == false) {
                            if (el[3]) container.innerHTML += /*html*/ `<div class="menu-elem"><p>${el[1]}</p><span>${el[2]}</span></div>`;
                        }
                        
                        else container.innerHTML += /*html*/ `<div class="menu-elem"><input class="checkbox" ${el[3] ? 'checked' : ''} type="checkbox" onclick="onchbx(this)" id="${el[0]}"><label for="${el[0]}">${el[1]} <span>${el[2]}</span></label></div>`;
                    });
                    if (container.children.length > 0) {
                        parent.firstElementChild.innerHTML = `<span>Меню — ${btn.innerText}</span>`;
                        parent.style.visibility = 'visible';
                    } else parent.style.visibility = 'hidden';
                 }
            });
        }

        function onchbx(el){
            $.ajax({
                url: '/actions/do_change_available.php',
                type: 'post',
                dataType: 'json',
                data: { "id": parseInt(el.id)},
                success: function (data) {
                    alert(data);
                }
            })
        }
    </script>
    <script>document.getElementById('category-wrapper').children[1].click();</script>
</body>
</html>