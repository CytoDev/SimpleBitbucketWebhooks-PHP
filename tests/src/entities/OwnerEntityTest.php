<?php

    declare(strict_types=1);

    namespace cytodev\integration\bitbucket\webhooks;

    use \LogicException;
    use \ReflectionException;

    use PHPUnit\Framework\TestCase;

    use cytodev\integration\bitbucket\webhooks\entities\OwnerEntity;

    final class OwnerEntityTest extends TestCase {

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

            new OwnerEntity();
        }

    }
