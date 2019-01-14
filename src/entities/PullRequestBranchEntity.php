<?php

    namespace cytodev\integration\bitbucket\webhooks\entities;

    use \ReflectionException;
    use \LogicException;

    use cytodev\integration\bitbucket\webhooks\autological\Entity;

    /**
     * <h1>Class PullRequestBranchEntity</h1>
     *   This entity is subject to change whenever Atlassian feels like changing their request payloads
     *
     * @package cytodev\integration\bitbucket\webhooks\entities
     *
     * @method string           getBranch
     * @method string           getCommit
     * @method RepositoryEntity getRepository
     */
    class PullRequestBranchEntity extends Entity {

        /**
         * @var string
         */
        protected $branch;

        /**
         * @var string
         */
        protected $commit;

        /**
         * @var RepositoryEntity
         */
        protected $repository;

        /**
         * <h2>PullRequestBranchEntity constructor.</h2>
         *
         * @param array $payload The payload as sent by Bitbucket [Defaults: empty]
         *
         * @throws ReflectionException When ReflectionClass cannot find the calling class
         * @throws LogicException      When a private field has no default and is not set by Bitbucket's payload
         */
        public function __construct(array $payload = []) {
            $this->repository = isset($payload["repository"]) && is_array($payload["repository"]) ? new RepositoryEntity($payload["repository"]) : null;

            $this->branch = isset($payload["branch"]) && isset($payload["branch"]["name"]) ? $payload["branch"]["name"] : null;
            $this->commit = isset($payload["commit"]) && isset($payload["commit"]["hash"]) ? $payload["commit"]["hash"] : null;

            $this->validateConstruction();
        }

    }
