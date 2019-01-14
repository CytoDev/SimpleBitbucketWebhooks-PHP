<?php

    namespace cytodev\integration\bitbucket\webhooks\entities;

    use \ReflectionException;
    use \LogicException;

    use cytodev\integration\bitbucket\webhooks\autological\Entity;

    /**
     * <h1>Class LinksEntity</h1>
     *   This entity is subject to change whenever Atlassian feels like changing their request payloads
     *
     * @package cytodev\integration\bitbucket\webhooks\entities
     *
     * @method string getSelf
     * @method string getHtml
     * @method string getAvatar
     */
    class LinksEntity extends Entity {

        /**
         * @var string|null
         */
        protected $self;

        /**
         * @var string
         */
        protected $html;

        /**
         * @var string|null
         */
        protected $avatar;

        /**
         * <h2>LinksEntity constructor.</h2>
         *
         * @param array $payload The payload as sent by Bitbucket [Defaults: empty]
         *
         * @throws ReflectionException When ReflectionClass cannot find the calling class
         * @throws LogicException      When a private field has no default and is not set by Bitbucket's payload
         */
        public function __construct(array $payload = []) {
            $this->self   = isset($payload["self"])   && isset($payload["self"]["href"])   ? $payload["self"]["href"]   : null;
            $this->html   = isset($payload["html"])   && isset($payload["html"]["href"])   ? $payload["html"]["href"]   : null;
            $this->avatar = isset($payload["avatar"]) && isset($payload["avatar"]["href"]) ? $payload["avatar"]["href"] : null;

            $this->validateConstruction();
        }

    }
