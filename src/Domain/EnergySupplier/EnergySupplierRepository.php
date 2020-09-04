<?php
declare(strict_types=1);

namespace App\Domain\EnergySupplier;

interface EnergySupplierRepository {

    /**
     * @return EnergySupplier[]
     */
    public function findAll();

}