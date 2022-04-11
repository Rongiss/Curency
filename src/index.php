<?php

/*class Parser
{
    protected $not_found;
    protected $count;
    protected $resource_objects = [];
    protected $searched_values = [];

    public function addToFind($find) {
        if(is_array($find)) {
            $this->searched_values = array_merge($this->searched_values, $find);
        } else {
            $this->searched_values[] = $find;
        }

    }

    public function addResource(ResourceInterface $resource_object) {
        $this->resource_objects[] = $resource_object;
    }




    public function getCommonCount() {

    }

    public function getNotFoundCount() {
        $count = 0;
        foreach ($this->resource_objects as $resource) {
            $count+= $resource->getNotFoundCount();
        }
        return $count;
    }


    public function find() {
        $data = [];
        foreach ($this->resource_objects as $resource) {
            $data = array_merge($data, $resource->getData());
        }
        return $data;
    }
}
*/
abstract class Resource implements ResourceInterface
{
    protected $searched_values = [];
    public function getData()
    {

    }


    /*public function getNotFoundCount()
    {

    }

    public function getCommonCount()
    {
        return count($this->searched_values);
    }*/
}


class CBR extends Resource
{
    protected $url;
    protected $data;
    protected $found = [];
    protected $not_found = [];

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
        foreach ($this->data as $data) {
            if(in_array($data->CharCode,$this->searched_values)) {
                $arr[] = new Data($data->Name,$data->CharCode,$data->Value);
                $found[] = $data->CharCode;
            }
        }
        $this->not_found = array_diff($this->searched_values,$found);
        $this->found = $arr;
        return $arr;
    }
}


interface ResourceInterface {
    public function getData();
    //public function getCommonCount();
    //public function getNotFoundCount();
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


//$parser = new Parser();

$cbr = new CBR('https://www.cbr-xml-daily.ru/daily.xml');
$cbr->find(['AUD','KZT','JOPA']);
$cbr->getData();

echo $cbr->printFound();
echo $cbr->printNotFound();




;














?>