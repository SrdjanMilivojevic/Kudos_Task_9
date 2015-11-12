<?php
// 1. Implement class Container
class Container implements ArrayAccess
{
    /**
     * Providers array.
     * @var array
     */
    private $providers = [];

    /**
     * Construct with reflection to access providers as array.
     */
    public function __construct()
    {
        // reflection for  3.Implement accessing and changing providers as array
        $reflect = new ReflectionClass($this);
        $reflect->getProperties();
    }

    /**
     * Sets the provider
     *
     * @param string  $name  [provider name]
     * @param string|int|array|closure|object  $provider
     * @param boolean $singleton
     */
    public function set($name, $provider, $singleton = false)
    {
        //5. Implement singleton access
        // Set the provider in case var $singleton is 'false',
        // or when it's 'true' BUT provider isn't already set.
        if ($singleton === false || ($singleton === true && !isset($this->providers[$name]))) {
            $this->providers[$name] = $provider;
        }
    }

    /**
     * Gets the provider
     *
     * @param  string $name  [provider name]
     * @param  array  $params
     * @return return_value_of_the_callback|string
     */
    public function get($name, $params = [])
    {
        if (isset($this->providers[$name])) {
            return ($this->providers[$name] instanceof Closure) ?
            call_user_func_array($this->providers[$name], $params) : $this->providers[$name];
        }

        return "Provider <b>" . $name . "</b> doesn't exist !";
    }

    // 2. Implement accessing and changing providers as property
    public function __set($name, $provider)
    {
        $this->providers[$name] = $provider;
    }

    public function __get($name)
    {
        return $this->get($name);
    }

    // 3. Implement accessing and changing providers as array
    // Interface ArrayAccess methods.
    public function offsetSet($name, $value)
    {
        is_null($name) ? $this->providers[] = $value : $this->providers[$name] = $value;
    }

    public function offsetExists($name)
    {
        return isset($this->providers[$name]);
    }

    public function offsetUnset($name)
    {
        unset($this->providers[$name]);
    }

    public function offsetGet($name)
    {
        return $this->get($name);
    }

    // 4. Implement accessing providers as function
    /**
     * Accessing providers as function
     *
     * @param  string $name   [provider name]
     * @param  array  $params
     * @return return_value_of_the_callback|string
     */
    public function __call($name, $params = [])
    {
        return $this->get($name, $params);
    }

    // 6. Implement provider interface
    /**
     * Registers a service provider.
     *
     * @param Provider $provider [Provider interface]
     * @return static
     */
    public function register(Provider $provider)
    {
        $provider->register($this);
        return $this;
    }
}
