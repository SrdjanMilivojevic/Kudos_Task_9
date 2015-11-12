<?php

class UserService extends UserServiceBase
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getUser($userId)
    {
        return $userId . ' Radi !<br>';
    }
}
