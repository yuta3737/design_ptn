<?php

interface fruitInterface {
    public function getfruitList() :array ;
}


class FruitArray implements fruitInterface 
{
    private $fruitList;

    public function __construct(array $fruitList)
    {
        $this->fruitList = $fruitList;
    }

    public function getFruitList() :array
    {
        return $this->fruitList;
    }

}

class fruitAdapter extends fruitArray {

    private $fruitJson;

    public function __construct(fruitJson $fruitJson)
    {
        $this->fruitJson = $fruitJson;
    }

    public function getFruitList() :array
    {
        $changeArray = json_decode($this->fruitJson->getFruitJson(), true);
        
        if (is_array($changeArray)) {
            return $changeArray;
        } else {
            return [];
        } 
    }

}

class fruitJson
{
    private $fruitJson;

    public function __construct(string $fruitJson)
    {
        $this->fruitJson = $fruitJson;
    }

    public function getFruitJson()
    {
        return $this->fruitJson;
    }

}

// array型の変数を扱うクラスとjson型の変数を扱うクラスがある。
// json型で取得しなければならない場面であり、出力はarray型にする必要があるような場面でadapterパターンが使用される。
$fruitList = ['apple', 'banana', 'hogehoge'];
$fruitJson = json_encode($fruitList);

$fruits = new fruitArray($fruitList);
$fruitJson = new fruitJson($fruitJson);
$fruitAdapter = new fruitAdapter($fruitJson);

foreach ($fruits->getFruitList() as $fruit) {
    echo $fruit."\n";
}

foreach ($fruitAdapter->getFruitList() as $fruit) {
    echo $fruit."2\n";
}