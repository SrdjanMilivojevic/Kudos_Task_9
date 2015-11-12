<?php

class UserServiceProvider implements Provider
{
    public function register(Container $container)
    {
        $db = $container->get("db"); // I guess this should be: $container->get("db", ['mysql:host=localhost;dbname=srdjan', 'root', '']);z
        // $hash = $container->get("hash");
        $container->set("UserService", function () use ($db) {
            return new UserService($db);
        });

        $container->set("UserApplicationService", function () use ($db) {
            return new UserApplicationService($db);
        });
    }
}
