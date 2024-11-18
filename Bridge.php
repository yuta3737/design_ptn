<?php

// 色のインターフェース
interface Color
{
    public function applyColor(): string;
}

// 具体的な色クラス
class RedColor implements Color
{
    public function applyColor(): string
    {
        return "Red";
    }
}

class BlueColor implements Color
{
    public function applyColor(): string
    {
        return "Blue";
    }
}

// 抽象クラス（形状）
abstract class Shape
{
    protected Color $color;

    // 色を設定できる柔軟性がある。
    public function __construct(Color $color)
    {
        $this->color = $color;
    }

    abstract public function draw(): string;
}

// 具体的な形状クラス
class Circle extends Shape
{
    public function draw(): string
    {
        return "Circle filled with " . $this->color->applyColor();
    }
}

class Rectangle extends Shape
{
    public function draw(): string
    {
        return "Rectangle filled with " . $this->color->applyColor();
    }
}

// 実行例
$red = new RedColor();
$blue = new BlueColor();

$circle = new Circle($red);
echo $circle->draw() . PHP_EOL; 

$rectangle = new Rectangle($blue);
echo $rectangle->draw() . PHP_EOL; 