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

namespace Sulu\Bundle\SyliusConsumerBundle\Tests\Functional\Mocks;

use Sulu\Bundle\MediaBundle\Media\Storage\StorageInterface;

class Storage implements StorageInterface
{
    /**
     * @var StorageInterface|null
     */
    private $mock;

    public function getMock(): StorageInterface
    {
        if (!$this->mock) {
            throw new \RuntimeException('The mock needs to be set on the container to be used');
        }

        return $this->mock;
    }

    public function setMock(StorageInterface $mock): self
    {
        $this->mock = $mock;

        return $this;
    }

    public function save(string $tempPath, string $fileName, array $storageOptions = []): array
    {
        return $this->mock->save($tempPath, $fileName, $storageOptions);
    }

    public function load(array $storageOptions)
    {
        return $this->mock->load($storageOptions);
    }

    public function getPath(array $storageOptions): string
    {
        return $this->mock->getPath($storageOptions);
    }

    public function getType(array $storageOptions): string
    {
        return $this->mock->getType($storageOptions);
    }

    public function move(array $sourceStorageOptions, array $targetStorageOptions): array
    {
        return $this->mock->move($sourceStorageOptions, $targetStorageOptions);
    }

    public function remove(array $storageOptions): void
    {
        $this->mock->remove($storageOptions);
    }
}
