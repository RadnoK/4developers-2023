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
    public function applyPromotion(Order $order, Promotion $promotion): Order {
        $order->subtractFromTotal($promotion->getValue());

        return $order;
    }
}
