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

namespace Sulu\Bundle\SyliusConsumerBundle\Handler;

use Sulu\Bundle\SyliusConsumerBundle\Adapter\TaxonAdapterInterface;
use Sulu\Bundle\SyliusConsumerBundle\Message\SynchronizeTaxonsMessage;
use Sulu\Bundle\SyliusConsumerBundle\Payload\TaxonPayload;

class SynchronizeTaxonsMessageHandler
{
    /**
     * @var iterable<TaxonAdapterInterface>
     */
    private $taxonAdapters;

    public function __construct(iterable $taxonAdapters)
    {
        $this->taxonAdapters = $taxonAdapters;
    }

    public function __invoke(SynchronizeTaxonsMessage $message): void
    {
        $taxons = $message->getTaxons();

        //ensure the parent taxons are before the children
        usort($taxons, static function (array $a, array $b) {
            return $a['level'] - $b['level'];
        });

        $taxonPayloads = array_map(function (array $taxon) {
            return new TaxonPayload($taxon['id'], $taxon);
        }, $taxons);

        foreach ($taxonPayloads as $taxonPayload) {
            foreach ($this->taxonAdapters as $taxonAdapter) {
                $taxonAdapter->synchronize($taxonPayload);
            }
        }
    }
}
