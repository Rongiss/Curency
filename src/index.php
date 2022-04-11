<?php
$data = file_get_contents('https://www.cbr-xml-daily.ru/daily.xml', true);
$xmlObject = simplexml_load_string($data);

$find = ['AUD','AZN','KZT','JOPA'];
$not_found=[];
foreach ($find as $find_one){
    $total = 0;
    foreach ($xmlObject as $lis) {

        if ($find_one == $lis->CharCode) {
            $total += 1;
            print_r("Valute: " . $lis->Name . ' ');
            print_r("ID: " . $lis->CharCode . " ");
            print_r("Value: " . $lis->Value . "<br>");
        }
    }
    if ($total == 0){
        $not_found[] = $find_one;
    }

}
$results = array_unique($not_found);
foreach ($results as $result){
    print_r("Элемент ".$result." не найден"."<br>");
}

?>