<?php

    namespace cytodev\integration\bitbucket\webhooks;

    use \Exception;

    use cytodev\integration\bitbucket\webhooks\exceptions\ShellExecutionException;

    /**
     * <h1>Class BasicDeployment</h1>
     *
     * @package cytodev\integration\bitbucket\webhooks
     */
    class BasicDeployment {

        /**
         * @var string
         */
        private $deployPath;

        /**
         * @var string
         */
        private $gitBinPath;

        /**
         * @var string
         */
        private $originalPath;

        /**
         * <h2>BasicDeployment constructor.</h2>
         *
         * @param string $gitBinPath  Absolute path to the git binary [Defaults: "/usr/bin/git"]
         */
        public function __construct(string $gitBinPath = "/usr/bin/git") {
            $this->gitBinPath   = $gitBinPath;
            $this->originalPath = getcwd();
        }

        /**
         * <h2>setDeployPath</h2>
         *   Sets the deployment path
         *
         * @param string $deployPath Path to deploy to
         *
         * @return void
         */
        public function setDeployPath(string $deployPath) {
            $this->deployPath = $deployPath;
        }

        /**
         * <h2>deploy</h2>
         *   Performs a very basic deployment
         *
         * <b>$postDeployCallback parameters</b>
         * <code>
         *  $output       array  git command(s) output
         *  $currentPath  string current working directory
         *  $originalPath string original working directory
         * </code>
         *
         * @param array    $gitCommands        Git commands to execute for deployment
         * @param callable $postDeployCallback Callback to execute on successful deployment [Defaults: null]
         *
         * @throws Exception               When the deployment directory could not be created
         * @throws ShellExecutionException When a git shell command exits with a non-successful exit code
         *
         * @return void
         */
        public function deploy(array $gitCommands = [], callable $postDeployCallback = null): void {
            if (!is_dir($this->deployPath) && !mkdir($this->deployPath, 2775, true))
                throw new Exception("Unable to create {$this->deployPath}");

            $this->executeGitCommands($gitCommands, $output);

            if(is_callable($postDeployCallback))
                $postDeployCallback($output, getcwd(), $this->originalPath);
        }

        /**
         * <h2>deploy</h2>
         *   Performs a very basic deployment
         *
         * <b>$postUpdateCallback parameters</b>
         * <code>
         *  $output       array  git command(s) output
         *  $currentPath  string current working directory
         *  $originalPath string original working directory
         * </code>
         *
         * @param array    $gitCommands        Git commands to execute for deployment
         * @param callable $postUpdateCallback Callback to execute on successful deployment [Defaults: null]
         *
         * @throws Exception               When the deployment directory could not be found
         * @throws ShellExecutionException When a git shell command exits with a non-successful exit code
         *
         * @return void
         */
        public function update(array $gitCommands = [], callable $postUpdateCallback = null): void {
            if (!is_dir($this->deployPath))
                throw new Exception("{$this->deployPath} does not exist");

            $this->executeGitCommands($gitCommands, $output);

            if(is_callable($postUpdateCallback))
                $postUpdateCallback($output, getcwd(), $this->originalPath);
        }

        /**
         * <h2>deploy</h2>
         *   Performs a very basic deployment
         *
         * <b>$postCleanCallback parameters</b>
         * <code>
         *  $output       array  git command(s) output
         *  $currentPath  string current working directory
         *  $originalPath string original working directory
         * </code>
         *
         * @param callable $postCleanCallback Callback to execute on successful deployment [Defaults: null]
         *
         * @throws Exception               When the deployment directory could not be created
         * @throws ShellExecutionException When a git shell command exits with a non-successful exit code
         *
         * @return void
         */
        public function clean(callable $postCleanCallback = null): void {
            $output = [];

            if (is_dir($this->deployPath)) {
                exec("rm -rf {$this->deployPath}", $output, $returnStatus);

                if($returnStatus !== 0)
                    throw new ShellExecutionException("rm -rf {$this->deployPath}", $returnStatus, $output);
            }

            if(is_callable($postCleanCallback))
                $postCleanCallback($output, getcwd(), $this->originalPath);
        }

        /**
         * <h2>executeGitCommands</h2>
         *   Executes shell commands in $this->deployPath
         *
         * @param array $gitCommands Git commands to execute for deployment [Defaults: empty]
         * @param array &$output     Output array by reference [Defaults: empty]
         *
         * @throws ShellExecutionException When a git shell command exits with a non-successful exit code
         *
         * @return void
         */
        private function executeGitCommands(array $gitCommands = [], &$output = []): void {
            chdir($this->deployPath);

            foreach($gitCommands as $gitCommand) {
                exec($gitCommand, $output, $returnStatus);

                if($returnStatus !== 0)
                    throw new ShellExecutionException($gitCommand, $returnStatus, $output);
            }
        }

    }
