<?php

    namespace cytodev\integration\bitbucket\webhooks\autological;

    use \BadMethodCallException;
    use \ReflectionClass;
    use \ReflectionProperty;
    use \ReflectionException;
    use \LogicException;

    use cytodev\integration\bitbucket\webhooks\exceptions\IllegalMethodException;

    /**
     * <h1>Class Entity</h1>
     *
     * @package cytodev\integration\bitbucket\webhooks\autological
     */
    class Entity {

        /**
         * <h2>validateConstruction</h2>
         *   Validates the construction of the entity
         *
         * @throws ReflectionException When ReflectionClass cannot find the calling class
         * @throws LogicException      When a private field has no default and is not set by Bitbucket's payload
         *
         * @return void
         */
        protected function validateConstruction() {
            $reflection = new ReflectionClass($this);

            $properties = $reflection->getProperties(ReflectionProperty::IS_PRIVATE);

            foreach($properties as $property) {
                if(!$property->isDefault() && $this->$property === null)
                    throw new LogicException(sprintf("%s::{$property} was not defined during construction, did the Bitbucket WebHook API change?", get_class($this)));
            }
        }

        /**
         * <h2>__call</h2>
         *   Wrapper method to allow getProperty() and setProperty() syntax in child classes as well as regular method
         *   calls that are inaccessible
         *
         * <b>Return values</b>
         * <code>
         *   mixed When __get is called                         returns $this->$property
         *   bool  When __set is called                         returns $this->$property === $arguments[0]
         *   mixed When any other method is called (and exists) returns $this->$name(...$arguments)
         * </code>
         *
         * @param string $name      Method name
         * @param array  $arguments Arguments to call the method with
         *
         * @throws BadMethodCallException When implied property does not exist
         * @throws IllegalMethodException When a call to setProperty() is made
         * @throws BadMethodCallException When called method does not exist
         *
         * @return mixed
         */
        final public function __call(string $name, array $arguments) {
            $property = lcfirst(substr($name, 3, strlen($name)));

            switch(substr($name, 0, 3)) {
                case "get":
                    if(!property_exists($this, $property))
                        throw new BadMethodCallException("Property \"{$property}\" not found in \"" . get_class($this) . "\"");

                    return $this->__get($property);
                case "set";
                    $this->__set($property, $arguments[0]);

                    return $this->__get($property) === $arguments[0];
                default:
                    if(!method_exists($this, $name))
                        throw new BadMethodCallException("Method \"{$name}\" not found in \"" . get_class($this) . "\"");

                    return $this->$name(...$arguments);
            }
        }

        /**
         * <h2>Magic __callStatic</h2>
         *
         * @param string $name      Name of the method being called
         * @param array  $arguments Array containing the parameters passed
         *
         * @throws IllegalMethodException Always
         *
         * @return void
         */
        final public static function __callStatic(string $name, array $arguments) {
            throw new IllegalMethodException($name, self::class . " does not allow static calls");
        }

        /**
         * <h2>Magic __get</h2>
         *   Gets inaccessible properties inside a child class
         *
         * @param string Variable name
         *
         * @return mixed
         */
        final public function __get(string $name) {
            return $this->$name;
        }

        /**
         * <h2>Magic __set</h2>
         *   Sets inaccessible properties inside a child class
         *
         * @param string $name  Variable name
         * @param mixed  $value Variable value
         *
         * @throws IllegalMethodException Always
         *
         * @return void
         */
        final public function __set(string $name, $value) {
            throw new IllegalMethodException(sprintf("set%s", ucfirst($name)));
        }

        /**
         * <h2>__isset</h2>
         *   Calls isset and empty on inaccessible properties inside a child class
         *
         * @param string $name The property name
         *
         * @throws BadMethodCallException When the property does not exist
         *
         * @return bool
         */
        final public function __isset(string $name): bool {
            if(!property_exists($this, $name))
                throw new BadMethodCallException("Property \"{$name}\" not found in \"" . get_class($this) . "\"");

            return isset($this->$name) || empty($this->$name);
        }

        /**
         * <h2>__isset</h2>
         *   Calls unset on inaccessible properties inside a child class
         *
         * @param string $name The property name
         *
         * @throws BadMethodCallException When the property does not exist
         *
         * @return void
         */
        final public function __unset(string $name): void {
            if(!property_exists($this, $name))
                throw new BadMethodCallException("Property \"{$name}\" not found in \"" . get_class($this) . "\"");

            unset($this->$name);
        }

    }
