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

// 3. 変数を表現するクラス
class Variable implements Expression {
    private string $name;

    public function __construct(string $name) {
        $this->name = $name;
    }

    public function interpret(array $context): int {
        if (!array_key_exists($this->name, $context)) {
            throw new Exception("変数 '{$this->name}' が定義されていません");
        }
        return $context[$this->name];
    }
}

// 4. 足し算を表現するクラス
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

// 5. 引き算を表現するクラス
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

// 6. 実行例
try {
    // 式: (x + 10) - y
    $expression = new Subtract(
        new Add(
            new Variable('x'),
            new Number(10)
        ),
        new Variable('y')
    );

    // 外部状態を提供する
    $context = [
        'x' => 5,  // x = 5
        'y' => 3   // y = 3
    ];

    // 結果を評価
    $result = $expression->interpret($context);
    echo "計算結果: $result\n"; // 出力: 計算結果: 12

} catch (Exception $e) {
    echo "エラー: " . $e->getMessage() . "\n";
}