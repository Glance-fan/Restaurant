function onbutton(btn) {
    $.ajax({
        url: '/actions/do_show.php',
        type: 'post',
        dataType: 'json',
        data: { "category_get": parseInt(btn.name)},
        success: function(data) { 
            var parent = document.querySelector('.container'); 
            parent.innerHTML = /*html*/`<div style="margin-bottom:5px"></div><ul id="menu-container"></ul>`;
            var container = parent.lastElementChild;
            data.forEach(el => {
                if (el[3]) 
                    container.innerHTML += /*html*/ `<li id="${el[0]}" onclick="ondish(this)">${el[1]}</li>`;
                if (container.children.length > 0) {
                        parent.firstElementChild.innerHTML = `<span>Меню — ${btn.innerText}</span>`;
                        parent.style.visibility = 'visible';
                } else parent.style.visibility = 'hidden';
            });
         }
    });
}

var order_indexes = [];
var order_counter = {};
var confirmbtn = document.querySelector('form').lastElementChild;
function ondish(dish) {
    var parent = document.getElementById('order-container');
    var idx = order_indexes.indexOf(dish.id);
    if (idx == -1) {
        order_indexes.push(dish.id);
        order_counter[`${dish.id}-count`] = 1;
        parent.innerHTML += /*html*/ `<li id="${dish.id}-order" onclick="onremove(this)">${dish.innerHTML} (x1)</li>`;
    } else {
        order_counter[`${dish.id}-count`]++;
        var el = document.getElementById(`${dish.id}-order`);
        el.innerText = `${el.innerText.split('(x')[0]}(x${order_counter[dish.id + '-count']})`;
    }
    confirmbtn.style.visibility = 'visible';
    confirmbtn.disabled = false;
}

function onremove(el) {
    var id = parseInt(el.id);
    var idx = order_indexes.indexOf(id);
    if (order_counter[`${id}-count`] == 1) {
        delete order_counter[`${id}-count`];
        order_indexes.splice(idx, 1);
        el.remove();
    } else {
        order_counter[`${id}-count`]--;
        var el = document.getElementById(`${id}-order`);
        el.innerText = `${el.innerText.split('(x')[0]}(x${order_counter[id + '-count']})`;
    }
    if (document.getElementById('order-container').children.length == 0) {
        confirmbtn.disabled = true;
        confirmbtn.style.visibility = 'hidden';
    }
}

function onorder() {
    document.querySelector('[name="order_ids"]').value = JSON.stringify(order_indexes);
    document.querySelector('[name="order_counter"]').value = JSON.stringify(order_counter);
}
