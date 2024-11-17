<?php

// ===== インターフェース部分 =====
// 椅子のインターフェース
interface Chair {
    public function sitOn(): string; // 座る動作を表現する
}

// テーブルのインターフェース
interface Table {
    public function placeItems(): string; // テーブルに物を置く動作を表現する
}

// 工場のインターフェース
interface FurnitureFactory {
    public function createChair(): Chair; // 椅子を作成する
    public function createTable(): Table; // テーブルを作成する
}

// ===== 具体的な製品クラス =====
// 和風椅子
class JapaneseChair implements Chair {
    public function sitOn(): string {
        return "和風の椅子";
    }
}

// 和風テーブル
class JapaneseTable implements Table {
    public function placeItems(): string {
        return "和風のテーブル";
    }
}

// 洋風椅子
class WesternChair implements Chair {
    public function sitOn(): string {
        return "洋風の椅子";
    }
}

// 洋風テーブル
class WesternTable implements Table {
    public function placeItems(): string {
        return "洋風のテーブル";
    }
}

// ===== 具体的な工場クラス =====
// 和風家具工場
class JapaneseFurnitureFactory implements FurnitureFactory {
    public function createChair(): Chair {
        return new JapaneseChair();
    }
    public function createTable(): Table {
        return new JapaneseTable();
    }
}

// 洋風家具工場
class WesternFurnitureFactory implements FurnitureFactory {
    public function createChair(): Chair {
        return new WesternChair();
    }
    public function createTable(): Table {
        return new WesternTable();
    }
}

// ===== クライアントコード =====
// どの工場を使うかを選び、それを使って製品を生成。
// どの工場を渡すかによって、結果的に生成される家具が変わる。
// この部分では、具体的な製品の詳細は一切知る必要がない。
function showcaseFurniture(FurnitureFactory $factory) {
    $chair = $factory->createChair();
    $table = $factory->createTable();

    echo $chair->sitOn() . PHP_EOL;
    echo $table->placeItems() . PHP_EOL;
}

// 和風家具を展示
$japaneseFactory = new JapaneseFurnitureFactory();
echo "和風家具:" . PHP_EOL;
showcaseFurniture($japaneseFactory);

// 洋風家具を展示
$westernFactory = new WesternFurnitureFactory();
echo PHP_EOL . "洋風家具:" . PHP_EOL;
showcaseFurniture($westernFactory);

// メリット
// 新しい種類の家具の追加が容易にできる
// コードの保守性も上がる。
// 例）和風の椅子のデザインを変えたいときJapaneseChairクラスを変更するだけですむ
