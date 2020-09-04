<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\EnergySupplier;

use App\Domain\EnergySupplier\EnergySupplier;
use App\Domain\EnergySupplier\EnergySupplierRepository;
use App\Infrastructure\Driver\DatabaseDriver;

class InMemEnergySupplierRepository implements EnergySupplierRepository {

    /**
     * @var DatabaseDriver
     */
    private $databaseDriver;

    /**
     * @var EnergySupplier[]
     */
    private $suppliers;

    public function __construct(DatabaseDriver $databaseDriver)
    {
        $this->databaseDriver = $databaseDriver;
        $this->suppliers = $this->databaseDriver->fetchAll(EnergySupplier::class);
    }

    /**
     * @return EnergySupplier[]|array
     */
    public function findAll(){

        return $this->suppliers;
    }

}