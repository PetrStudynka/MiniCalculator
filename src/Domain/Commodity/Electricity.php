<?php
declare(strict_types=1);

namespace App\Domain\Commodity;

class Electricity implements CommodityInterface {

    private $uuid = 'electricity';

    public function getName()
    {

        return $this->uuid;
    }
}