<?php

    namespace cytodev\integration\bitbucket\webhooks\exceptions;

    use \Exception;

    /**
     * <h1>Class IllegalMethodException</h1>
     *
     * @package cytodev\integration\bitbucket\webhooks\exceptions
     */
    class IllegalMethodException extends Exception {

        /**
         * @var string
         */
        private $method;

        /**
         * @var string
         */
        private $reason;

        /**
         * <h2>IllegalMethodException constructor.</h2>
         *
         * @param string    $method   Method being called
         * @param string    $reason   Specific reason of this exception [Defaults: ""]
         * @param integer   $code     The exception code [Defaults: 0]
         * @param Exception $previous The previous exception used for the exception chaining [Defaults: null]
         */
        public function __construct(string $method, string $reason = "", int $code = 0, Exception $previous = null) {
            $this->method = $method;
            $this->reason = $reason;

            parent::__construct(sprintf("Illegal method call '%s'%s", $method, !empty($reason) ? " {$reason}": ""), $code, $previous);
        }

    }
