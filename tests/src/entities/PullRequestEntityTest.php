<?php

    declare(strict_types=1);

    namespace cytodev\integration\bitbucket\webhooks;

    use \LogicException;
    use \ReflectionException;

    use PHPUnit\Framework\TestCase;

    use PHPUnit\Framework\ExpectationFailedException;

    use SebastianBergmann\RecursionContext\InvalidArgumentException;

    use cytodev\integration\bitbucket\webhooks\entities\PullRequestEntity;

    /**
     * <h1>Class PullRequestEntityTest</h1>
     *
     * @package cytodev\integration\bitbucket\webhooks
     */
    final class PullRequestEntityTest extends TestCase {

        /**
         * @var array
         */
        private $webHookData;

        /**
         * <h2>setUp</h2>
         *   Build the default test cases' data
         *
         * @return void
         */
        public function setUp() {
            $this->webHookData = json_decode(file_get_contents(sprintf("%s/../../resources/pullRequest.json", dirname(__FILE__))), true);
        }

        /**
         * <h2>testCannotInstantiateWithoutData</h2>
         *
         * @throws LogicException
         * @throws ReflectionException
         *
         * @return void
         */
        public function testCannotInstantiateWithoutData() {
            $this->expectException(LogicException::class);

            new PullRequestEntity();
        }

        /**
         * <h2>testCannotInstantiateWithIncompleteData</h2>
         *
         * @throws LogicException
         * @throws ReflectionException
         *
         * @return void
         */
        public function testCannotInstantiateWithIncompleteData() {
            $pullRequest = $this->webHookData["pullrequest"];

            unset($pullRequest["source"]);

            $this->expectException(LogicException::class);

            new PullRequestEntity($pullRequest);
        }

        /**
         * <h2>testCanInstantiateWithData</h2>
         *
         * @throws LogicException
         * @throws ReflectionException
         * @throws ExpectationFailedException
         * @throws InvalidArgumentException
         *
         * @return void
         */
        public function testCanInstantiateWithData() {
            $pullRequest = $this->webHookData["pullrequest"];

            $entity = new PullRequestEntity($pullRequest);

            $this->assertInstanceOf(PullRequestEntity::class, $entity);
        }

    }
