<?php

    namespace cytodev\integration\bitbucket\webhooks;

    use \LogicException;

    use cytodev\integration\bitbucket\webhooks\exceptions\ShellExecutionException;

    /**
     * <h1>Class BasicShellWebHook</h1>
     *
     * @package cytodev\integration\bitbucket\webhooks
     */
    class BasicShellWebHook {

        /**
         * @var string
         */
        private $workingPath;

        /**
         * @var string
         */
        private $originalPath;

        /**
         * <h2>BasicShellWebHook constructor.</h2>
         */
        public function __construct() {
            $this->originalPath = getcwd();
        }

        /**
         * <h2>createWorkingPath</h2>
         *   Attempts to create a working path
         *
         * @param string $workingPath Working directory path to create
         * @param int    $permissions Working directory permissions to set [Defaults: 02775]
         *
         * @return bool
         */
        public function createWorkingPath(string $workingPath, int $permissions = 02775): bool {
            return is_dir($workingPath) || mkdir($workingPath, $permissions);
        }

        /**
         * <h2>setWorkingPath</h2>
         *   Setter method for $this->workingPath
         *
         * @param string $workingPath Path to define as working directory
         *
         * @throws LogicException When the $deployPath can not be resolved to a real path
         *
         * @return void
         */
        public function setWorkingPath(string $workingPath): void {
            $realWorkingPath = realpath($workingPath);

            if($realWorkingPath=== false)
                throw new LogicException(sprintf("'%s' could not be resolved to a real path", $workingPath));

            $this->workingPath = $realWorkingPath;
        }

        /**
         * <h2>shellCommandsCallback</h2>
         *   Executes multiple shell commands in $this->deployPath, restores the working directory back to
         *   $this->originalPath when the commands exit with a successful exit code (0), and calls $callback with the
         *   output of the executed commands
         *
         * @param array    $commands Commands to execute [Defaults: empty]
         * @param callable $callback Callback to perform after execution of shell commands [Defaults: null]
         *
         * @return void
         */
        public function shellCommandsCallback(array $commands = [], callable $callback = null): void {
            $output = [];

            try {
                $this->shellCommands($commands, $output);
            } catch(ShellExecutionException $exception) {
                array_push($output, sprintf("'%s' terminated with exit code %d", $exception->getShellCommand(), $exception->getExitCode()));
            } finally {
                if(is_callable($callback))
                    $callback($output);
            }
        }

        /**
         * <h2>shellCommandsCallback</h2>
         *   Executes a shell command in $this->deployPath, restores the working directory back to $this->originalPath
         *   when the command exits with a successful exit code (0), and calls $callback with the output of the executed
         *   command
         *
         * @param string   $command  Command to execute [Defaults: ""]
         * @param callable $callback Callback to perform after execution of shell commands [Defaults: null]
         *
         * @return void
         */
        public function shellCommandCallback(string $command = "", callable $callback = null): void {
            $output = [];

            try {
                $this->shellCommand($command, $output);
            } catch(ShellExecutionException $exception) {
                array_push($output, sprintf("'%s' terminated with exit code %d", $exception->getShellCommand(), $exception->getExitCode()));
            } finally {
                if(is_callable($callback))
                    $callback($output);
            }
        }

        /**
         * <h2>shellCommands</h2>
         *   Executes multiple shell commands in $this->deployPath and restores the working directory back to
         *   $this->originalPath when the commands exit with a successful exit code (0)
         *
         * @param array $commands Commands to execute [Defaults: empty]
         * @param array &$output  Output array by reference [Defaults: empty]
         *
         * @throws ShellExecutionException When a shell command exits with a non-zero exit code
         *
         * @return void
         */
        public function shellCommands(array $commands = [], array &$output = []): void {
            foreach($commands as $command)
                $this->shellCommand($command, $output);
        }

        /**
         * <h2>shellCommand</h2>
         *   Executes a shell command in $this->deployPath and restores the working directory back to
         *   $this->originalPath when the command exits with a successful exit code (0)
         *
         * @param string $command Command to execute [Defaults: ""]
         * @param array  &$output Output array by reference [Defaults: empty]
         *
         * @throws ShellExecutionException When a shell command exits with a non-zero exit code
         *
         * @return void
         */
        public function shellCommand(string $command = "", array &$output = []): void {
            chdir($this->workingPath);

            exec($command, $output, $returnStatus);

            if($returnStatus !== 0)
                throw new ShellExecutionException($command, $returnStatus, $output);

            chdir($this->originalPath);
        }

    }
