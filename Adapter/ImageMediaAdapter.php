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

namespace Sulu\Bundle\SyliusConsumerBundle\Adapter;

use Doctrine\ORM\EntityManagerInterface;
use Sulu\Bundle\MediaBundle\Entity\Collection;
use Sulu\Bundle\MediaBundle\Entity\File;
use Sulu\Bundle\MediaBundle\Entity\FileVersion;
use Sulu\Bundle\MediaBundle\Entity\FileVersionMeta;
use Sulu\Bundle\MediaBundle\Entity\Media;
use Sulu\Bundle\MediaBundle\Entity\MediaInterface;
use Sulu\Bundle\MediaBundle\Entity\MediaType;
use Sulu\Bundle\MediaBundle\Media\Storage\StorageInterface;
use Sulu\Bundle\SyliusConsumerBundle\Exception\ImageDownloadFailedException;
use Sulu\Bundle\SyliusConsumerBundle\Payload\ImagePayload;
use Sulu\Bundle\SyliusConsumerBundle\Repository\ImageMediaBridgeRepositoryInterface;
use Sulu\Component\Media\SystemCollections\SystemCollectionManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ImageMediaAdapter implements ImageAdapterInterface
{
    private const IMAGE_MEDIA_TYPE = 2;

    /**
     * @var ImageMediaBridgeRepositoryInterface
     */
    private $mediaBridgeRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    /**
     * @var StorageInterface
     */
    private $storage;

    /**
     * @var SystemCollectionManagerInterface
     */
    private $systemCollectionManager;

    /**
     * @var string
     */
    private $syliusBaseUrl;

    /**
     * @var string
     */
    private $collectionKey;

    public function __construct(
        ImageMediaBridgeRepositoryInterface $mediaBridgeRepository,
        EntityManagerInterface $entityManager,
        HttpClientInterface $client,
        StorageInterface $storage,
        SystemCollectionManagerInterface $systemCollectionManager,
        string $syliusBaseUrl,
        string $collectionKey
    ) {
        $this->mediaBridgeRepository = $mediaBridgeRepository;
        $this->entityManager = $entityManager;
        $this->syliusBaseUrl = $syliusBaseUrl;
        $this->httpClient = $client;
        $this->storage = $storage;
        $this->systemCollectionManager = $systemCollectionManager;
        $this->collectionKey = $collectionKey;
    }

    public function synchronize(ImagePayload $payload): void
    {
        $this->handlePayload($payload);

        // Needed to use medias in other adapters
        $this->entityManager->flush();
    }

    public function remove(int $id): void
    {
        $this->mediaBridgeRepository->removeById($id);
    }

    private function handlePayload(ImagePayload $payload): void
    {
        $bridge = $this->mediaBridgeRepository->findById($payload->getId());
        if (!$bridge) {
            $media = new Media();
            $bridge = $this->mediaBridgeRepository->create($payload->getId(), $media);
            $this->mediaBridgeRepository->add($bridge);
        }

        $media = $bridge->getMedia();
        $uploadedFile = $this->downloadImage($payload);
        $this->updateMedia($media, $uploadedFile, $payload->getLocale());
    }

    private function updateMedia(MediaInterface $media, UploadedFile $uploadedFile, string $locale): MediaInterface
    {
        $latestFileVersion = null;
        if ($media->getFiles()->count() > 0) {
            $latestFile = $media->getFiles()->last();
            $latestFileVersion = $latestFile->getLatestFileVersion();

            if ($latestFileVersion && $latestFileVersion->getSize() === $uploadedFile->getSize()) {
                // same image, not necessary to update anything
                return $media;
            }
        }

        $storageOptions = $this->storage->save(
            $uploadedFile->getPathname(),
            $uploadedFile->getFilename()
        );

        $file = new File();
        $file->setVersion($latestFileVersion ? $latestFileVersion->getVersion() + 1 : 1)
            ->setMedia($media);

        $media->addFile($file)
            ->setType($this->getImageMediaType())
            ->setCollection($this->getCollection());

        $fileVersion = new FileVersion();
        $fileVersion->setVersion($file->getVersion())
            ->setSize($uploadedFile->getSize())
            ->setName($uploadedFile->getFilename())
            ->setStorageOptions($storageOptions)
            ->setMimeType($uploadedFile->getMimeType() ?: 'image/jpeg')
            ->setFile($file);

        $file->addFileVersion($fileVersion);

        $fileVersionMeta = new FileVersionMeta();
        $fileVersionMeta->setTitle($uploadedFile->getFilename())
            ->setLocale($locale)
            ->setFileVersion($fileVersion);

        $fileVersion->addMeta($fileVersionMeta)
            ->setDefaultMeta($fileVersionMeta);

        $this->entityManager->persist($fileVersionMeta);
        $this->entityManager->persist($fileVersion);
        $this->entityManager->persist($media);

        return $media;
    }

    private function downloadImage(ImagePayload $payload): UploadedFile
    {
        $url =
            rtrim($this->syliusBaseUrl, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR .
            'media' . DIRECTORY_SEPARATOR . 'image' . DIRECTORY_SEPARATOR . $payload->getPath();
        $urlParts = pathinfo($url);
        $filename = $urlParts['filename'] . '.' . ($urlParts['extension'] ?? '');
        $imagePath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $filename;

        $response = $this->httpClient->request('GET', $url);
        if (Response::HTTP_OK !== $response->getStatusCode()) {
            throw new ImageDownloadFailedException($url);
        }
        $fileHandler = fopen($imagePath, 'wb');
        foreach ($this->httpClient->stream($response) as $chunk) {
            fwrite($fileHandler, $chunk->getContent());
        }

        return new UploadedFile($imagePath, $filename);
    }

    private function getImageMediaType(): MediaType
    {
        $mediaType = $this->entityManager->getRepository(MediaType::class)->find(self::IMAGE_MEDIA_TYPE);
        if (!$mediaType instanceof MediaType) {
            throw new \RuntimeException(\sprintf('MediaType "%s" not found. Have you loaded the Sulu fixtures?', self::IMAGE_MEDIA_TYPE));
        }

        return $mediaType;
    }

    private function getCollection(): Collection
    {
        $collectionId = $this->systemCollectionManager->getSystemCollection($this->collectionKey);

        return $this->entityManager->find(Collection::class, $collectionId);
    }
}
