<?php

    namespace cytodev\integration\bitbucket\webhooks\entities;

    use \ReflectionException;
    use \LogicException;

    use cytodev\integration\bitbucket\webhooks\autological\Entity;

    /**
     * <h1>Class RepositoryEntity</h1>
     *   This entity is subject to change whenever Atlassian feels like changing their request payloads
     *
     * @package cytodev\integration\bitbucket\webhooks\entities
     *
     * @method string        getType
     * @method string        getName
     * @method string        getFullName
     * @method string        getUuid
     * @method LinksEntity   getLinks
     * @method ProjectEntity getProject
     * @method string        getWebsite
     * @method OwnerEntity   getOwner
     * @method string        getScm
     * @method bool          getIsPrivate
     */
    class RepositoryEntity extends Entity {

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
        protected $fullName;

        /**
         * @var string
         */
        protected $uuid;

        /**
         * @var LinksEntity
         */
        protected $links;

        /**
         * @var ProjectEntity|null
         */
        protected $project = null;

        /**
         * @var string|null
         */
        protected $website;

        /**
         * @var ActorEntity|null
         */
        protected $owner;

        /**
         * @var string|null
         */
        protected $scm;

        /**
         * @var bool|null
         */
        protected $isPrivate;

        /**
         * <h2>RepositoryEntity constructor.</h2>
         *
         * @param array $payload The payload as sent by Bitbucket [Defaults: empty]
         *
         * @throws ReflectionException When ReflectionClass cannot find the calling class
         * @throws LogicException      When a private field has no default and is not set by Bitbucket's payload
         */
        public function __construct(array $payload = []) {
            $this->links   = isset($payload["links"])   && is_array($payload["links"])   ? new LinksEntity($payload["links"])     : null;
            $this->project = isset($payload["project"]) && is_array($payload["project"]) ? new ProjectEntity($payload["project"]) : null;
            $this->owner   = isset($payload["owner"])   && is_array($payload["owner"])   ? new ActorEntity($payload["owner"])     : null;

            $this->type     = isset($payload["type"])      ? $payload["type"]      : null;
            $this->name     = isset($payload["name"])      ? $payload["name"]      : null;
            $this->fullName = isset($payload["full_name"]) ? $payload["full_name"] : null;
            $this->uuid     = isset($payload["uuid"])      ? $payload["uuid"]      : null;
            $this->website  = isset($payload["website"])   ? $payload["website"]   : null;
            $this->scm      = isset($payload["scm"])       ? $payload["scm"]       : null;

            $this->isPrivate = isset($payload["is_private"]) ? filter_var($payload["is_private"], FILTER_VALIDATE_BOOLEAN) : null;

            $this->validateConstruction();
        }

    }
