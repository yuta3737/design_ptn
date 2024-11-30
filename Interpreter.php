<?php

// 1. 式のインターフェース
interface Expression {
    public function interpret(array $context): int;
}

// 2. 数値を表現するクラス
class Number implements Expression {
    private int $value;

    public function __construct(int $value) {
        $this->value = $value;
    }

    public function interpret(array $context): int {
        return $this->value;
    }
}

// 3. 足し算を表現するクラス
class Add implements Expression {
    private Expression $leftOperand;
    private Expression $rightOperand;

    public function __construct(Expression $leftOperand, Expression $rightOperand) {
        $this->leftOperand = $leftOperand;
        $this->rightOperand = $rightOperand;
    }

    public function interpret(array $context): int {
        return $this->leftOperand->interpret($context) + $this->rightOperand->interpret($context);
    }
}

// 4. 引き算を表現するクラス
class Subtract implements Expression {
    private Expression $leftOperand;
    private Expression $rightOperand;

    public function __construct(Expression $leftOperand, Expression $rightOperand) {
        $this->leftOperand = $leftOperand;
        $this->rightOperand = $rightOperand;
    }

    public function interpret(array $context): int {
        return $this->leftOperand->interpret($context) - $this->rightOperand->interpret($context);
    }
}

// 5. 実行例
// (5 + 10) - 3 を表現
$expression = new Subtract(
    new Add(
        new Number(5),
        new Number(10)
    ),
    new Number(3)
);

$result = $expression->interpret([]);
echo "計算結果: $result\n";