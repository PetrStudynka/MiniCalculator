<?php
declare(strict_types=1);

namespace App\Domain\SupplierOffer;

use App\Domain\Commodity\CommodityInterface;
use App\Infrastructure\ValueObject\Interval;
use JsonSerializable;

abstract class Offer implements \JsonSerializable
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var float
     */
    protected $price;

    /**
     * @var float
     */
    protected $pdtCharge;

    /**
     * @var Interval;
     */
    protected $consumptionInterval;

    /**
     * @var CommodityInterface;
     */
    protected $commodity = '';

    /**
     * Offer constructor.
     * @param string $id
     * @param float $minConsumption
     * @param float $maxConsumption
     * @param float $price
     * @param float $pdtCharge
     */
    public function __construct(string $id, float $minConsumption, float $maxConsumption, float $price, float $pdtCharge)
    {
        $this->id = $id;
        $this->pdtCharge = $pdtCharge;
        $this->price = $price;
        $this->consumptionInterval = new Interval($minConsumption, $maxConsumption);
    }

    /**
     * @param float $consumption
     * @return bool
     */
    public function isInConsumptionRange(float $consumption): bool
    {
        return $this->consumptionInterval->containsValue($consumption, true);
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @return mixed
     */
    public function getCommodityName(){
        
        return $this->commodity->getName();
    }

    /**
     * @return float
     */
    public function getPdtCharge(): float
    {
        return $this->pdtCharge;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'pdt' => $this->pdtCharge,
            'price' => $this->price,
            'total_cost' => round($this->getPrice(),2,PHP_ROUND_HALF_UP),
        ];
    }

}