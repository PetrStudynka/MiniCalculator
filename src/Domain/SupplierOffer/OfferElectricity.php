<?php
declare(strict_types=1);

namespace App\Domain\SupplierOffer;

use App\Domain\Commodity\Electricity;


class OfferElectricity extends Offer
 {
    public function __construct()
    {
        parent::__construct(...func_get_args());
        $this->commodity = new Electricity();
    }
 }