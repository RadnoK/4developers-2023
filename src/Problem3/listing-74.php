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
    ) { }

    public function hasChanged(): bool
    {
        return $this->orderChanges->hasChanges();
    }
}

final readonly class OrderPromotionProcessor {
    public function applyPromotion(Order $order, Promotion $promotion): ProcessingResult {
        $changes = new ProcessingDiff(
            originalTotal: $order->getTotal(),
        );

        $order->subtractFromTotal($promotion->getValue());

        $changes->newTotal = $order->getTotal();

        return new ProcessingResult(
            processedOrder: $order,
            orderChanges: $changes,
        );
    }
}

$order = new Order();
$promotion = new Promotion();

$orderPromotionProcessor = new OrderPromotionProcessor();

$result = $orderPromotionProcessor->applyPromotion($order, $promotion);
var_dump($result->hasChanged()); // [true]
