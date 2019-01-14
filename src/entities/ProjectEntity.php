<?php

    namespace cytodev\integration\bitbucket\webhooks\entities;

    use \ReflectionException;
    use \LogicException;

    use cytodev\integration\bitbucket\webhooks\autological\Entity;

    /**
     * <h1>Class ProjectEntity</h1>
     *   This entity is subject to change whenever Atlassian feels like changing their request payloads
     *
     * @package cytodev\integration\bitbucket\webhooks\entities
     *
     * @method string      getType
     * @method string      getName
     * @method string      getUuid
     * @method LinksEntity getLinks
     * @method string      getKey
     */
    class ProjectEntity extends Entity {

        /**
         * @var string
         */
        protected $type;

        /**
         * @var string
         */
        protected $name;

        /**
         * @var string
         */
        protected $uuid;

        /**
         * @var LinksEntity
         */
        protected $links;

        /**
         * @var string
         */
        protected $key;

        /**
         * <h2>ProjectEntity constructor.</h2>
         *
         * @param array $payload The payload as sent by Bitbucket [Defaults: empty]
         *
         * @throws ReflectionException When ReflectionClass cannot find the calling class
         * @throws LogicException      When a private field has no default and is not set by Bitbucket's payload
         */
        public function __construct(array $payload = []) {
            $this->links = isset($payload["links"]) && is_array($payload["links"]) ? new LinksEntity($payload["links"]) : null;

            $this->type = isset($payload["type"]) ? $payload["type"] : null;
            $this->name = isset($payload["name"]) ? $payload["name"] : null;
            $this->uuid = isset($payload["uuid"]) ? $payload["uuid"] : null;
            $this->key  = isset($payload["key"])  ? $payload["key"]  : null;

            $this->validateConstruction();
        }

    }
