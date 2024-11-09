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
        // Authenticate before posting. Every network uses a different
        // authentication method.
        if ($this->logIn($this->username, $this->password) === true) {
            // Send the post data. All networks have different APIs.
            $result = $this->sendData();
            // ...
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
        echo "\nChecking user's credentials...\n";
        echo "Name: " . $this->username . "\n";
        echo "Password: " . str_repeat("*", strlen($this->password)) . "\n";

        echo "\n\nFacebook: '" . $this->username . "' has logged in successfully.\n";

        return true;
    }

    public function sendData(): bool
    {
        echo "Facebook: '" . $this->username;

        return true;
    }

    public function logOut(): void
    {
        echo "Facebook: '" . $this->username . "' has been logged out.\n";
    }

}


class Twitter extends SocialNetwork
{
    public function logIn(string $userName, string $password): bool
    {
        echo "\nChecking user's credentials...\n";
        echo "Name: " . $this->username . "\n";
        echo "Password: " . str_repeat("*", strlen($this->password)) . "\n";

        echo "\n\nTwitter: '" . $this->username . "' has logged in successfully.\n";

        return true;
    }

    public function sendData(): bool
    {
        echo "Twitter: '" . $this->username;

        return true;
    }

    public function logOut(): void
    {
        echo "Twitter: '" . $this->username . "' has been logged out.\n";
    }
}



$username = 'yuta';
$password = 'yuta_hogehoge';
$facebookNet = new Facebook($username, $password);
$facebookNet->post();


$username = 'sasaki';
$password = 'sasaki_hogehoge';
$twitterNet = new Twitter($username, $password);
$twitterNet->post();

