<?php

class UserServiceProvider implements Provider
{
    public function register(Container $container)
    {
        // $db = $container->get("db"); // I guess this should be: $container->get("db", ['mysql:host=localhost;dbname=srdjan', 'root', '']);
        $hash = $container->get("hash");
        $container->set("UserService", function () use ($hash) {
            return new UserService($hash);
        });

        $container->set("UserApplicationService", function () use ($hash) {
            return new UserApplicationService($hash);
        });
    }
}
