# Kudos_Task_9
konkurs za posao PHP rookie - KUDOS

#Service Container
PHP Test<br>
Implement class that will act as a service container for managing providers to have
a way of dependency injection.
Provider type can be scalar, object, array, resource or closure.
Registering provider that already exists is not considered as error.
##1. Implement class Container
Having two methods:<br>
Container::set($name, $provider, $singleton = false);<br>
Container::get($name, $params = array());<br>
$container = new Container();<br>
$container->set("book", "Lord of the flies");<br>
$container->set("number", 317);<br>
$container->set("now", function() {<br>
    return date("F j, Y, g:i a");<br>
});<br>
$container->set("hello", function($firstName, $lastName) {<br>
    return "Hello {$firstName} {$lastName}";<br>
});<br>
echo $container->get("book"); // Prints "Lord of the flies"<br>
echo $container->get("number"); // Prints 317<br>
echo $container->get("now"); // Prints now date ("August 23, 2015, 7:28 am")<br>
echo $container->get("hello", array("John", "Doe"))); // Prints "Hello John Doe"<br>
##2. Implement accessing and changing providers as property<br>
Closure providers in this case can not accept parameters.<br>
$container->book = "Lord of the flies 2";<br>
echo $container->book; // Prints "Lord of the flies 2"<br>
echo $container->now; // Prints now date ("August 23, 2015, 7:28 am")<br>
##3. Implement accessing and changing providers as array<br>
Closure providers in this case can not accept parameters.<br>
$container["book"] = "Lord of the flies 3";<br>
echo $container[“book”]; // Prints "Lord of the flies 3"<br>
echo $container[“now”]; // Prints now date ("August 23, 2015, 7:28 am")<br>
##4. Implement accessing providers as function
Closure providers can accept parameters.<br>
echo $container->book(); // Prints "Lord of the flies"<br>
echo $container->number(); // Prints 317<br>
echo $container->now(); // Prints now date ("August 23, 2015, 7:28 am")<br>
echo $container->hello("John", "Doe"); // Prints "Hello John Doe"<br>
##5. Implement singleton access
Having third parameter singleton as true in Container::set method should always<br>
return the same instance for result. If the provider is not closure, it is treated as constant.<br>
$container->set("db", function($dsn, $user, $pass) {<br>
return new \PDO($dsn, $user, $pass);<br>
}, true);<br>
$db = $container->get("db"); // Always returns the same instance<br>
$container->set("MAX_BUFFER_SIZE", 200, true);<br>
$container->set("hash", function() {<br>
return md5(gethostname() . time());<br>
}, true);<br>
$value = $container->MAX_BUFFER_SIZE;<br>
echo $value; // Prints 200<br><br>
$container->MAX_BUFFER_SIZE = 300;
echo $value; // Still prints 200<br>
$value = $container->hash();<br>
echo $value; // Prints "c5fbeb164b784672ae118d0442aa7be6"<br>
$value = $container->hash();<br>
echo $value; // Still prints "c5fbeb164b784672ae118d0442aa7be6"
##6. Implement provider interface
Provider interface makes services reusable.<br>
Container::register(Provider $provider);<br>
$container->register(new UserServiceProvider());<br>
$container->get("UserService")->getUser(317);<br>
$container->get("UserApplicationService")->getUserApplications(317);<br>
interface Provider {<br>
public function register(Container $container) {}<br>
}<br>
class UserServiceProvider implements Provider {<br>
public function register(Container $container) {<br>
$db = $container->get("db");<br>
$container->set("UserService", function() use($db) {<br>
return new UserService($db);<br>
});<br>
$container->set("UserApplicationService", function() use($db) {<br>
return new UserApplicationService($db);<br>
});<br>
}<br>
}<br>
class UserServiceBase {<br>
public function __construct(\PDO $pdo) { ... }<br>
}<br>
class UserService extends UserServiceBase {<br>
public function getUser($userId) { ... }<br>
}<br>
class UserApplicationService extends UserServiceBase{<br>
public function getUserApplications($userId) { ... }<br>
}<br>
Marko Prelic<br>
23. August 2015.<br>
