<?php

spl_autoload_register(function ($class) {
    require_once $class . '.php';
});

$container = new Container();

// $container->set("book", "Lord of the flies");
// $container->set("number", 317);
// $container->set("now", function () {
//     return date("F j, Y, g:i a");
// });
// $container->set("hello", function ($firstName, $lastName) {
//     return "Hello " . $firstName . " " . $lastName;
// });
// echo $container->get("book"); // Prints "Lord of the flies"
// echo $container->get("number"); // Prints 317
// echo $container->get("now"); // Prints now date ("August 23, 2015, 7:28 am")
// echo $container->get("hello", ["John", "Doe"]); // Prints "Hello John Doe"
//
// $container->book = "Lord of the flies 2";
// echo $container->book; // Prints "Lord of the flies 2"
// echo $container->now; // Prints now date ("August 23, 2015, 7:28 am")

// $container["book"] = "Lord of the flies 3";
// echo $container['book']; // Prints "Lord of the flies 3"
// echo $container['now']; // Prints now date ("August 23, 2015, 7:28 am")

// echo $container->book(); // Prints "Lord of the flies"
// echo $container->number(); // Prints 317
// echo $container->now(); // Prints now date ("August 23, 2015, 7:28 am")
// echo $container->hello("John", "Doe"); // Prints "Hello John Doe"
$dsn = 'mysql:host=localhost;dbname=srdjan';
$user = 'root';
$pass = '';
//    // $container->set("db", function ($dsn, $user, $pass) {}  - If we set it like that, then we need to
//    // call it like this:  $container->get("db", ['mysql:host=localhost;dbname=srdjan', 'root', '']);
$container->set("db", function () use ($dsn, $user, $pass) {
    return new \PDO($dsn, $user, $pass);
}, true);
// $db = $container->get("db"); // Always returns the same instance
$container->set("MAX_BUFFER_SIZE", 200, true);
$container->set("hash", function () {
    return md5(gethostname() . time());
}, true);
// $value = $container->MAX_BUFFER_SIZE;
// echo $value . "<br>"; // Prints 200
// $container->MAX_BUFFER_SIZE = 300;
// echo $value . "<br>"; // Still prints 200
// $value = $container->hash();
// echo $value . "<br>"; // Prints "c5fbeb164b784672ae118d0442aa7be6" - based on current time
// $value = $container->hash();
// echo $value . "<br>"; // Still prints "c5fbeb164b784672ae118d0442aa7be6" - based on current time

$container->register(new UserServiceProvider());

print $container->get("UserService")->getUser(317);
print $container->get("UserApplicationService")->getUserApplications(317);
