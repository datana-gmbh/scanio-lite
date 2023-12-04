<?php

declare(strict_types=1);

namespace App\Workflow;

use App\EntityInterface;
use Symfony\Component\Workflow\Registry;
use Webmozart\Assert\Assert;

final readonly class WorkflowExtractor
{
    public function __construct(
        private Registry $workflowRegistry,
    ) {
    }

    /**
     * @return array<string, bool|string>
     */
    public function getPlaceMetadataValueByPlace(EntityInterface $entity, string $place): array
    {
        $workflow = $this->workflowRegistry->get($entity);

        return $workflow->getMetadataStore()->getPlaceMetadata($place);
    }

    /**
     * @return array<string, bool|string>
     */
    public function getTargetPlaceMetadataValueByTransitionName(EntityInterface $entity, string $transition): array
    {
        $targetPlace = $this->getTargetPlaceNameByTransitionName($entity, $transition);

        return $this->getPlaceMetadataValueByPlace($entity, $targetPlace);
    }

    public function getTargetPlaceNameByTransitionName(EntityInterface $entity, string $transitionName): string
    {
        $workflow = $this->workflowRegistry->get($entity);

        foreach ($workflow->getDefinition()->getTransitions() as $transition) {
            if ($transition->getName() === $transitionName) {
                Assert::keyExists($transition->getTos(), 0);

                return $transition->getTos()[0];
            }
        }

        throw new \RuntimeException('No place found');
    }

    /**
     * @param string[] $excludeTransitions
     *
     * @return array<string, string>
     */
    public function getTransitionsByEntityAndStatus(object $entity, string $status, array $excludeTransitions = []): array
    {
        $transitions = [];

        $workflow = $this->workflowRegistry->get($entity);

        foreach ($workflow->getDefinition()->getTransitions() as $transition) {
            if (!\in_array($status, $transition->getFroms(), true)) {
                continue;
            }

            if (0 < \count(array_intersect($transition->getTos(), $excludeTransitions))) {
                continue;
            }

            $transitionMetadata = $workflow->getMetadataStore()->getTransitionMetadata($transition);

            if (!\array_key_exists('label', $transitionMetadata) || null === $transitionMetadata['label']) {
                throw new \InvalidArgumentException(sprintf(
                    'Label in transition metadata must be set for transition %s',
                    $transition->getName(),
                ));
            }

            $transitions[$transitionMetadata['label']] = $transition->getName();
        }

        ksort($transitions);

        return $transitions;
    }
}
