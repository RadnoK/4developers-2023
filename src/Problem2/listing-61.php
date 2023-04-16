<?php

class User { }

final readonly class Users {
    private iterable $users;

    public function __construct(
        User ...$users,
    ) {
        $this->users = $users;
    }

    public function isEmpty(): bool {
        return \count($this->users) === 0;
    }
}

final class InMemoryUserRepository {
    /** @var array|User[] */
    private array $users = [];

    public function store(User $user): void {
        $this->users[] = $user;
    }

    public function findAll(): Users {
        return new Users(...$this->users);
    }
}



$repository = new InMemoryUserRepository();
$repository->store(new User());
var_dump($repository->findAll());
var_dump($repository->findAll()->isEmpty());
