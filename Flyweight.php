<?php

// オブジェクトのインスタンス数を減らしてメモリ使用量を最適化するためのデザインパターン
// 同じ状態を持つ複数のオブジェクトを共有し、メモリの節約を目指す

// フライウェイトインターフェース
interface Shape {
    public function draw($x, $y, $radius);
}

// フライウェイトクラス
class Circle implements Shape {
    private $color; // 共有される状態（Intrinsic State）

    public function __construct($color) {
        $this->color = $color;
    }

    public function draw($x, $y, $radius) {
        echo "円を描画: 色={$this->color}, x={$x}, y={$y}, 半径={$radius}" . PHP_EOL;
    }
}

// フライウェイトファクトリー
class ShapeFactory {
    private $circlePool = []; // 共有するオブジェクトを管理するプール

    public function getCircle($color) {
        if (!isset($this->circlePool[$color])) {
            $this->circlePool[$color] = new Circle($color);
            echo "新しい色の円を作成: 色={$color}" . PHP_EOL;
        } else {
            echo "既存の色の円を再利用: 色={$color}" . PHP_EOL;
        }

        return $this->circlePool[$color];
    }
}

// クライアントコード
$colors = ['赤', '青', '緑', '黄色', '黒'];
$factory = new ShapeFactory();

// ランダムに円を作成・描画
for ($i = 0; $i < 10; $i++) {
    $color = $colors[array_rand($colors)];
    $circle = $factory->getCircle($color);
    $x = rand(0, 100);
    $y = rand(0, 100);
    $radius = rand(5, 20);

    $circle->draw($x, $y, $radius);
}