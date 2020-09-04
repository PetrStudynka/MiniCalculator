<?php
declare(strict_types=1);

namespace App\Domain\EnergySupplier;

use App\Domain\SupplierOffer\Offer;
use App\Domain\Dto\EnergyOfferDto;
use App\Domain\SupplierOffer\OfferPriceCalculator;

class EnergySupplier
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * associative array of supplierOffers, with Commodity name key
     * @var []SupplierOffers
     */
    private $supplierOffers;

    /**
     * @var string[]
     */
    private $offeredCommodities = [];

    public function __construct(string $id, string $name, Offer ...$supplierOffer){
        $this->id = $id;
        $this->name = $name;
        $this->supplierOffers = [];

        foreach ($supplierOffer as $offer){

            $commodityName = $offer->getCommodityName();

            $this->supplierOffers[$commodityName][] = $offer;

            if(!in_array($commodityName,$this->offeredCommodities)){
                $this->offeredCommodities[] = $commodityName;
            }

        }

    }

    /**
     * @param string $commodityName
     * @param float $consumptionValue
     * @return EnergyOfferDto|null
     */

    public function getRelevantOffers(string $commodityName, float $consumptionValue)
    {

        $relevantOffers = $this->supplierOffers[$commodityName];

        if(empty($relevantOffers))
            return null;


        foreach($relevantOffers as $offer)
        {

            if($offer->isInConsumptionRange($consumptionValue))
            {
                $offerPrice = strval(round(OfferPriceCalculator::getAnnualTotalOfferPrice($consumptionValue,$offer->getPrice(),$offer->getPdtCharge()),2));

                $pdtCharge = strval($offer->getPdtCharge());
                $price = strval($offer->getPrice());
                $commodityName = $offer->getCommodityName();

                $dto = new EnergyOfferDto($commodityName,$offerPrice,$price,$pdtCharge,$this->getName());

                return $dto;
            }
        }

        return null;
    }

    public function getOfferPrice(float $consumption, float $price, float $pdtCharge){

        return $pdtCharge * 12 + $price * $consumption;

    }


    public function getName(): string
    {

        return $this->name;
    }

    /**
     * @return string[]
     */
    public function getCommodityNames(): array
    {
        return $this->offeredCommodities;
    }
}