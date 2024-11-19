<?php

// 各ハンドラ（処理）は独立しているため、新しい処理を追加するときは新しいハンドラクラスを作成し、チェーンに追加するだけ
// 処理が責任ごとに分割されるため、個々のハンドラはシンプルで再利用可能

// Handlerインターフェース
// 全てのハンドラはこのインターフェースを実装
interface Handler
{
    public function setNext(Handler $handler): Handler;
    public function handle(string $request): ?string;
}

// 基本的なHandlerクラス
// ハンドラー同士を動的に連結する仕組み
abstract class AbstractHandler implements Handler
{
    private ?Handler $nextHandler = null;

    public function setNext(Handler $handler): Handler
    {
        $this->nextHandler = $handler;
        return $handler;
    }

    public function handle(string $request): ?string
    {
        if ($this->nextHandler) {
            return $this->nextHandler->handle($request);
        }

        return null;
    }
}

// ログハンドラ
class LogHandler extends AbstractHandler
{
    public function handle(string $request): ?string
    {
        echo "ログハンドラ: リクエストを記録しました: $request\n";

        return parent::handle($request);
    }
}

// 認証ハンドラ
class AuthHandler extends AbstractHandler
{
    private array $validTokens = ["token123", "secure456"];

    public function handle(string $request): ?string
    {
        if (!in_array($request, $this->validTokens)) {
            return "認証ハンドラ: 認証に失敗しました: $request";
        }

        echo "認証ハンドラ: 認証に成功しました: $request\n";

        return parent::handle($request);
    }
}

// データ処理ハンドラ
class DataHandler extends AbstractHandler
{
    public function handle(string $request): ?string
    {
        echo "データ処理ハンドラ: データを処理中です: $request\n";
        return "データ処理ハンドラ: リクエストを正常に処理しました: $request";
    }
}

// チェーンのセットアップ
$logHandler = new LogHandler();
$authHandler = new AuthHandler();
$dataHandler = new DataHandler();

$logHandler->setNext($authHandler)->setNext($dataHandler);

// リクエスト処理
function processRequest(string $request)
{
    global $logHandler;

    echo "リクエストの処理を開始します: $request\n";
    $result = $logHandler->handle($request);

    if ($result) {
        echo $result . "\n";
    } else {
        echo "リクエストは処理されませんでした。\n";
    }
}

processRequest("token123");  // 成功するリクエスト
processRequest("invalid");   // 失敗するリクエスト