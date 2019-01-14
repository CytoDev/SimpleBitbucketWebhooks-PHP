<?php

    namespace cytodev\integration\bitbucket\webhooks\entities;

    use \ReflectionException;
    use \LogicException;

    use cytodev\integration\bitbucket\webhooks\autological\Entity;

    /**
     * <h1>Class PullRequestEntity</h1>
     *   This entity is subject to change whenever Atlassian feels like changing their request payloads
     *
     * @package cytodev\integration\bitbucket\webhooks\entities
     *
     * @method int                     getId
     * @method string                  getTitle
     * @method string                  getDescription
     * @method int                     getState
     * @method string                  getAuthor
     * @method PullRequestBranchEntity getSource
     * @method PullRequestBranchEntity getDestination
     * @method string                  getMergeCommit
     * @method array                   getParticipants
     * @method array                   getReviewers
     * @method bool                    getCloseSourceBranch
     * @method string                  getClosedBy
     * @method string                  getDeclineReason
     * @method int                     getCreated
     * @method int                     getUpdated
     * @method LinksEntity             getLinks
     */
    final class PullRequestEntity extends Entity {

        const STATE_OPEN     = 0;
        const STATE_MERGED   = 1;
        const STATE_DECLINED = 2;

        /**
         * @var int
         */
        protected $id;

        /**
         * @var string
         */
        protected $title;

        /**
         * @var string
         */
        protected $description;

        /**
         * @var int
         */
        protected $state;

        /**
         * @var string
         */
        protected $author;

        /**
         * @var PullRequestBranchEntity
         */
        protected $source;

        /**
         * @var PullRequestBranchEntity
         */
        protected $destination;

        /**
         * @var string|null
         */
        protected $mergeCommit = null;

        /**
         * @var array
         */
        protected $participants;

        /**
         * @var array
         */
        protected $reviewers;

        /**
         * @var bool
         */
        protected $closeSourceBranch;

        /**
         * @var string|null
         */
        protected $closedBy = null;

        /**
         * @var string|null
         */
        protected $declineReason = null;

        /**
         * @var int
         */
        protected $created;

        /**
         * @var int
         */
        protected $updated;

        /**
         * @var LinksEntity
         */
        protected $links;

        /**
         * <h2>PullRequestEntity constructor.</h2>
         *
         * @param array $payload The payload as sent by Bitbucket [Defaults: empty]
         *
         * @throws ReflectionException When ReflectionClass cannot find the calling class
         * @throws LogicException      When a private field has no default and is not set by Bitbucket's payload
         */
        public function __construct(array $payload = []) {
            $this->source       = isset($payload["source"])      && is_array($payload["source"])      ? new PullRequestBranchEntity($payload["source"])      : null;
            $this->destination  = isset($payload["destination"]) && is_array($payload["destination"]) ? new PullRequestBranchEntity($payload["destination"]) : null;
            $this->links        = isset($payload["links"])       && is_array($payload["links"])       ? new LinksEntity($payload["links"])                   : null;

            $this->id = isset($payload["id"]) ? filter_var($payload["id"], FILTER_VALIDATE_INT) : null;

            $this->title         = isset($payload["title"])         ? $payload["title"]         : null;
            $this->description   = isset($payload["description"])   ? $payload["description"]   : null;
            $this->author        = isset($payload["author"])        ? $payload["author"]        : null;
            $this->closedBy      = isset($payload["closedBy"])      ? $payload["closedBy"]      : null;
            $this->declineReason = isset($payload["declineReason"]) ? $payload["declineReason"] : null;

            $this->closeSourceBranch = isset($payload["closeSourceBranch"]) ? filter_var($payload["closeSourceBranch"], FILTER_VALIDATE_BOOLEAN) : null;

            $this->reviewers    = isset($payload["reviewers"])    && is_array($payload["reviewers"])    ? $payload["reviewers"]    : [];
            $this->participants = isset($payload["participants"]) && is_array($payload["participants"]) ? $payload["participants"] : [];

            $this->mergeCommit  = isset($payload["mergeCommit"]) && isset($payload["mergeCommit"]["hash"]) ? $payload["mergeCommit"]["hash"] : null;

            $this->created = isset($payload["created"]) ? strtotime($payload["created"]) : null;
            $this->updated = isset($payload["updated"]) ? strtotime($payload["updated"]) : null;

            if(isset($payload["state"])) {
                switch($payload["state"]) {
                    case "OPEN":
                        $this->state = self::STATE_OPEN;
                        break;
                    case "MERGED":
                        $this->state = self::STATE_MERGED;
                        break;
                    case "DECLINED":
                        $this->state = self::STATE_DECLINED;
                        break;
                    default:
                        $this->state = null;
                }
            }

            $this->validateConstruction();
        }

    }
