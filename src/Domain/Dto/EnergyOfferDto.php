<?php
declare(strict_types=1);

namespace App\Domain\Dto;

use JsonSerializable;

class EnergyOfferDto implements JsonSerializable {

    /**
     * @var string
     */
    private $commodityName;

    /**
     * @var string
     */
    private $price;

    /**
     * @var string
     */
    private $pdt;

    /**
     * @var string
     */
    private $supplierName;

    /**
     * @var string
     */
    private $totalPrice;

    /**
     * EnergyOfferDto constructor.
     * @param string $commodityName
     * @param string $totalPrice
     * @param string $price
     * @param string $pdt
     * @param string $supplierName
     */
    public function __construct(string $commodityName,string $totalPrice, string $price, string $pdt, string $supplierName)
    {
        $this->totalPrice = $totalPrice;
        $this->commodityName = $commodityName;
        $this->price = $price;
        $this->pdt = $pdt;
        $this->supplierName = $supplierName;
    }

    /**
     * @return string
     */
    public function getCommodityName(): string
    {
        return $this->commodityName;
    }

    /**
     * @return string
     */
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    /**
     * @return string
     */
    public function getPrice(): string
    {
        return $this->price;
    }

    /**
     * @return string
     */
    public function getPdt(): string
    {
        return $this->pdt;
    }

    /**
     * @return string
     */
    public function getSupplierName(): string
    {
        return $this->supplierName;
    }


    public function jsonSerialize()
    {
        return [
            'commodity' => $this->commodityName,
            'pdt' => $this->prettyParsePrice($this->pdt),
            'price' => $this->prettyParsePrice($this->price),
            'supplier' => $this->supplierName,
            'total_cost' => $this->prettyParsePrice($this->totalPrice),
        ];
    }

    //todo move
    public function prettyParsePrice(string $value,int $decimalCount = 2){

        return strval(number_format(floatval($value),$decimalCount,',', ' '));
    }



}