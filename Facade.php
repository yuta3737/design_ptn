<?php

// サブシステム1: 曲データの取得
class MusicProvider
{
    public function fetchMusic($id)
    {
        echo "曲データを取得しています...(ID: $id)\n";
        return "曲データ(ID: $id)";
    }
}

// サブシステム2: 音楽データのデコード
class MusicDecoder
{
    public function decode($musicData)
    {
        echo "音楽データをデコードしています: $musicData\n";
        return "デコード済み音楽: $musicData";
    }
}

// サブシステム3: 音楽の再生
class MusicPlayer
{
    public function play($decodedMusic)
    {
        echo "音楽を再生しています: $decodedMusic\n";
        return "再生完了: $decodedMusic";
    }
}

// Facadeクラス: サブシステムの処理をまとめる
class MusicFacade
{
    private $provider;
    private $decoder;
    private $player;

    public function __construct()
    {
        $this->provider = new MusicProvider();
        $this->decoder = new MusicDecoder();
        $this->player = new MusicPlayer();
    }

    public function playMusic($musicId)
    {
        echo "音楽再生プロセスを開始します...\n";

        // 曲データを取得
        $musicData = $this->provider->fetchMusic($musicId);

        // 音楽データをデコード
        $decodedMusic = $this->decoder->decode($musicData);

        // 音楽を再生
        $result = $this->player->play($decodedMusic);

        echo "音楽再生プロセスが完了しました。\n";
        return $result;
    }
}

// クライアントコード
$musicFacade = new MusicFacade();
echo $musicFacade->playMusic(101); // 結果: 再生完了: デコード済み音楽: 曲データ(ID: 101)