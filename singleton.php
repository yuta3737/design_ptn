<?php

// グローバル変数をより厳密に管理する必要がある場合は、 Singleton パターンを使用

// 動作を軽くする等のためにインスタンスを再利用したい場合。
// 特定のリソースやサービスに対応する1つのインスタンスを共有してアクセスしたい場合

class Singleton {
    private static $instance = null;

    private function __construct() {}

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Singleton();
            var_dump('ここを通りました。');
        }

        var_dump('return前');
        return self::$instance;
    }

    // cloneとwakeupなどのPHPのマジックメソッドを使うことで、「インスタンスは1つ」という原則を破ることが可能なのでprivateで定義
    private function __clone() {}

    // privateにしたかったがエラーが出たのでpublicに変更
    // wakeupメソッドはオブジェクトをデシリアライズする際（unserialize() 関数を使用するとき）に自動的に実行されるマジックメソッド
    public function __wakeup() {
        // 呼び出されたらエラーを出す。
        throw new \Exception("Cannot unserialize a singleton.");
    }
}

$instance1 = Singleton::getInstance();
$instance2 = Singleton::getInstance();

var_dump($instance1 === $instance2);  // bool(true)