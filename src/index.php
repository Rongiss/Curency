<?php


abstract class Resource implements ResourceInterface
{
    protected $searched_values = [];
    public function getData()
    {

    }
}


class CBR extends Resource
{
    protected $url;
    protected $data;
    protected $found = [];
    protected $not_found = [];
    protected $find_all = true;

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function getData()
    {
        $this->data = simplexml_load_string(file_get_contents($this->url));
        return $this->parseData();
    }

    public function find($searched_values) {
        if($searched_values) {
            $this->find_all = false;
        }
        $this->searched_values = array_merge($this->searched_values,$searched_values);
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


interface ResourceInterface {
    public function getData();
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


$cbr = new CBR('https://www.cbr-xml-daily.ru/daily.xml');
$cbr->find(['AUD']);
$cbr->find(['KZT','JOPA']);
$cbr->getData();

echo $cbr->printFound();
echo $cbr->printNotFound();
echo $cbr->printStatistics();

