<?php

    declare(strict_types=1);

    namespace cytodev\integration\bitbucket\webhooks;

    use \LogicException;

    use PHPUnit\Framework\TestCase;

    use PHPUnit\Framework\ExpectationFailedException;

    use SebastianBergmann\RecursionContext\InvalidArgumentException;

    use cytodev\integration\bitbucket\webhooks\exceptions\ShellExecutionException;

    /**
     * <h1>Class BasicShellWebHookTest</h1>
     *
     * @package cytodev\integration\bitbucket\webhooks
     */
    final class BasicShellWebHookTest extends TestCase {

        /**
         * <h2>testCanInstantiate</h2>
         *
         * @throws ExpectationFailedException
         * @throws InvalidArgumentException
         *
         * @return void
         */
        public function testCanInstantiate() {
            $webHook = new BasicShellWebHook();

            $this->assertInstanceOf(BasicShellWebHook::class, $webHook);
        }

        /**
         * <h2>testCanCreateWorkingPath</h2>
         *
         * @depends cytodev\integration\bitbucket\webhooks\BasicShellWebHookTest::testCanInstantiate
         *
         * @throws ExpectationFailedException
         * @throws InvalidArgumentException
         *
         * @return void
         */
        public function testCanCreateWorkingPath() {
            $webHook = new BasicShellWebHook();
            $path    = sprintf("%s/../.tmp/test", dirname(__FILE__));

            $this->assertTrue($webHook->createWorkingPath($path));
            $this->assertTrue(is_dir($path));
            $this->assertTrue(rmdir($path));
        }

        /**
         * <h2>testCannotSetNonExistingWorkingPath</h2>
         *
         * @depends cytodev\integration\bitbucket\webhooks\BasicShellWebHookTest::testCanInstantiate
         *
         * @throws LogicException
         *
         * @return void
         */
        public function testCannotSetNonExistingWorkingPath() {
            $webHook = new BasicShellWebHook();
            $path    = sprintf("%s/../.tmp/test", dirname(__FILE__));

            $this->expectException(LogicException::class);

            $webHook->setWorkingPath($path);
        }

        /**
         * <h2>testCanSetExistingWorkingPath</h2>
         *
         * @depends cytodev\integration\bitbucket\webhooks\BasicShellWebHookTest::testCanCreateWorkingPath
         *
         * @throws ExpectationFailedException
         * @throws InvalidArgumentException
         * @throws LogicException
         *
         * @return void
         */
        public function testCanSetExistingWorkingPath() {
            $webHook = new BasicShellWebHook();
            $path    = sprintf("%s/../.tmp/test", dirname(__FILE__));

            $this->assertTrue($webHook->createWorkingPath($path));

            $webHook->setWorkingPath($path);

            $this->addToAssertionCount(1);
            $this->assertTrue(is_dir($path));
            $this->assertTrue(rmdir($path));
        }

        /**
         * <h2>testCanFailExecutedShellCommand</h2>
         *
         * @depends cytodev\integration\bitbucket\webhooks\BasicShellWebHookTest::testCanCreateWorkingPath
         *
         * @throws ExpectationFailedException
         * @throws InvalidArgumentException
         * @throws LogicException
         * @throws ShellExecutionException
         *
         * @return void
         */
        public function testCanFailExecutedShellCommand() {
            $webHook = new BasicShellWebHook();
            $path    = sprintf("%s/../.tmp/test", dirname(__FILE__));
            $output  = [];

            $this->assertTrue($webHook->createWorkingPath($path));
            $this->assertTrue(is_dir($path));

            $webHook->setWorkingPath($path);

            $this->expectException(ShellExecutionException::class);

            $webHook->shellCommand("exit 1", $output);

            $this->assertTrue(rmdir($path));
        }

        /**
         * <h2>testCanExecuteShellCommand</h2>
         *
         * @depends cytodev\integration\bitbucket\webhooks\BasicShellWebHookTest::testCanCreateWorkingPath
         *
         * @throws ExpectationFailedException
         * @throws InvalidArgumentException
         * @throws LogicException
         * @throws ShellExecutionException
         *
         * @return void
         */
        public function testCanExecuteShellCommand() {
            $webHook = new BasicShellWebHook();
            $path    = sprintf("%s/../.tmp/test", dirname(__FILE__));
            $output  = [];

            $this->assertTrue($webHook->createWorkingPath($path));
            $this->assertTrue(is_dir($path));

            $webHook->setWorkingPath($path);

            $webHook->shellCommand("ls", $output);

            $this->addToAssertionCount(1);
            $this->assertTrue(rmdir($path));
        }

        /**
         * <h2>testCanExecuteAndFailShellCommands</h2>
         *
         * @depends cytodev\integration\bitbucket\webhooks\BasicShellWebHookTest::testCanExecuteShellCommand
         *
         * @throws ExpectationFailedException
         * @throws InvalidArgumentException
         * @throws LogicException
         * @throws ShellExecutionException
         *
         * @return void
         */
        public function testCanExecuteAndFailShellCommands() {
            $webHook = new BasicShellWebHook();
            $path    = sprintf("%s/../.tmp/test", dirname(__FILE__));
            $output  = [];

            $this->assertTrue($webHook->createWorkingPath($path));
            $this->assertTrue(is_dir($path));

            $webHook->setWorkingPath($path);

            $this->expectException(ShellExecutionException::class);

            $webHook->shellCommands([
                "ls",
                "exit 1"
            ], $output);

            $this->addToAssertionCount(1);
            $this->assertTrue(rmdir($path));
        }

        /**
         * <h2>testCanExecuteShellCommands</h2>
         *
         * @depends cytodev\integration\bitbucket\webhooks\BasicShellWebHookTest::testCanExecuteShellCommand
         *
         * @throws ExpectationFailedException
         * @throws InvalidArgumentException
         * @throws LogicException
         * @throws ShellExecutionException
         *
         * @return void
         */
        public function testCanExecuteShellCommands() {
            $webHook = new BasicShellWebHook();
            $path    = sprintf("%s/../.tmp/test", dirname(__FILE__));
            $output  = [];

            $this->assertTrue($webHook->createWorkingPath($path));
            $this->assertTrue(is_dir($path));

            $webHook->setWorkingPath($path);

            $webHook->shellCommands([
                "ls",
                "ls -halF"
            ], $output);

            $this->addToAssertionCount(1);
            $this->assertTrue(rmdir($path));
        }

        /**
         * <h2>testCanExecuteShellCommandAndCallback</h2>
         *
         * @depends cytodev\integration\bitbucket\webhooks\BasicShellWebHookTest::testCanExecuteShellCommand
         *
         * @throws ExpectationFailedException
         * @throws InvalidArgumentException
         * @throws LogicException
         *
         * @return void
         */
        public function testCanExecuteShellCommandAndCallback() {
            $webHook = new BasicShellWebHook();
            $path    = sprintf("%s/../.tmp/test", dirname(__FILE__));

            $this->assertTrue($webHook->createWorkingPath($path));
            $this->assertTrue(is_dir($path));

            $webHook->setWorkingPath($path);

            $webHook->shellCommandCallback("ls", function($output) {
                $this->assertIsArray($output);
            });

            $this->assertTrue(rmdir($path));
        }

        /**
         * <h2>testCanExecuteShellCommandsAndCallback</h2>
         *
         * @depends cytodev\integration\bitbucket\webhooks\BasicShellWebHookTest::testCanExecuteShellCommands
         *
         * @throws ExpectationFailedException
         * @throws InvalidArgumentException
         * @throws LogicException
         *
         * @return void
         */
        public function testCanExecuteShellCommandsAndCallback() {
            $webHook = new BasicShellWebHook();
            $path    = sprintf("%s/../.tmp/test", dirname(__FILE__));

            $this->assertTrue($webHook->createWorkingPath($path));
            $this->assertTrue(is_dir($path));

            $webHook->setWorkingPath($path);

            $webHook->shellCommandsCallback([
                "ls",
                "ls -halF"
            ], function($output) {
                $this->assertIsArray($output);
            });

            $this->assertTrue(rmdir($path));
        }

    }
