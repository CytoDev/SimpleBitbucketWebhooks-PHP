<?php

    declare(strict_types=1);

    namespace cytodev\integration\bitbucket\webhooks;

    use \LogicException;
    use \ReflectionException;

    use PHPUnit\Framework\TestCase;

    use PHPUnit\Framework\ExpectationFailedException;

    use SebastianBergmann\RecursionContext\InvalidArgumentException;

    use cytodev\integration\bitbucket\webhooks\entities\RepositoryEntity;

    /**
     * <h1>Class RepositoryEntityTest</h1>
     *
     * @package cytodev\integration\bitbucket\webhooks
     */
    final class RepositoryEntityTest extends TestCase {

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

            new RepositoryEntity();
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
            $repository = $this->webHookData["repository"];

            unset($repository["type"]);

            $this->expectException(LogicException::class);

            new RepositoryEntity($repository);
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
            $repository = $this->webHookData["repository"];

            $entity = new RepositoryEntity($repository);

            $this->assertInstanceOf(RepositoryEntity::class, $entity);
        }

    }
