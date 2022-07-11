<?php

namespace Leven\DBA\Common\BuilderPart;

trait WhereTrait
{

    /* @var WhereCondition[] $conditions */
    protected array $conditions = [];


    public function andWhere(
        string|callable $columnOrGroup,
        mixed $valueOrOperand = new DefaultValue,
        mixed $value = new DefaultValue,
    ): static
    {
        return $this->whereGeneric(false, $columnOrGroup, $valueOrOperand, $value);
    }

    public function orWhere(
        string|callable $columnOrGroup,
        mixed $valueOrOperand = new DefaultValue,
        mixed $value = new DefaultValue,
    ): static
    {
        return $this->whereGeneric(true, $columnOrGroup, $valueOrOperand, $value);
    }

    public function where(
        string|callable $columnOrGroup,
        mixed $valueOrOperand = new DefaultValue,
        mixed $value = new DefaultValue,
    ): static
    {
        return $this->andWhere($columnOrGroup, $valueOrOperand, $value);
    }


    protected function whereGeneric(
        bool $isOr,
        string|callable $columnOrGroup,
        mixed $valueOrOperand = new DefaultValue,
        mixed $value = new DefaultValue,
        // array types because we need to allow use of null values
    ): static
    {
        if(is_callable($columnOrGroup)){
            $conditionBuilder = new WhereGroup($isOr);
            $columnOrGroup($conditionBuilder);
            $this->conditions[] = $conditionBuilder;
        }else{
            $this->conditions[] = $value instanceof DefaultValue ?
                new WhereCondition($isOr, $columnOrGroup, $valueOrOperand) :
                new WhereCondition($isOr, $columnOrGroup, $value, $valueOrOperand);
        }
        return $this;
    }

}