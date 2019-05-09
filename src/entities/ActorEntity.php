<?php

    namespace cytodev\integration\bitbucket\webhooks\entities;

    use \ReflectionException;
    use \LogicException;

    use cytodev\integration\bitbucket\webhooks\autological\Entity;

    /**
     * <h1>Class ActorEntity</h1>
     *   This entity is subject to change whenever Atlassian feels like changing their request payloads
     *
     * @package cytodev\integration\bitbucket\webhooks\entities
     *
     * @method string      getAccountId
     * @method string      getUuid
     * @method string      getDisplayName
     * @method LinksEntity getLinks
     * @method string      getNickname
     * @method string      getType
     * @method string      getUsername
     */
    class ActorEntity extends Entity {

        /**
         * @var string
         */
        private $accountId;

        /**
         * @var string
         */
        private $uuid;

        /**
         * @var string
         */
        private $displayName;

        /**
         * @var LinksEntity
         */
        private $links;

        /**
         * @var string
         */
        private $nickname;

        /**
         * @var string
         */
        private $type;

        /**
         * @var string
         */
        private $username;

        /**
         * <h2>PullRequestEntity constructor.</h2>
         *
         * @param array $payload The payload as sent by Bitbucket [Defaults: empty]
         *
         * @throws ReflectionException When ReflectionClass cannot find the calling class
         * @throws LogicException      When a private field has no default and is not set by Bitbucket's payload
         */
        public function __construct(array $payload = []) {
            $this->links = isset($payload["links"]) && is_array($payload["links"]) ? new LinksEntity($payload["links"]) : null;

            $this->accountId   = isset($payload["account_id"])   ? $payload["account_id"]   : null;
            $this->uuid        = isset($payload["uuid"])         ? $payload["uuid"]         : null;
            $this->displayName = isset($payload["display_name"]) ? $payload["display_name"] : null;
            $this->nickname    = isset($payload["nickname"])     ? $payload["nickname"]     : null;
            $this->type        = isset($payload["type"])         ? $payload["type"]         : null;
            $this->username    = isset($payload["username"])     ? $payload["username"]     : null;

            $this->validateConstruction();
        }

    }
