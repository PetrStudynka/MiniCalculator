<?php
declare(strict_types=1);

namespace App\Infrastructure\Driver;

use App\Domain\EnergySupplier\EnergySupplier;
use App\Domain\SupplierOffer\OfferElectricity;
use App\Domain\SupplierOffer\OfferGas;

/** Driver mock
 * Class databaseDriver
 * @package App\Infrastructure\Driver
 */
class DatabaseDriver {


    public function fetchAll(string $className)
    {
        return [

        $firstSupplierEntity = new EnergySupplier('s_first','Nejlevnější energie',
            new OfferElectricity('e_aaa',0,3.9000,1200,100),
            new OfferElectricity('e_bbb',3.9001,20.9999,1000,80),
            new OfferElectricity('e_ccc',21.0000,50.0000,900,70),
            new OfferGas('g_aaa',0,5.9999,900,100),
            new OfferGas('g_bbb',6.0000,25.9999,850,90),
            new OfferGas('g_ccc',26.0000,50.0000,750,80)
            ),

        $secondSupplierEntity = new EnergySupplier('s_second','Šetříme všem',
            new OfferElectricity('e_ddd',0,3.9000,1300,110),
            new OfferElectricity('e_eee',3.9001,20.9999,900,70),
            new OfferElectricity('e_fff',21.0000,50.0000,800,60),
            new OfferGas('g_ddd',0,5.9999,930,110),
            new OfferGas('g_eee',6.0000,25.9999,800,80),
            new OfferGas('g_fff',26.0000,50.0000,730,50)
            ),

        $thirdSupplierEntity = new EnergySupplier('s_third','Běžný dodavatel',
            new OfferElectricity('e_ggg',0,3.9000,1100,80),
            new OfferElectricity('e_hhh',3.9001,20.9999,1050,70),
            new OfferElectricity('e_iii',21.0000,50.0000,900,80),
            new OfferGas('g_ggg',0,5.9999,920,110),
            new OfferGas('g_hhh',6.0000,25.9999,800,80),
            new OfferGas('g_iii',26.0000,50.0000,800,80)
            ),
        ];
    }

}