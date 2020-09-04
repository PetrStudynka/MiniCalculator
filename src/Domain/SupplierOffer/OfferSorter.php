<?php
declare(strict_types=1);

namespace App\Domain\SupplierOffer;

use App\Domain\Dto\EnergyOfferDto;

class OfferSorter
{
    /**
     * returns sorted array of Offers by price
     * @param Offer[] $offers
     * @return Offer[]
     */
    public function sortOffersByTotalPrice(array $offers)
    {
        if(count($offers) > 0)
        usort($offers, array(self::class,'sortOffers'));

            return $offers;
    }

    //floats must be same precision!
    private function sortOffers(EnergyOfferDto $a, EnergyOfferDto $b)
    {
        return strnatcmp(strval($a->getTotalPrice()), strval($b->getTotalPrice()));
    }


}