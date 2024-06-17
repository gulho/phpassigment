<?php

namespace Service;

use Config\Config;
use Model\UserModel;

class UserService
{
    private $db;

    public function __construct()
    {
        $this->db = new \PDO("sqlite:" . Config::$dbFile);
    }

    final public function registerUser(UserModel $user): UserModel|bool
    {
        $smtp = $this->db->prepare("INSERT INTO user (username, password) VALUES (:username, :password)");
        $smtp->bindValue(':username', $user->getUsername());
        $smtp->bindValue(':password', password_hash($user->getPassword(), PASSWORD_BCRYPT));
        if ($smtp->execute()) {
            return $this->getUser($user->getUsername());
        } else {
            return false;
        }
    }

    final public function getUser(string $username): UserModel|bool
    {
        $smtp = $this->db->prepare('SELECT * FROM user WHERE username = :username');
        $smtp->execute(['username' => $username]);
        $row = $smtp->fetch(\PDO::FETCH_ASSOC);
        if ($row) {
            return new UserModel($row['username'], $row['password'], $row['count']);
        } else {
            return false;
        }
    }

    final public function addOneMore(UserModel $user): bool
    {
        $smtp = $this->db->prepare('UPDATE user SET count = count +1 WHERE username = :username');
        if ($smtp->execute(['username' => $user->getUsername()])) {
            return true;
        }
        return false;
    }

}