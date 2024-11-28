<?php

// 状態インターフェース
interface DoorState {
    public function open(DoorContext $context);
    public function close(DoorContext $context);
}

// 閉じている状態
class ClosedState implements DoorState {
    public function open(DoorContext $context) {
        echo "ドアを開けます。\n";
        $context->setState(new OpenState());
    }

    public function close(DoorContext $context) {
        echo "ドアはすでに閉じています。\n";
    }
}

// 開いている状態
class OpenState implements DoorState {
    public function open(DoorContext $context) {
        echo "ドアはすでに開いています。\n";
    }

    public function close(DoorContext $context) {
        echo "ドアを閉めます。\n";
        $context->setState(new ClosedState());
    }
}

// コンテキストクラス
class DoorContext {
    private DoorState $state;

    public function __construct() {
        // 初期状態を「閉じている」に設定
        $this->state = new ClosedState();
    }

    public function setState(DoorState $state) {
        $this->state = $state;
    }

    public function open() {
        $this->state->open($this);
    }

    public function close() {
        $this->state->close($this);
    }
}

// 使用例
$door = new DoorContext();

echo "=== 状態: ドアを開けよう ===\n";
$door->open(); // ドアを開けます。

echo "=== 状態: もう一度ドアを開けよう ===\n";
$door->open(); // ドアはすでに開いています。

echo "=== 状態: ドアを閉めよう ===\n";
$door->close(); // ドアを閉めます。

echo "=== 状態: もう一度ドアを閉めよう ===\n";
$door->close(); // ドアはすでに閉じています。