# Upgrade

## 0.x

### Rework synchronization of taxon entities

The `SynchronizeTaxonMessage` as well as the `SynchronizeTaxonMessageHandler` has
been refactored to support the synchronization of multiple independent taxon
entities. Previously only the root node could be synchronized, which resulted
in always synchronizing the complete tree structure.

`Sulu\Bundle\SyliusConsumerBundle\Message\SynchronizeTaxonMessage` renamed to `Sulu\Bundle\SyliusConsumerBundle\Message\SynchronizeTaxonsMessage`
`Sulu\Bundle\SyliusConsumerBundle\Handler\SynchronizeTaxonMessageHandler` renamed to `Sulu\Bundle\SyliusConsumerBundle\Handler\SynchronizeTaxonsMessageHandler`