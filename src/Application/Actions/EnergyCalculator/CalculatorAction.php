<?php
declare(strict_types=1);

namespace App\Application\Actions\EnergyCalculator;

use App\Application\Actions\Action;
use App\Domain\EnergySupplier\EnergySupplierRepository;
use App\Infrastructure\Persistence\EnergySupplier\InMemEnergySupplierRepository;
use Psr\Log\LoggerInterface;

abstract class CalculatorAction extends Action
{
    /**
     * @var EnergySupplierRepository
     */
    protected $supplierRepository;

    /**
     * @param LoggerInterface $logger
     * @param InMemEnergySupplierRepository $supplierRepository
     */
    public function __construct(LoggerInterface $logger, InMemEnergySupplierRepository $supplierRepository)
    {
        parent::__construct($logger);
        $this->supplierRepository = $supplierRepository;
    }
}
