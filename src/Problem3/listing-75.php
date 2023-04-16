<?php

class Order {
    private int $total = 100;

    public function subtractFromTotal(int $value): void {
        $this->total -= $value;
    }

    public function getTotal(): int {
        return $this->total;
    }
}

class Promotion {
    public function getValue(): int {
        return 10;
    }
}

final class ProcessingErrors {
    private array $errors = [];

    public function add(string $exceptionName): void {
        $this->errors[] = $exceptionName;
    }
}

final class ProcessingDiff {
    public int $newTotal;

    public function __construct(
        public readonly int $originalTotal,
    ) { }

    public function hasChanges(): bool {
        return $this->newTotal !== $this->originalTotal;
    }
}

final readonly class ProcessingResult {
    public function __construct(
        public Order $processedOrder,
        public ProcessingDiff $orderChanges,
        public ProcessingErrors $errors,
    ) { }

    public function hasChanged(): bool
    {
        return $this->orderChanges->hasChanges();
    }
}

class PromotionBelowZeroException extends \Exception { }

final readonly class OrderPromotionProcessor {
    public function applyPromotion(Order $order, Promotion $promotion): ProcessingResult {
        $errors = new ProcessingErrors();
        $changes = new ProcessingDiff(
            originalTotal: $order->getTotal(),
        );

        try {
            $order->subtractFromTotal($promotion->getValue());
        } catch (PromotionBelowZeroException $exception) {
            $errors->add(PromotionBelowZeroException::class);
        }

        $changes->newTotal = $order->getTotal();

        return new ProcessingResult(
            processedOrder: $order,
            orderChanges: $changes,
            errors: $errors,
        );
    }
}

$order = new Order();
$promotion = new Promotion();

$orderPromotionProcessor = new OrderPromotionProcessor();

$result = $orderPromotionProcessor->applyPromotion($order, $promotion);
var_dump($result->hasChanged()); // [true]
