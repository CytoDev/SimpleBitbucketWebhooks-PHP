<?php

    declare(strict_types=1);

    namespace cytodev\integration\bitbucket\webhooks;

    use \LogicException;
    use \ReflectionException;

    use PHPUnit\Framework\TestCase;

    use PHPUnit\Framework\ExpectationFailedException;

    use SebastianBergmann\RecursionContext\InvalidArgumentException;

    use cytodev\integration\bitbucket\webhooks\entities\PullRequestEntity;

    final class PullRequestEntityTest extends TestCase {

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
            $data = json_decode(file_get_contents("resources/pullRequest.json"), true);

            $pullRequest = new PullRequestEntity($data["pullrequest"]);

            $this->assertInstanceOf(PullRequestEntity::class, $pullRequest);
        }

    }
