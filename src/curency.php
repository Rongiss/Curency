<?php
function dataApi()
{
    $dataFromApi = file_get_contents('https://www.cbr-xml-daily.ru/daily.xml', true);
    $ObjectXML = simplexml_load_string($dataFromApi);
    return $ObjectXML;
}
function idMoneyInArrFromApi(){
    $aarAllIdMoney = [];
    foreach (dataApi() as $findElem){
        $aarAllIdMoney[] = $findElem->CharCode;
    }
    return $aarAllIdMoney;
}
function outPutInformation($cur) {
    $currencies = explode(',', $cur);
var_dump($currencies);die();
    foreach (dataApi() as $lis) {
        print_r( $lis->CharCode . " "."|"." ");
        print_r( $lis->Name . " "."|"." ");
        print_r("Value: " . $lis->Value . "<br>");
    }
}