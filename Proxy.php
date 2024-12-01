<?php

// サービスインターフェース
interface DocumentInterface {
    public function displayContent(): void;
}

// 実際の重いオブジェクト
class RealDocument implements DocumentInterface {
    private string $content;

    public function __construct(string $filename) {
        echo "実際のドキュメントをロードしています: {$filename}\n";
        $this->content = "ファイル「{$filename}」の内容";
    }

    public function displayContent(): void {
        echo "ドキュメントの内容を表示します: {$this->content}\n";
    }
}

// Proxyクラス
class DocumentProxy implements DocumentInterface {
    private ?RealDocument $realDocument = null;
    private string $filename;

    public function __construct(string $filename) {
        $this->filename = $filename;
    }

    public function displayContent(): void {
        if ($this->realDocument === null) {
            $this->realDocument = new RealDocument($this->filename);
        }
        $this->realDocument->displayContent();
    }
}

// クライアントコード
function clientCode(DocumentInterface $document) {
    echo "クライアント: ドキュメントの内容を表示しようとしています...\n";
    $document->displayContent();
    echo "クライアント: ドキュメントの内容を再表示します...\n";
    $document->displayContent();
}

// 使用例
echo "Proxyパターンのデモ\n";
// DocumentInterfaceに依存、RealDocumentかDocumentProxyのどちらが渡されても良い
$document = new DocumentProxy("example.txt");
clientCode($document);