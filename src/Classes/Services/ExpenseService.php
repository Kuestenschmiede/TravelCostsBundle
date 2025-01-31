<?php

namespace con4gis\TravelCostsBundle\Classes\Services;

use con4gis\CoreBundle\Resources\contao\models\C4gSettingsModel;
use con4gis\TravelCostsBundle\Classes\Events\CalculateExpenseEvent;
use con4gis\TravelCostsBundle\Entity\TravelCostsSettings;
use con4gis\TravelCostsBundle\Entity\TravelCostsTariff;
use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpClient\HttpClient;

class ExpenseService
{

    /**
     * AreaService constructor
     */
    public function __construct(EntityManager $manager, EventDispatcher $eventDispatcher)
    {
        $this->entityManager = $manager;
        $this->eventDispatcher = $eventDispatcher;

    }
    public function getResponse($expenseSetting, $locations, $tariffIds = null, $time = null)
    {
        $objExpenseSettings = $this->entityManager->getRepository(TravelCostsSettings::class)->findOneBy(['id' => $expenseSetting]);
        if ($objExpenseSettings instanceof TravelCostsSettings) {
            $arrTariffIds = $objExpenseSettings->getTariffs();
            $arrTariffs = $this->entityManager->getRepository(TravelCostsTariff::class)->findBy(['id' => $arrTariffIds]);

            $event = new CalculateExpenseEvent();
            $event->setSettings($objExpenseSettings);
            if ($time) {
                $event->setInput($time);
            }
            $event->setTariffs($arrTariffs);
            $event->setLocations($locations);
            $this->eventDispatcher->dispatch($event, $event::NAME);
            $objExpenseSettings = $event->getSettings();
            $arrTariffs = $event->getTariffs();
            $locations = $event->getLocations();
            if ($time) {
                $time = $event->getInput();
            }

            if ($arrTariffs[0]) {
                $arrSendTariffs = [];
                foreach ($arrTariffs as $key => $objTariff) {
                    if ($objTariff  instanceof TravelCostsTariff) {
                        $arrSendTariffs[$key] =
                            [
                                'basePrice'     => $objTariff->getBasePrice(),
                                'distPrice'     => $objTariff->getDistancePrice(),
                                'timePrice'     => $objTariff->getTimePrice(),
                                'stopTime'      => $objTariff->getStopTime(),
                                'interimPrice'  => $objTariff->getInterimPrice()
                            ];
                    }
                }

                $objSettings = C4gSettingsModel::findSettings();
                $apiKey = $objSettings->con4gisIoKey;
                $apiUrl = $objSettings->con4gisIoUrl;

                if ($apiKey && $apiUrl) {
                    $typeCalc = $objExpenseSettings->getDistPrice();
                    $sendUrl = rtrim($apiUrl, '/') . '/' . 'routingExpense.php?loc=' . $locations . '&tariffs=' . urlencode(\GuzzleHttp\json_encode($arrSendTariffs)) . '&typeCalc=' . $typeCalc . '&time=' . $time . '&key=' . $apiKey;
                    $headers = [];
//                    $REQUEST = new Request();
                    if ($_SERVER['HTTP_REFERER']) {
//                        $REQUEST->setHeader('Referer', $_SERVER['HTTP_REFERER']);
                        $headers['Referer'] = $_SERVER['HTTP_REFERER'];
                    }
                    if ($_SERVER['HTTP_USER_AGENT']) {
                        $headers['User-Agent'] = $_SERVER['HTTP_USER_AGENT'];
//                        $REQUEST->setHeader('User-Agent', $_SERVER['HTTP_USER_AGENT']);
                    }
                    $headers['Content-Type'] = 'application/json';
//                    $REQUEST->setHeader('Content-Type', 'application/json');
                    $client = HttpClient::create([
                        'headers' => $headers
                    ]);
                    $response = $client->request("GET", $sendUrl);
                    $response->getContent();

                    $response = json_decode($response->getContent());
                    if ($response->tariffs) {
                        $arrResponseTariffs = [];
                        foreach ($response->tariffs as $key => $tariff) {
//                $objTariff = $arrTariffs[$key]
                            $arrResponseTariffs[$arrTariffs[$key]->getCaption()] = $tariff;
                        }
                        $response->tariffs = $arrResponseTariffs;
                    }

                    return $response;
                }
            }
        }

    }
}
