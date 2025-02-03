<?php

declare(strict_types=1);

/*
 * This file is part of the event_submission project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace Cpsit\EventSubmission\Domain\Model\Dto;

use TYPO3\CMS\Core\Utility\MathUtility;
use TYPO3\CMS\Extbase\Mvc\RequestInterface;

class JobDemandFromRequest
{
    protected array $demandArguments = [];
    protected DemandInterface|null $demand = null;

    public function __construct(
        protected RequestInterface $request
    ) {
        $this->demand = new JobDemand();
        if ($this->request->hasArgument('demand')) {
            $this->demandArguments = $this->request->getArgument('demand');
        }
    }

    public function build(): DemandInterface
    {
        $this->demandStatus();

        return $this->demand;
    }

    protected function demandStatus(): DemandInterface
    {
        // Demand by status
        if (isset($this->demandArguments['status'])) {
            $status = [];
            if (MathUtility::canBeInterpretedAsInteger($this->demandArguments['status'])) {
                $status[] = (int)($this->demandArguments['status']);
            }

            if (is_array($this->demandArguments['status'])) {
                $status = array_map('intval', $this->demandArguments['status']);
            }

            $this->demand->setStatus($status);
        }
        return $this->demand;
    }
}
