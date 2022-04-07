<?php
$myKey = 'ac9924cf8642f15466ae058f332d6698';

$info = file_get_contents('https://www.cbr-xml-daily.ru/daily.xml', true);

$xmlObject = simplexml_load_string($info);
$out = ['AUD','AZN','KZT','JOPA'];
$elNotFound=[];
foreach ($out as $j){
    foreach ($xmlObject as $lis) {
        if ($j == $lis->CharCode) {

            print_r("Valute: " . $lis->Name . ' ');
            print_r("ID: " . $lis->CharCode . " ");
            print_r("Value: " . $lis->Value . "<br>");
        } else {
            $elNotFound[] = $j;
        }
    }

}
$result = array_unique($elNotFound);
print_r($result);


foreach ($result as $iit){
    print_r("Элемент ".$iit." не найден"."<br>");
}

?>

