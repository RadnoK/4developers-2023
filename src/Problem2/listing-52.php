<?php

final class User {}

final readonly class Location {
    public function __construct(
        public string $name,
        public float $lat,
        public float $lng,
        public Visits $visits,
    ) { }
}

final readonly class Visit {
    public function __construct(
        public User $user,
        public \DateTimeImmutable $time,
    ) { }
}

final readonly class Locations implements \IteratorAggregate {
    public function __construct(
        private array $items,
    ) { }

    public static function create(Location ...$locations): self {
        return new self($locations);
    }

    public function getIterator(): Traversable {
        return new \ArrayIterator($this->items);
    }
}

final readonly class Visits implements \IteratorAggregate {
    public function __construct(
        private array $items,
    ) { }

    public static function create(Visit ...$visits): self {
        return new self($visits);
    }

    public static function createEmpty(): self {
        return new self([]);
    }

    public function getIterator(): Traversable {
        return new \ArrayIterator($this->items);
    }
}

$locations = Locations::create(
    new Location(
        name: 'home',
        lat: 37.23947543321564,
        lng: -115.81207965194125,
        visits: Visits::create(
            new Visit(
                user: new User(),
                time: new \DateTimeImmutable(),
            ),
        ),
    ),
    new Location(
        name: 'work',
        lat: 40.75214226756891,
        lng: -73.99334672581234,
        visits: Visits::createEmpty(),
    ),
);

foreach ($locations as $location) {
    var_dump($location);
}
