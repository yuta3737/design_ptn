<?php

// オブジェクトの構造を変更せずに新しい操作を追加するためのデザインパターン

// === 1. Visitorインターフェース ===
// 各要素に対して適用する操作を定義
interface Visitor {
    public function visitBook(Book $book): void;
    public function visitDVD(DVD $dvd): void;
}

// === 2. Visitable（受け入れ可能な要素）インターフェース ===
// 自身をVisitorに受け渡すためのacceptメソッドを定義
interface Visitable {
    public function accept(Visitor $visitor): void;
}

// === 3. 具体的な要素クラス ===
// - 本 (Book)
class Book implements Visitable {
    private string $title;
    private string $author;

    public function __construct(string $title, string $author) {
        $this->title = $title;
        $this->author = $author;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function getAuthor(): string {
        return $this->author;
    }

    public function accept(Visitor $visitor): void {
        $visitor->visitBook($this);
    }
}

// - DVD
class DVD implements Visitable {
    private string $title;
    private int $duration; // 再生時間 (分単位)

    public function __construct(string $title, int $duration) {
        $this->title = $title;
        $this->duration = $duration;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function getDuration(): int {
        return $this->duration;
    }

    public function accept(Visitor $visitor): void {
        $visitor->visitDVD($this);
    }
}

// === 4. 具体的なVisitor ===
// - 情報を表示するVisitor
class InfoVisitor implements Visitor {
    public function visitBook(Book $book): void {
        echo "本のタイトル: '{$book->getTitle()}', 著者: {$book->getAuthor()}\n";
    }

    public function visitDVD(DVD $dvd): void {
        echo "DVDのタイトル: '{$dvd->getTitle()}', 再生時間: {$dvd->getDuration()} 分\n";
    }
}

// - 価格を計算するVisitor
class PriceCalculatorVisitor implements Visitor {
    private float $totalPrice = 0;

    public function visitBook(Book $book): void {
        $this->totalPrice += 1200; // 本の価格: 1200円とする
    }

    public function visitDVD(DVD $dvd): void {
        $this->totalPrice += 1800; // DVDの価格: 1800円とする
    }

    public function getTotalPrice(): float {
        return $this->totalPrice;
    }
}

// === 5. 使用例 ===
$items = [
    new Book("1984", "ジョージ・オーウェル"),
    new DVD("インセプション", 148),
    new Book("アラバマ物語", "ハーパー・リー"),
    new DVD("マトリックス", 136),
];

// 情報を表示
echo "=== 商品情報 ===\n";
$infoVisitor = new InfoVisitor();
foreach ($items as $item) {
    $item->accept($infoVisitor);
}

// 価格を計算
echo "\n=== 合計金額 ===\n";
$priceVisitor = new PriceCalculatorVisitor();
foreach ($items as $item) {
    $item->accept($priceVisitor);
}

echo "合計金額: " . $priceVisitor->getTotalPrice() . "円\n";