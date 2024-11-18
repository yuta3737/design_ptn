<?php

// if-else や switch 文を使った複雑な条件分岐が不要

// Strategy インターフェース
interface DiscountStrategy {
    public function calculate(int $price): int;
}

// ConcreteStrategy: 通常会員の割引戦略
class RegularMemberDiscount implements DiscountStrategy {
    public function calculate(int $price): int {
        return $price; // 割引なし
    }
}

// ConcreteStrategy: プレミアム会員の割引戦略
class PremiumMemberDiscount implements DiscountStrategy {
    public function calculate(int $price): int {
        return (int)($price * 0.8); // 20% 割引
    }
}

// ConcreteStrategy: VIP会員の割引戦略
class VIPMemberDiscount implements DiscountStrategy {
    public function calculate(int $price): int {
        return (int)($price * 0.7); // 30% 割引
    }
}

// Context クラス
class PriceCalculator {
    private DiscountStrategy $strategy;

    // コンストラクタで初期の戦略を設定
    public function __construct(DiscountStrategy $strategy) {
        $this->strategy = $strategy;
    }

    // 戦略を動的に変更
    public function setStrategy(DiscountStrategy $strategy): void {
        $this->strategy = $strategy;
    }

    // 現在の戦略に基づいて料金を計算
    public function calculatePrice(int $price): int {
        return $this->strategy->calculate($price);
    }
}

// ===== 使用例 =====
$price = 1000;

// 通常会員
$calculator = new PriceCalculator(new RegularMemberDiscount());
echo "通常会員の料金: " . $calculator->calculatePrice($price) . PHP_EOL;

// プレミアム会員
$calculator->setStrategy(new PremiumMemberDiscount());
echo "プレミアム会員の料金: " . $calculator->calculatePrice($price) . PHP_EOL;

// VIP会員
$calculator->setStrategy(new VIPMemberDiscount());
echo "VIP会員の料金: " . $calculator->calculatePrice($price) . PHP_EOL;