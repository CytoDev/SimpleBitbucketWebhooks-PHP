<?php

    namespace cytodev\integration\bitbucket\webhooks\entities;

    use \ReflectionException;
    use \LogicException;

    use cytodev\integration\bitbucket\webhooks\autological\Entity;

    /**
     * <h1>Class OwnerEntity</h1>
     *   This entity is subject to change whenever Atlassian feels like changing their request payloads
     *
     * @package cytodev\integration\bitbucket\webhooks\entities
     *
     * @method string      getType
     * @method string      getNickname
     * @method string      getDisplayName
     * @method string      getUuid
     * @method LinksEntity getLinks
     */
    class OwnerEntity extends Entity {

        const TYPE_USER = 0;
        const TYPE_TEAM = 1;

        /**
         * @var int
         */
        protected $type;

        /**
         * @var string
         */
        protected $nickname;

        /**
         * @var string
         */
        protected $displayName;

        /**
         * @var string
         */
        protected $uuid;

        /**
         * @var LinksEntity
         */
        protected $links;

        /**
         * <h2>OwnerEntity constructor.</h2>
         *
         * @param array $payload The payload as sent by Bitbucket [Defaults: empty]
         *
         * @throws ReflectionException When ReflectionClass cannot find the calling class
         * @throws LogicException      When a private field has no default and is not set by Bitbucket's payload
         */
        public function __construct(array $payload = []) {
            $this->links = isset($payload["links"]) && is_array($payload["links"]) ? new LinksEntity($payload["links"]) : null;

            $this->nickname    = isset($payload["nickname"])     ? $payload["nickname"]     : null;
            $this->displayName = isset($payload["display_name"]) ? $payload["display_name"] : null;
            $this->uuid        = isset($payload["uuid"])         ? $payload["uuid"]         : null;

            if(isset($payload["type"])) {
                switch($payload["type"]) {
                    case "user":
                        $this->type = self::TYPE_USER;
                        break;
                    case "team":
                        $this->type = self::TYPE_TEAM;
                        break;
                    default:
                        $this->type = null;
                }
            }

            $this->validateConstruction();
        }

    }
