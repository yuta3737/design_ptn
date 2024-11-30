<?php

// Memento: 保存する状態を表現
class Memento {
    private string $state;

    public function __construct(string $state) {
        $this->state = $state;
    }

    public function getState(): string {
        return $this->state;
    }
}

// Originator: 元のオブジェクト
class TextEditor {
    private string $text = "";

    public function write(string $newText) {
        $this->text .= $newText;
    }

    public function getText(): string {
        return $this->text;
    }

    public function save(): Memento {
        return new Memento($this->text);
    }

    public function restore(Memento $memento) {
        $this->text = $memento->getState();
    }
}

// Caretaker: Mementoを管理
class Caretaker {
    private array $mementoList = [];

    public function addMemento(Memento $memento) {
        $this->mementoList[] = $memento;
    }

    public function getMemento(int $index): ?Memento {
        return $this->mementoList[$index] ?? null;
    }
}

// デモ
echo "Mementoパターンのデモを開始します。" . PHP_EOL;

$editor = new TextEditor();
$caretaker = new Caretaker();

echo "初期状態: '" . $editor->getText() . "'" . PHP_EOL;

$editor->write("こんにちは、");
echo "文章を書き込み: '" . $editor->getText() . "'" . PHP_EOL;
$caretaker->addMemento($editor->save()); // 状態を保存

$editor->write("世界！\n");
echo "文章を書き込み: '" . $editor->getText() . "'" . PHP_EOL;
$caretaker->addMemento($editor->save()); // 状態を保存

// 元に戻す
echo "最新の状態を取り消します..." . PHP_EOL;
$editor->restore($caretaker->getMemento(0));
echo "元に戻した状態: '" . $editor->getText() . "'" . PHP_EOL;

echo "Mementoパターンのデモを終了します。" . PHP_EOL;

