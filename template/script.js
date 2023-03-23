$(document).ready(function () {
    $("form").submit(function () {
        // Получение ID формы
        var formID = $(this).attr('id');
        // Добавление решётки к имени ID
        var formNm = $('#' + formID);

        $.ajax({
            type: "POST",
            url: 'ajax.php',
            dataType: "json",
            data: formNm.serialize(),
            beforeSend: function () {
                // Вывод текста в процессе отправки
                formNm.append('<p id="msg" style="text-align:center;display: inline-block;">Отправка...</p>');
                $('input[type="submit"]').attr('disabled', true);
            },
            success: function (data) 
            {
                $("#msg").remove();
                renderTable (data,formNm);
                $('input[type="submit"]').attr('disabled', false);
                // Вывод текста результата отправки
                // formNm[0].reset();
                // $("#name").focus();
            }
            ,
            error: function (jqXHR, text, error) {
                // Вывод текста ошибки отправки
                $(".check").html(error);
            }
        });
        return false;
    });
});

function renderTable (jsondata,formNm = null) {
    // const obj = JSON.parse(jsondata, function (key, value) {
        // if (key == "date") {
        // return new Date(value);
        // } else {
        // return value;
        // }
    // });
    var table = document.createElement("table");
    var head = table.createTHead();
    var headrow = head.insertRow(-1);
    headrow.insertCell(-1).innerText = "Название";
    headrow.insertCell(-1).innerText = "Цена";
    headrow.insertCell(-1).innerText = "Категория";
    headrow.insertCell(-1).innerText = "Дата";
    var body = table.createTBody();
    var total = {};
    // obj.forEach(renderTbody);
    jsondata.forEach(renderTbody);
    var foot = table.createTFoot();
    cell = foot.insertRow(-1).insertCell(0);
    cell.innerHTML = "<b>ИТОГО:</b>"
    cell.colSpan = 4;
    for (let prop in total) {
    row = foot.insertRow(-1);
    cell = row.insertCell(-1);
    cell.colSpan = 2;
    cell.innerHTML = total[prop].runame;
    cell = row.insertCell(-1);
    cell.colSpan = 2;
    cell.innerHTML = total[prop].summa;
    }
    $("#checklist").empty();
    document.getElementById("checklist").appendChild(table);
    if (formNm){
        formNm[0].reset()
    }

    $("#product_name").focus();
    function renderTbody(item, index, arr) {
        var row = body.insertRow(index);
        row.insertCell(0).innerText = item.product_name;
        row.insertCell(1).innerText = item.sum;
        row.insertCell(2).innerText = item.ru_name;
        row.insertCell(3).innerText = new Date(item.date).toLocaleDateString();
        if (item.category_name in total) {
        total[item.category_name].summa += parseFloat(item.sum);
        } else {
          total[item.category_name] = {summa : parseFloat(item.sum), runame : item.ru_name,};
        }
    }
}
