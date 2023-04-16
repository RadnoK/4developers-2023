<?php

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class Stone {
    private int $value;

    public function getValue(): int {
        return $this->value;
    }

    public function setValue(int $value): void {
        $this->value = $value;
    }
}

class Dto {
    public function __construct(
        public readonly int $value,
    ) { }
}

final class CreateAction extends AbstractController {
    public function __construct(
        private readonly SerializerInterface $serializer,
    ) { }

    #[Route(path: '/stone', name: 'app_create_stone')]
    public function __invoke(Request $request): Response
    {
        /** @var Dto $payload */
        $payload = $this->serializer->deserialize($request->getContent(), Dto::class, 'json');

        $entity = new Stone();
        $entity->setValue($payload->value);

        // ...

        return $this->json($entity, Response::HTTP_CREATED);
    }
}
