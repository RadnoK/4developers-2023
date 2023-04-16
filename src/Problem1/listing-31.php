<?php

enum QueueType {
    case ASYNC;
    case SYNC;
}

enum ServiceStatus {
    case ENABLED;
    case DISABLED;
}

final readonly class SystemId {
    public function __construct(
        public string $id,
    ) { }
}

final readonly class StorageService {
    public function __construct(
        public string $name,
        public string $bucket,
        public ServiceStatus $status,
    ) { }

    public function isEnabled(): bool
    {
        return $this->status === ServiceStatus::ENABLED;
    }
}

final readonly class StorageServices {
    /** @var iterable|StorageService[] */
    public iterable $storages;

    public function __construct(StorageService ...$storages) {
        $this->storages = $storages;
    }
}

final readonly class QueueService {
    public function __construct(
        public string $id,
        public QueueType $type,
        public ServiceStatus $status,
    ) { }
}

final readonly class QueueServices {
    /** @var iterable|QueueService[] */
    public iterable $queues;

    public function __construct(QueueService ...$queues) {
        $this->queues = $queues;
    }
}

final readonly class Services {
    public function __construct(
        public StorageServices $storage,
        public QueueServices $queue,
    ) { }
}

final readonly class SystemConfiguration {
    public function __construct(
        public SystemId $systemId,
        public Services $services,
    ) { }
}

$config = new SystemConfiguration(
    systemId: new SystemId('super-secret-value'),
    services: new Services(
        storage: new StorageServices(
            new StorageService(
                name: 's3_bucket',
                bucket: 'bucket-for-bits',
                status: ServiceStatus::ENABLED,
            ),
        ),
        queue: new QueueServices(
            new QueueService(
                id: 'game_points_wallet',
                type: QueueType::ASYNC,
                status: ServiceStatus::ENABLED,
            ),
        ),
    ),
);

foreach ($config->services->storage->storages as $storage) {
    if (!$storage->isEnabled()) {
        continue;
    }

    $this->setupBucket($storage->name, $storage->bucket);
}
