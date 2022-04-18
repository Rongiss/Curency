<?php
$find_currencies = null;
if(isset($_GET['currencies'])) {
    $find_currencies = $_GET['currencies'];
    $find_currencies = explode(',',$find_currencies);
}
print_r($find_currencies);

//Функция преобразования url в обьект
//возвращает объект для обработки
function urlToObject()
{
    $data = file_get_contents('https://www.cbr-xml-daily.ru/daily.xml', true);
    $xmlObject = simplexml_load_string($data);
    return $xmlObject;
}

//Функция возвращающая элементы для поиска в api
function elemForSearch()
{
    $find = ["AUD","AZN","GBP","AMD","BYN","BGN","BRL","HUF","HKD",
       "DKK","USD","EUR","INR","KZT","CAD","KGS","CNY","MDL",
       "NOK","PLN","RON","XDR","SGD","TJS","TRY","TMT","UZS",
       "UAH","CZK","SEK","CHF","ZAR","KRW","JPY"];
    #return $find = ['AUD', 'AZN', 'KZT', 'JOPAaa', 'Rom'];

    return $find;
}

//функция поиска элементов
//вывод найденных элементов
//возвращает не найденные
function serchElement()
{
//пустой массив для заполнения не найденными элементами
    $not_found = [];
    foreach (elemForSearch() as $find_one) {
        $total = 0;
        foreach (urlToObject() as $lis) {
            if ($find_one == $lis->CharCode) {
                $total += 1;
                print_r( $lis->CharCode . " "."|"." ");
                print_r( $lis->Name . " "."|"." ");

                print_r("Value: " . $lis->Value . "<br>");
            }
        }
        if ($total == 0) {
            $not_found[] = $find_one;
        }
    }

 return $results = array_unique($not_found);
}


foreach (serchElement() as $result){
    print_r("Элемент ".$result." не найден"."<br>");
}

/*function allNamesManoy()
{
    foreach (urlToObject() as $lis) {
        print_r('"'.$lis->CharCode.'"'.',' );
        #print_r("Value: " . $lis->Value . "<br>");
    }
}
allNamesManoy()*/



?>
<form>
    <input type="text" name="currencies">
    <button type="submit">ok</button>
</form>

