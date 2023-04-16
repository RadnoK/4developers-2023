<?php

final class User {}

final readonly class Location {
    public function __construct(
        public string $name,
        public float $lat,
        public float $lng,
        public array $visits,
    ) { }
}

final readonly class Visit {
    public function __construct(
        public User $user,
        public \DateTimeImmutable $time,
    ) { }
}

$locations = [
    new Location(
        name: 'home',
        lat: 37.23947543321564,
        lng: -115.81207965194125,
        visits: [
            new Visit(
                user: new User(),
                time: new \DateTimeImmutable(),
            ),
        ],
    ),
    new Location(
        name: 'work',
        lat: 40.75214226756891,
        lng: -73.99334672581234,
        visits: [],
    ),
];


var_dump($locations);
