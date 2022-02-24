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

namespace Sulu\Bundle\SyliusConsumerBundle\Repository;

use Sulu\Bundle\MediaBundle\Entity\MediaInterface;
use Sulu\Bundle\SyliusConsumerBundle\Entity\ImageMediaBridgeInterface;
use Sulu\Component\Persistence\Repository\ORM\EntityRepository;

class ImageMediaBridgeRepository extends EntityRepository implements ImageMediaBridgeRepositoryInterface
{
    public function create(int $imageId, MediaInterface $media): ImageMediaBridgeInterface
    {
        $className = $this->getClassName();

        return new $className($imageId, $media);
    }

    public function add(ImageMediaBridgeInterface $bridge): void
    {
        $this->getEntityManager()->persist($bridge);
    }

    public function findById(int $imageId): ?ImageMediaBridgeInterface
    {
        return $this->find($imageId);
    }

    public function removeById(int $imageId): void
    {
        $this->getEntityManager()->remove($this->findById($imageId));
    }
}
