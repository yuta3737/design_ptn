<?php

abstract class SocialNetwork
{
    protected $username;
    protected $password;

    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function post(): bool
    {
        if ($this->logIn($this->username, $this->password) === true) {

            $result = $this->sendData();

            $this->logOut();

            return $result;
        }

        return false;
    }

    abstract public function logIn(string $userName, string $password): bool;
    abstract public function sendData(): bool;
    abstract public function logOut(): void;
}

class Facebook extends SocialNetwork
{
    public function logIn(string $userName, string $password): bool
    {
        echo "Name: " . $this->username . "\n";
        echo "Password: " . str_repeat("*", strlen($this->password)) . "\n";

        echo "Facebook: '" . $this->username . "' ログイン\n";

        return true;
    }

    public function sendData(): bool
    {
        echo "Facebook: sendData\n";

        return true;
    }

    public function logOut(): void
    {
        echo "Facebook: '" . $this->username . "' ログアウト\n\n\n";
    }

}


class Twitter extends SocialNetwork
{
    public function logIn(string $userName, string $password): bool
    {
        echo "Name: " . $this->username . "\n";
        echo "Password: " . str_repeat("*", strlen($this->password)) . "\n";

        echo "Twitter: '" . $this->username . "'ログイン\n";

        return true;
    }

    public function sendData(): bool
    {
        echo "Twitter: sendData\n";

        return true;
    }

    public function logOut(): void
    {
        echo "Twitter: '" . $this->username . "' ログアウト\n\n\n";
    }
}


// 全体のアルゴリズムや構造は変えたくないが、特定のステップを拡張、オリジナル化したい場合に、 Template Method パターンを使用
$username = 'yuta';
$password = 'yuta_hogehoge';
$facebookNet = new Facebook($username, $password);
$facebookNet->post();


$username = 'sasaki';
$password = 'sasaki_hogehoge';
$twitterNet = new Twitter($username, $password);
$twitterNet->post();

