<?php

// Component インターフェース
// 共通のインターフェースによりフォルダとファイルを 一貫した方法 で操作できる
interface FileSystemComponent
{
    public function show(int $depth = 0): string;
}

// Leaf クラス (ファイル)
class File implements FileSystemComponent
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function show(int $depth = 0): string
    {
        return str_repeat("  ", $depth) . "- " . $this->name . "\n";
    }
}

// Composite クラス (フォルダ)
class Folder implements FileSystemComponent
{
    private string $name;
    private array $children = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function add(FileSystemComponent $component): void
    {
        $this->children[] = $component;
    }

    // ツリー構造を再帰的に処理できる。子要素が何であるか（フォルダかファイルか）を気にせずに処理できる
    public function show(int $depth = 0): string
    {
        $output = str_repeat("  ", $depth) . "+ " . $this->name . "\n";
        foreach ($this->children as $child) {
            $output .= $child->show($depth + 1);
        }
        return $output;
    }
}

// 使用例
// ファイル作成
$file1 = new File("file1.txt");
$file2 = new File("file2.txt");
$file3 = new File("file3.txt");

// フォルダ作成
$rootFolder = new Folder("root");
$subFolder1 = new Folder("subdir1");
$subFolder2 = new Folder("subdir2");

// フォルダにファイルやサブフォルダを追加
$subFolder1->add($file1);
$subFolder1->add($file2);

$subFolder2->add($file3);

$rootFolder->add($subFolder1);
$rootFolder->add($subFolder2);

// 階層構造を表示
echo $rootFolder->show();

// フォルダとファイルを区別せずに操作できる