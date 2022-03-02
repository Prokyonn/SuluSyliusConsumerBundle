# Image Adapter

The Image Adapter is used to synchronize the images from sylius to sulu.

## Built in Adapter

The bundle has a default built in adapter to synchronize the images to media entities.
The adapter downloads the image from the sylius system and creates the media entity.
By default this adapter is disabled.

To enable it use following configuration:

```yaml
sulu_sylius_consumer:
    image_media_adapter:
        enabled: true
```

Furthermore the adapter needs a system collection to save the medias. The following configuration 
shows how to set the `collectionKey`.

```yaml
image_media_adapter:
    enabled: true
    media_collection_key: product_images
```

The `SuluSystemCollection` can automatically be created with this configuratino:

```yaml
sulu_media:
    system_collections:
        product_images:
            meta_title:
                en: 'Product Images'
                de: 'Produkt Bilder'
                fr: 'Images de produits'
```
More information about the system collections can be found [here](https://docs.sulu.io/en/2.4/cookbook/system-collections.html)

## Custom Adapter

If you want to add your custom adapter to e.g. set relations from the synchronized media entities to your custom entityyou can add your own 
adapter.

```php
<?php

namespace App\Adapter;

use Sulu\Bundle\SyliusConsumerBundle\Adapter\ImageAdapterInterface;
use Sulu\Bundle\SyliusConsumerBundle\Payload\ImagePayload;

class CustomImageAdapter implements ImageAdapterInterface
{
    public function synchronize(ImagePayload $payload): void
    {
        ...
    }

    public function remove(int $id): void
    {
        ...
    }
}
```

If you have activated the autoconfiguration for your services it should already work. Else you have to add the tag 
`sulu_sylius_consumer.adapter.taxon` to your service definition.

```yaml
services:
    App\Adapter\CustomImageAdapter:
        tags:
            - 'sulu_sylius_consumer.adapter.image'
```
