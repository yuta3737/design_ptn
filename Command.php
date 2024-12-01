<?php

// コマンドインターフェース
interface Command
{
    public function execute(): void; // コマンド実行
    public function undo(): void;    // コマンド取り消し
}

// 受信者 (実際に操作を行うクラス)
class Light
{
    public function on()
    {
        echo "ライトをオンにしました。\n";
    }

    public function off()
    {
        echo "ライトをオフにしました。\n";
    }
}

// コマンド実装 (ライトをオンにするコマンド)
class LightOnCommand implements Command
{
    private $light;

    public function __construct(Light $light)
    {
        $this->light = $light;
    }

    public function execute(): void
    {
        $this->light->on();
    }

    public function undo(): void
    {
        $this->light->off();
    }
}

// コマンド実装 (ライトをオフにするコマンド)
class LightOffCommand implements Command
{
    private $light;

    public function __construct(Light $light)
    {
        $this->light = $light;
    }

    public function execute(): void
    {
        $this->light->off();
    }

    public function undo(): void
    {
        $this->light->on();
    }
}

// コマンドの実行を管理するInvoker
class RemoteControl
{
    private $command;

    public function setCommand(Command $command)
    {
        $this->command = $command;
    }

    public function pressButton(): void
    {
        $this->command->execute();
    }

    public function pressUndo(): void
    {
        $this->command->undo();
    }
}

// 使用例
$light = new Light();

$lightOnCommand = new LightOnCommand($light);
$lightOffCommand = new LightOffCommand($light);

$remote = new RemoteControl();

// ライトをオンにする
$remote->setCommand($lightOnCommand);
$remote->pressButton(); // 出力: ライトをオンにしました。

// ライトをオフにする
$remote->setCommand($lightOffCommand);
$remote->pressButton(); // 出力: ライトをオフにしました。

// 前の操作を取り消す
$remote->pressUndo(); // 出力: ライトをオンにしました。
?>