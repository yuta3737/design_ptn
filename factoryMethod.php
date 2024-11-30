<?php

// 製品のインターフェース
interface Product {
    public function operation(): string;
}

// 具体的な製品A
class ConcreteProductA implements Product {
    public function operation(): string {
        return "具体的製品Aの動作";
    }
}

// 具体的な製品B
class ConcreteProductB implements Product {
    public function operation(): string {
        return "具体的製品Bの動作";
    }
}

// クリエイターの抽象クラス
abstract class Creator {
    // Factory Method
    abstract public function factoryMethod(): Product;

    // クライアントが利用する処理
    public function someOperation(): string {
        // 製品のインスタンスを取得して使用
        $product = $this->factoryMethod();
        return "クリエイター: " . $product->operation();
    }
}

// 具体的なクリエイターA
class ConcreteCreatorA extends Creator {
    public function factoryMethod(): Product {
        return new ConcreteProductA();
    }
}

// 具体的なクリエイターB
class ConcreteCreatorB extends Creator {
    public function factoryMethod(): Product {
        return new ConcreteProductB();
    }
}

// クライアントコード
function clientCode(Creator $creator) {
    echo "クライアント: どのクリエイターかは気にしません。\n";
    echo $creator->someOperation() . "\n";
}

// 実行例
echo "アプリケーション: ConcreteCreatorAで動作します:\n";
clientCode(new ConcreteCreatorA());

echo "\n";

echo "アプリケーション: ConcreteCreatorBで動作します:\n";
clientCode(new ConcreteCreatorB());