<?php
declare(strict_types=1);

namespace App\Domain\Commodity;

class Gas implements CommodityInterface {

    private $name = 'gas';

    public function getName()
    {

        return $this->name;
    }
}