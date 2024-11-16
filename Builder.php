<?php

// 1. 商品クラス (Product)
class Burger
{
    public $bun;
    public $patty;
    public $cheese;
    public $vegetables;
    public $sauce;

    public function show()
    {
        echo "Burger with:\n";
        echo "- Bun: " . $this->bun . "\n";
        echo "- Patty: " . $this->patty . "\n";
        echo "- Cheese: " . ($this->cheese ? $this->cheese : "None") . "\n";
        echo "- Vegetables: " . ($this->vegetables ? implode(', ', $this->vegetables) : "None") . "\n";
        echo "- Sauce: " . ($this->sauce ? $this->sauce : "None") . "\n";
    }
}

// 2. Builderインターフェース
interface BurgerBuilder
{
    public function setBun($type);
    public function setPatty($type);
    public function addCheese($type);
    public function addVegetables(array $vegetables);
    public function addSauce($type);
    public function getBurger();
}

// 3. Concrete Builder (具体的な構築者)
class CustomBurgerBuilder implements BurgerBuilder
{
    private $burger;

    public function __construct()
    {
        $this->burger = new Burger();
    }

    public function setBun($type)
    {
        $this->burger->bun = $type;
        return $this;
    }

    public function setPatty($type)
    {
        $this->burger->patty = $type;
        return $this;
    }

    public function addCheese($type)
    {
        $this->burger->cheese = $type;
        return $this;
    }

    public function addVegetables(array $vegetables)
    {
        $this->burger->vegetables = $vegetables;
        return $this;
    }

    public function addSauce($type)
    {
        $this->burger->sauce = $type;
        return $this;
    }

    public function getBurger()
    {
        return $this->burger;
    }
}

// 4. Directorクラス (オプション)
class BurgerDirector
{
    private $builder;

    public function __construct(BurgerBuilder $builder)
    {
        $this->builder = $builder;
    }

    public function makeVeggieBurger()
    {
        $this->builder
            ->setBun("Whole Grain")
            ->setPatty("Veggie")
            ->addVegetables(["Lettuce", "Tomato", "Cucumber"])
            ->addSauce("Ketchup");
        return $this->builder->getBurger();
    }

    public function makeCheeseBurger()
    {
        $this->builder
            ->setBun("Sesame")
            ->setPatty("Beef")
            ->addCheese("Cheddar")
            ->addVegetables(["Lettuce", "Pickles"])
            ->addSauce("Mayonnaise");
        return $this->builder->getBurger();
    }
}

// 5. 実行コード
// 手動でビルダーを使う
$builder = new CustomBurgerBuilder();
$burger = $builder
    ->setBun("Sesame")
    ->setPatty("Chicken")
    ->addCheese("Swiss")
    ->addVegetables(["Lettuce", "Tomato"])
    ->addSauce("BBQ")
    ->getBurger();
$burger->show();

echo "\n";

// Directorを使う
$director = new BurgerDirector(new CustomBurgerBuilder());
$veggieBurger = $director->makeVeggieBurger();
$veggieBurger->show();

echo "\n";

$cheeseBurger = $director->makeCheeseBurger();
$cheeseBurger->show();