<?php
declare(strict_types=1);

namespace App\Domain\SupplierOffer;

class OfferPriceCalculator
{

    public static function getAnnualTotalOfferPrice(float $consumption, $price, $pdtCharge){

        return $pdtCharge * 12 + $price * $consumption;

    }

}