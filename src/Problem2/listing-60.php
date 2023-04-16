<?php

class User { }

final class InMemoryUserRepository {
    /** @var array|User[] */
    private array $users = [];

    public function findAll(): array {
        return $this->users;
    }
}
