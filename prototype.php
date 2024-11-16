<?php

// 有効な場面
// 初期化コストの節約をしたい場合
// システム内で多数のインスタンスが共通の状態を共有する場合
// オブジェクトの種類に応じて動的に新しいオブジェクトを生成する必要がある場合


// 一番わかりやすかったのがゲームキャラクター複製の例

// 同じモンスターを複数出現させたい場合、何回もnew　MetalSlime()するのは処理が重ければ重いほど負担がかかる
// メタルスライムのクラス
class MetalSlime {
    public $hp;
    public $attackPower;
    public $defensePower = 255;
    public $speed = 255;

    public function __construct($hp, $attackPower) {
        $this->hp = $hp;
        $this->attackPower = $attackPower;
    }
    
    public function __clone() {
        // ここで特別な複製処理が必要なら追加
    }
}

// メタルスライム生成
$metalSlime = new MetalSlime(10, 20);
$hagureMetal = clone $metalSlime;
$metalKing = clone $metalSlime;

// はぐれメタル
// 複製後にカラムを上書きしたほうが処理が軽い場合に使える?
$hagureMetal->hp = 15;

// メタルキング
$metalKing->hp = 30;
$metalKing->attackPower = 100;


echo $hagureMetal->hp . "\n"; 
echo $hagureMetal->attackPower . "\n"; 
echo $hagureMetal->defensePower . "\n"; 
echo $hagureMetal->speed . "\n";

echo $metalKing->hp . "\n";
echo $metalKing->attackPower . "\n"; 
echo $metalKing->defensePower . "\n";
echo $metalKing->speed . "\n";      

// cloneは単なるコピーする手段。そのcloneをうまく使用した設計思想がPrototypeパターンである。
// 使ったことがある人があまりいなそう。。