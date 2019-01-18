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
     * @method string|null getActivity
     * @method string|null getApprove
     * @method string|null getAvatar
     * @method string|null getComments
     * @method string|null getCommits
     * @method string|null getDecline
     * @method string|null getDiff
     * @method string      getHtml
     * @method string|null getMerge
     * @method string|null getSelf
     * @method string|null getStatuses
     */
    class LinksEntity extends Entity {

        /**
         * @var string|null
         */
        protected $activity;

        /**
         * @var string|null
         */
        protected $approve;

        /**
         * @var string|null
         */
        protected $avatar;

        /**
         * @var string|null
         */
        protected $comments;

        /**
         * @var string|null
         */
        protected $commits;

        /**
         * @var string|null
         */
        protected $decline;

        /**
         * @var string|null
         */
        protected $diff;

        /**
         * @var string
         */
        protected $html;

        /**
         * @var string|null
         */
        protected $merge;

        /**
         * @var string|null
         */
        protected $self;

        /**
         * @var string|null
         */
        protected $statuses;

        /**
         * <h2>LinksEntity constructor.</h2>
         *
         * @param array $payload The payload as sent by Bitbucket [Defaults: empty]
         *
         * @throws ReflectionException When ReflectionClass cannot find the calling class
         * @throws LogicException      When a private field has no default and is not set by Bitbucket's payload
         */
        public function __construct(array $payload = []) {
            $this->activity = isset($payload["activity"]) && isset($payload["activity"]["href"]) ? $payload["activity"]["href"] : null;
            $this->approve  = isset($payload["approve"])  && isset($payload["approve"]["href"])  ? $payload["approve"]["href"]  : null;
            $this->avatar   = isset($payload["avatar"])   && isset($payload["avatar"]["href"])   ? $payload["avatar"]["href"]   : null;
            $this->comments = isset($payload["comments"]) && isset($payload["comments"]["href"]) ? $payload["comments"]["href"] : null;
            $this->commits  = isset($payload["commits"])  && isset($payload["commits"]["href"])  ? $payload["commits"]["href"]  : null;
            $this->decline  = isset($payload["decline"])  && isset($payload["decline"]["href"])  ? $payload["decline"]["href"]  : null;
            $this->diff     = isset($payload["diff"])     && isset($payload["diff"]["href"])     ? $payload["diff"]["href"]     : null;
            $this->html     = isset($payload["html"])     && isset($payload["html"]["href"])     ? $payload["html"]["href"]     : null;
            $this->merge    = isset($payload["merge"])    && isset($payload["merge"]["href"])    ? $payload["merge"]["href"]    : null;
            $this->self     = isset($payload["self"])     && isset($payload["self"]["href"])     ? $payload["self"]["href"]     : null;
            $this->statuses = isset($payload["statuses"]) && isset($payload["statuses"]["href"]) ? $payload["statuses"]["href"] : null;

            $this->validateConstruction();
        }

    }
