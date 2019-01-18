<?php

    declare(strict_types=1);

    namespace cytodev\integration\bitbucket\webhooks;

    use \LogicException;
    use \ReflectionException;

    use PHPUnit\Framework\TestCase;

    use cytodev\integration\bitbucket\webhooks\entities\LinksEntity;

    final class LinksEntityTest extends TestCase {

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

            new LinksEntity();
        }

    }
