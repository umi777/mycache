<!DOCTYPE html>
<html lang="ru">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<link rel="stylesheet" href="template/styles.css?v=1.001">
</head>
<body>
<div class="container">
    <form id="send" action="action_page.php" method="post">

        <label for="product_name">Наименование</label>
        <input type="text" id="product_name" name="product_name" placeholder="название..." required>

        <label for="price">Сумма</label>
        <input type="text" id="price" name="price" placeholder="Сумма..." required pattern="^[0-9]*[.,]?[0-9]+$">

        <label for="category">Категория</label>
        <select id="category" name="category">
            <option value="eda">Еда</option>
            <option value="byt">Быт</option>
            <option value="cat">Жужа</option>
            <option value="auto">Машина</option>
        </select>

        <label for="date">Дата</label>
        <input id="date" name="date" type="date" value="<?=date("Y-m-d")?>">

        <input type="submit" value="Отправить" name="sendcheck">
        <input type="hidden" value="sendcheck" name="send">

    </form>
<div id="checklist" class="check"></div>
</div>
<script src="template/script.js?v=1.001"></script>
<script>
  obj = <?echo(json_encode($db->listCheck(), JSON_UNESCAPED_UNICODE));?>;
  // document.getElementById("checklist").innerText = "obj";
  renderTable(obj);
</script>
</body>
</html>