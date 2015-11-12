<?php

class UserApplicationService extends UserServiceBase
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getUserApplications($userId)
    {
        return $userId . ' Radi !<br>';
    }
}
