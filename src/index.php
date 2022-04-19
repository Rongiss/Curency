<?php

if ($_GET['cur']) {
    require_once('curency.php');
    outPutInformation($_GET['cur']);
}
?>
<form method="GET">
    <textarea name="cur"></textarea><br>
    <button type="submit">Отправить</button>
</form>