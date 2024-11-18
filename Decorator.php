<?php

// メリット
// 必要なタイミングで新しい機能を追加できる
// 複数の機能を組み合わせて柔軟な構成が可能。

// Component: 飲み物の基本インターフェース
interface Beverage
{
    public function getDescription(): string;
    public function cost(): float;
}

// ConcreteComponent: シンプルなコーヒー
class SimpleCoffee implements Beverage
{
    public function getDescription(): string
    {
        return "Simple Coffee";
    }

    public function cost(): float
    {
        return 300.0; // コーヒーの基本価格
    }
}

// Decorator: 飲み物を拡張する抽象クラス
abstract class BeverageDecorator implements Beverage
{
    protected Beverage $beverage;

    public function __construct(Beverage $beverage)
    {
        $this->beverage = $beverage;
    }
}

// ConcreteDecorator: ミルクを追加するデコレーター
class MilkDecorator extends BeverageDecorator
{
    public function getDescription(): string
    {
        return $this->beverage->getDescription() . ", Milk";
    }

    public function cost(): float
    {
        return $this->beverage->cost() + 50.0; // ミルクの追加料金
    }
}

// ConcreteDecorator: シロップを追加するデコレーター
class SyrupDecorator extends BeverageDecorator
{
    public function getDescription(): string
    {
        return $this->beverage->getDescription() . ", Syrup";
    }

    public function cost(): float
    {
        return $this->beverage->cost() + 30.0; // シロップの追加料金
    }
}

// ConcreteDecorator: チョコレートを追加するデコレーター
class ChocolateDecorator extends BeverageDecorator
{
    public function getDescription(): string
    {
        return $this->beverage->getDescription() . ", Chocolate";
    }

    public function cost(): float
    {
        return $this->beverage->cost() + 70.0; // チョコレートの追加料金
    }
}

// ---- 動作例 ----
$coffee = new SimpleCoffee();
echo $coffee->getDescription() . " - Cost: ¥" . $coffee->cost() . "\n";

$coffeeWithMilk = new MilkDecorator($coffee);
echo $coffeeWithMilk->getDescription() . " - Cost: ¥" . $coffeeWithMilk->cost() . "\n";

$coffeeWithMilkAndSyrup = new SyrupDecorator($coffeeWithMilk);
echo $coffeeWithMilkAndSyrup->getDescription() . " - Cost: ¥" . $coffeeWithMilkAndSyrup->cost() . "\n";

$fullyLoadedCoffee = new ChocolateDecorator($coffeeWithMilkAndSyrup);
echo $fullyLoadedCoffee->getDescription() . " - Cost: ¥" . $fullyLoadedCoffee->cost() . "\n";

?>