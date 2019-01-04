<?php

    namespace cytodev\integration\bitbucket\webhooks\exceptions;

    use \Exception;

    /**
     * <h1>Class ShellExecutionException</h1>
     *
     * @package cytodev\integration\bitbucket\webhooks\exceptions
     */
    class ShellExecutionException extends Exception {

        /**
         * @var string
         */
        private $shellCommand;

        /**
         * @var int
         */
        private $exitCode;

        /**
         * @var string
         */
        private $shellTrace;

        /**
         * <h2>ShellExecutionException constructor.</h2>
         *
         * @param string    $command    Shell command being executed
         * @param integer   $exitCode   Shell command exit code
         * @param array     $shellTrace Shell output that lead up to the faulty execution
         * @param integer   $code       The exception code [Defaults: 0]
         * @param Exception $previous   The previous exception used for the exception chaining [Defaults: null]
         */
        public function __construct(string $command, int $exitCode, array $shellTrace, int $code = 0, Exception $previous = null) {
            $this->shellCommand = $command;
            $this->exitCode     = $exitCode;
            $this->shellTrace   = implode("\n", $shellTrace);

            parent::__construct(sprintf("Shell command '%s' failed with exit code %d", $command, $exitCode), $code, $previous);
        }

    }
