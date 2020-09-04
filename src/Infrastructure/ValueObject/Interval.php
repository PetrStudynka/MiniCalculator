<?php
declare(strict_types=1);

namespace App\Infrastructure\ValueObject;

class Interval {

    /**
     * @var float
     */
    private $min;

    /**
     * @var float
     */
    private $max;

    public function __construct(float $min = 0, float $max = 0)
    {
     $this->min = $min;
     $this->max = $max;   
    }

    public function getMinValue(): float
    {

        return $this->min;
    }

    public function getMaxValue(): float
    {

        return $this->max;
    }

    public function getLength(): float
    {
        
        return $this->max - $this->min;
    }

    public function containsValue(float $number,bool $inclusive = false): bool
    {
        return $inclusive 
            ? ($this->min <= $number && $number <= $this->max)
            :  ($this->min < $number && $number < $this->max);
    }

    public function isEmpty(): bool
    {
        
        return $this->min === $this->max;
    }
}