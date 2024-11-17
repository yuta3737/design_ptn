<?php

// Component インターフェース
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

// Composite クラス (ディレクトリ)
class Directory implements FileSystemComponent
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

// ディレクトリ作成
$rootDir = new Directory("root");
$subDir1 = new Directory("subdir1");
$subDir2 = new Directory("subdir2");

// ディレクトリにファイルやサブディレクトリを追加
$subDir1->add($file1);
$subDir1->add($file2);

$subDir2->add($file3);

$rootDir->add($subDir1);
$rootDir->add($subDir2);

// 階層構造を表示
echo $rootDir->show();