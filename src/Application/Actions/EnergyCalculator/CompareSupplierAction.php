<?php
declare(strict_types=1);

namespace App\Application\Actions\EnergyCalculator;

use App\Domain\Dto\EnergyOfferDto;
use App\Domain\SupplierOffer\OfferPriceCalculator;
use App\Domain\SupplierOffer\OfferSorter;
use App\Infrastructure\Persistence\EnergySupplier\InMemEnergySupplierRepository;
use App\Infrastructure\StringValidator\FloatValidator;
use Psr\Http\Message\ResponseInterface as ResponseInterface;
use App\Application\Dto\ApiResponsePayload;
use Psr\Log\LoggerInterface;

class CompareSupplierAction extends CalculatorAction
{
    /**
     * {@inheritdoc}
     */

    /**
     * @var string[]
     */
    private $requiredParams = ['consumption', 'commodity', 'price', 'pdt'];

    /**
     * @var FloatValidator
     */
    private $floatValidator;

    /**
     * @var OfferSorter;
     */
    private $offerSorter;

    public function __construct(LoggerInterface $logger, InMemEnergySupplierRepository $supplierRepository)
    {
        parent::__construct($logger, $supplierRepository);
        $this->floatValidator = new FloatValidator();
        $this->offerSorter = new OfferSorter();
    }

    protected function action(): ResponseInterface
    {

        $data = array_map(function ($value){
            return str_replace(',', '.', $value);
        },$this->request->getParsedBody());



        $apiDto = new ApiResponsePayload(false, 400);
        if (!is_array($data) || !$this->isRequestPayloadValid($data, $apiDto)) {

            return $this
                ->respondWithData($apiDto, 200);
        }


        $consumption = floatval($data['consumption']);
        $commodityName = $data['commodity'];
        $clientPrice = floatval($data['price']);
        $clientPdt = floatval($data['pdt']);
        $clientTotalPrice = strval(OfferPriceCalculator::getAnnualTotalOfferPrice($consumption, $clientPrice, $clientPdt));


        $energySuppliers = $this->supplierRepository->findAll();

        $relevantOffers = [];

        //look up for offers with commodity
        foreach ($energySuppliers as $energySupplier) {

            //check if supplier has commodity offer
            if (!in_array($commodityName, $energySupplier->getCommodityNames())) {
                continue;
            }

            //not necessary i guess
            if($supplier = $energySupplier->getRelevantOffers($commodityName, $consumption))
            $relevantOffers[] = $supplier;
        }

        //add user offer to responsePayload
        $userOfferDto = new EnergyOfferDto('userOffer', $clientTotalPrice, $data['price'], $data['pdt'], 'Můj dodavatel');
        $relevantOffers[] = $userOfferDto;

        //sort by price ASC
        if(count($relevantOffers) > 1)
        $relevantOffers = $this->offerSorter->sortOffersByTotalPrice($relevantOffers);

        $payload = new ApiResponsePayload(true, 0, [], array_values($relevantOffers));
        return $this->respondWithData($payload)->withHeader('content-type', 'application/json');
    }

    private function isRequestPayloadValid(array $bodyParams, &$payloadObject): bool
    {
        $errors = [];
        if (count(array_filter($bodyParams, 'is_string')) !== count($bodyParams) //string check
            || (isset($bodyParams['commodity']) && !preg_match('/^[\w]+$/', $bodyParams['commodity'])) //name is string
            || count(array_intersect_key(array_flip($this->requiredParams), $bodyParams)) !== 4) //required params included
        {
            $payloadObject = new ApiResponsePayload(false, 400);
            return false; //400 - not ajax call
        }

        unset($bodyParams['commodity']); //not needed anymore

        $checkFormatFunc = function ($value, $key) use (&$errors) {

            if (!($this->floatValidator->hasFloatNumberStructure($value) && $this->floatValidator->isValidFloatNumber($value))) {

                $errors['field'][] = $key; //required key name for FE
            }
        };

        //return back payload with errorCodes form fields
        array_walk($bodyParams, $checkFormatFunc);

        if (count($errors) > 0) {
            $payloadObject = new ApiResponsePayload(false, 401, $errors);
            return false;
        }

        return true;
    }
}
