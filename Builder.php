<?php

// 1. Product
// 最終的に生成される
class Burger
{
    public $bun;
    public $patty;
    public $cheese;
    public $vegetables;
    public $sauce;

    public function show()
    {
        echo "このバーガーの内容:\n";
        echo "- バンズ: " . $this->bun . "\n";
        echo "- パティ: " . $this->patty . "\n";
        echo "- チーズ: " . ($this->cheese ? $this->cheese : "なし") . "\n";
        echo "- 野菜: " . ($this->vegetables ? implode(', ', $this->vegetables) : "なし") . "\n";
        echo "- ソース: " . ($this->sauce ? $this->sauce : "なし") . "\n";
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

// 3. Concrete Builder
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
// ここでどんなバーガーを作るかを決める。でも、実際に作るのはConcrete Builder
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
            ->setBun("全粒粉バンズ")
            ->setPatty("野菜パティ")
            ->addVegetables(["レタス", "トマト", "キュウリ"])
            ->addSauce("ケチャップ");
        return $this->builder->getBurger();
    }

    public function makeCheeseBurger()
    {
        $this->builder
            ->setBun("ゴマ付きバンズ")
            ->setPatty("ビーフ")
            ->addCheese("チェダー")
            ->addVegetables(["レタス", "ピクルス"])
            ->addSauce("マヨネーズ");
        return $this->builder->getBurger();
    }
}

// 5. 実行コード
// 手動でビルダーを使う
$builder = new CustomBurgerBuilder();
$burger = $builder
    ->setBun("ゴマ付きバンズ")
    ->setPatty("チキン")
    ->addCheese("スイス")
    ->addVegetables(["レタス", "トマト"])
    ->addSauce("BBQソース")
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

// directorクラスにはConcreteBuilderクラスのインスタンスが渡される。
// ここでdirector側から見てBuilderがどんなクラスでどんなインスタンスなのか知らなくても良いという点がデザインパターンにおいて重要。