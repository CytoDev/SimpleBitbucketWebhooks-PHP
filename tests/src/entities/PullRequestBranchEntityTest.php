<?php

    declare(strict_types=1);

    namespace cytodev\integration\bitbucket\webhooks;

    use \LogicException;
    use \ReflectionException;

    use PHPUnit\Framework\TestCase;

    use cytodev\integration\bitbucket\webhooks\entities\PullRequestBranchEntity;

    /**
     * <h1>Class PullRequestBranchEntityTest</h1>
     *
     * @package cytodev\integration\bitbucket\webhooks
     */
    final class PullRequestBranchEntityTest extends TestCase {

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

            new PullRequestBranchEntity();
        }

    }
