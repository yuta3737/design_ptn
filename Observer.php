<?php

// 被観測対象（Subject）
class Subject {
    private $observers = []; // Observerのリスト
    private $state;         // 被観測対象の状態

    // Observerを登録する
    public function attach(Observer $observer) {
        $this->observers[] = $observer;
    }

    // Observerを解除する
    public function detach(Observer $observer) {
        $this->observers = array_filter($this->observers, function ($obs) use ($observer) {
            return $obs !== $observer;
        });
    }

    // Observerたちに通知を送る
    public function notify() {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }

    // 状態を設定し、変更を通知
    public function setState($state) {
        $this->state = $state;
        $this->notify(); // 状態変更をObserverに通知
    }

    // 状態を取得
    public function getState() {
        return $this->state;
    }
}

// Observerインターフェース
interface Observer {
    public function update(Subject $subject);
}

// 具体的なObserver
class ConcreteObserver implements Observer {
    private $name;

    public function __construct($name) {
        $this->name = $name;
    }

    public function update(Subject $subject) {
        echo "観測者 '{$this->name}' に通知されました。新しい状態: " . $subject->getState() . PHP_EOL;
    }
}

// Subjectを作成
$subject = new Subject();

// Observerを作成
$observer1 = new ConcreteObserver("ユーザー1");
$observer2 = new ConcreteObserver("ユーザー2");

// ObserverをSubjectに登録
$subject->attach($observer1);
$subject->attach($observer2);

// 状態を変更し、Observerに通知
$subject->setState("状態1");
$subject->setState("状態2");

// Observerを1つ解除
$subject->detach($observer1);

// 再度状態を変更し、通知
$subject->setState("状態3");

//subject とobserverがお互い詳細な実装を知ることなく処理を行うことができる