<?php

//Функция преобразования url в обьект
//возвращает объект для обработки
function url_to_obj()
{
    $data = file_get_contents('https://www.cbr-xml-daily.ru/daily.xml', true);
    $xmlObject = simplexml_load_string($data);
    return $xmlObject;
}

//Функция возвращающая элементы для поиска в api
function elem_for_search()
{
   return $find = ['AUD', 'AZN', 'KZT', 'JOPAaa', 'Rom'];
}

//функция поиска элементов
//вывод найденных элементов
//возвращает не найденные
function serch()
{
//пустой массив для заполнения не найденными элементами
    $not_found = [];

    foreach (elem_for_search() as $find_one) {
        $total = 0;
        foreach (url_to_obj() as $lis) {
            if ($find_one == $lis->CharCode) {
                $total += 1;
                print_r("Valute: " . $lis->Name . ' ');
                print_r("ID: " . $lis->CharCode . " ");
                print_r("Value: " . $lis->Value . "<br>");
            }
        }
        if ($total == 0) {
            $not_found[] = $find_one;
        }
    }

 return $results = array_unique($not_found);
}


foreach (serch() as $result){
    print_r("Элемент ".$result." не найден"."<br>");
}
?>