<?php

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Stone {
    private int $value;

    public function getValue(): int {
        return $this->value;
    }

    public function setValue(int $value): void {
        $this->value = $value;
    }
}

final class CreateAction extends AbstractController {
    #[Route(path: '/stone', name: 'app_create_stone')]
    public function __invoke(Request $request): Response
    {
        $payload = json_decode($request->getContent(), true);

        $entity = new Stone();
        $entity->setValue($payload['value']);

        // ...

        return $this->json($entity, Response::HTTP_CREATED);
    }
}
