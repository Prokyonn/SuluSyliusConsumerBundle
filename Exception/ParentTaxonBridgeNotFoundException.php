<?php

declare(strict_types=1);

/*
 * This file is part of Sulu.
 *
 * (c) Sulu GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\SyliusConsumerBundle\Exception;

final class ParentTaxonBridgeNotFoundException extends \Exception
{
    public function __construct(string $id)
    {
        parent::__construct(
            \sprintf(
                'The TaxonBridge with the id "%s" was not found. ' .
                'Keep in mind that syncing child categories also requires their parents to be synced.',
                $id
            )
        );
    }
}
