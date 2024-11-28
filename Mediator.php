<?php

// Mediatorインターフェース
interface MediatorInterface {
    public function sendMessage(string $message, Colleague $sender): void;
}

// Colleagueの抽象クラス
abstract class Colleague {
    protected MediatorInterface $mediator;

    public function __construct(MediatorInterface $mediator) {
        $this->mediator = $mediator;
    }

    // 抽象メソッドを追加
    abstract public function getName(): string;
}

// 具体的なColleagueクラス: User
class User extends Colleague {
    private string $name;

    public function __construct(MediatorInterface $mediator, string $name) {
        parent::__construct($mediator);
        $this->name = $name;
    }

    public function send(string $message): void {
        echo "{$this->name}：「{$message}」を送信しました。\n";
        $this->mediator->sendMessage($message, $this);
    }

    public function receive(string $message, string $senderName): void {
        echo "{$this->name}：{$senderName}から「{$message}」を受け取りました。\n";
    }

    public function getName(): string {
        return $this->name;
    }
}

// Mediatorの具体クラス
class ChatRoomMediator implements MediatorInterface {
    private array $users = [];

    public function addUser(User $user): void {
        $this->users[] = $user;
    }

    public function sendMessage(string $message, Colleague $sender): void {
        foreach ($this->users as $user) {
            if ($user !== $sender) {
                $user->receive($message, $sender->getName());
            }
        }
    }
}

// クライアントコード
$mediator = new ChatRoomMediator();

$user1 = new User($mediator, "アリス");
$user2 = new User($mediator, "ボブ");
$user3 = new User($mediator, "チャーリー");

$mediator->addUser($user1);
$mediator->addUser($user2);
$mediator->addUser($user3);

$user1->send("みなさん、こんにちは！");
$user2->send("やあ、アリス！");
$user3->send("こんにちは！");