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

class OrderPromotionProcessor {
    private array $changes = [];

    public function applyPromotion(Order $order, Promotion $promotion): Order {
        $originalOrderTotal = $order->getTotal();

        $order->subtractFromTotal($promotion->getValue());

        if ($originalOrderTotal !== $order->getTotal()) {
            $this->changes['total'] = [
                'old' => $originalOrderTotal,
                'new' => $order->getTotal(),
            ];
        }

        return $order;
    }

    public function getChanges(): array {
        return $this->changes;
    }
}

$order = new Order();
$promotion = new Promotion();

$orderPromotionProcessor = new OrderPromotionProcessor();
$orderPromotionProcessor->applyPromotion($order, $promotion);
var_dump($orderPromotionProcessor->getChanges()); // ['old' => 100, 'new' => 90]
