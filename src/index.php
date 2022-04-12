<?php

interface ResourceInterface {
    public function getData();
}



abstract class Resource implements ResourceInterface
{
    protected $searched_values = [];
    protected $url;
    protected $data;
    protected $find_all = true;
    protected $found = [];
    protected $not_found = [];

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function getData()
    {
        return $this->data;
    }

    public function find($searched_values) {
        if($searched_values) {
            $this->find_all = false;
        }
        $this->searched_values = array_merge($this->searched_values,$searched_values);
    }
}


class CBR extends Resource
{
    public function getData()
    {
        $this->data = simplexml_load_string(file_get_contents($this->url));
        return $this->parseData();
    }


    public function printNotFound() {
        foreach ($this->not_found as $value) {
            echo 'Не найдено: '. $value.PHP_EOL;
        }
    }

    public function printFound() {
        foreach ($this->found as $value) {
            echo $value.PHP_EOL;
        }
    }

    private function parseData() {
        $arr = [];
        $found = [];
        if($this->find_all) {
            foreach ($this->data as $data) {
                $arr[] = new Data($data->Name,$data->CharCode,$data->Value);
            }
        } else {
            foreach ($this->data as $data) {
                if(in_array($data->CharCode,$this->searched_values)) {
                    $arr[] = new Data($data->Name,$data->CharCode,$data->Value);
                    $found[] = $data->CharCode;
                }
            }
        }

        $this->not_found = array_diff($this->searched_values,$found);
        $this->found = $arr;
        return $arr;
    }

    public function getCountFind() {
        return count($this->found);
    }

    public function getCountNotFound() {
        return count($this->not_found);
    }

    public function getCountAll() {
        return count($this->searched_values);
    }

    public function printStatistics() {
        return 'Всего: '.$this->getCountAll() . ' Найдено: '.$this->getCountFind().' Не найдено: '.$this->getCountNotFound().PHP_EOL;
    }
}

class Coingecko extends Resource
{
    public function getData()
    {
        return $this->parseData(json_decode(file_get_contents($this->url)));
    }

    public function parseData($data) {
        $arr = [];
        foreach ($data as $dat) {
            if(in_array($dat->symbol,$this->searched_values)) {
                $arr[] = new Data($dat->name,$dat->symbol,0);
               // $found[] = $dat->CharCode;
            }
        }
        return $arr;
    }

    public function setMethod($method) {
        $this->url.=$method;
    }
}




class Data
{
    protected $name;
    protected $code;
    protected $value;

    public function __construct($name,$code,$value)
    {
        $this->name = $name;
        $this->code = $code;
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->name.' ('.$this->code.') '. $this->value;
    }
}




/*$cbr = new CBR('https://www.cbr-xml-daily.ru/daily.xml');
$cbr->find(['AUD']);
$cbr->find(['KZT','JOPA']);
$cbr->getData();

//echo $cbr->printFound();
//echo $cbr->printNotFound();
//echo $cbr->printStatistics();



$crypto = new Coingecko('https://api.coingecko.com/api/v3/');
$crypto->setMethod('/coins/list');
$crypto->find(['doge','btc']);


$crypto_data = $crypto->getData();
print_r($crypto_data);
*/



