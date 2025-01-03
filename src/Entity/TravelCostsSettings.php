<?php
/*
 * This file is part of con4gis,
 * the gis-kit for Contao CMS.
 *
 * @package    con4gis
 * @version    7
 * @author     con4gis contributors (see "authors.txt")
 * @license    LGPL-3.0-or-later
 * @copyright  Küstenschmiede GmbH Software & Design
 * @link       https://www.con4gis.org
 */

namespace con4gis\TravelCostsBundle\Entity;

use \Doctrine\ORM\Mapping as ORM;
use con4gis\CoreBundle\Entity\BaseEntity;

/**
 * Class TravelCostsSettings
 *
 * @ORM\Entity
 * @ORM\Table(name="tl_c4g_travel_costs_settings")
 * @package con4gis\TravelCostsBundle\Entity
 */
class TravelCostsSettings extends BaseEntity
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id = 0;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $tstamp = 0;

    /**
     * @var int
     * @ORM\Column(type="integer", options={"default":0})
     */
    protected $importId = 0;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $caption = '';

     /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $type = '';

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $startBboxUpperx = '';
    
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $startBboxUppery = '';
    
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $startBboxDownerx = '';
    
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $startBboxDownery = '';

    /**
     * @var array
     * @ORM\Column(type="array")
     */
    protected $tariffs = [];

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $withDateTime = 0;

    /**
     * @var string
     * @ORM\Column(type="string", length=1)
     */
    protected $withPositionButton = '0';

    /**
     * @var string
     * @ORM\Column(type="string", length=1)
     */
    protected $withSubmitButton = '0';

    /**
     * @var string
     * @ORM\Column(type="string", length=1)
     */
    protected $withDeleteButton = '0';
   
    /**
     * @var string
     * @ORM\Column(type="string", length=1)
     */
    protected $overPositions = '0';

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $timeAtStop = 0;

    /**
     * @var string
     * @ORM\Column(type="string", length=1)
     */
    protected $addTimes = '0';

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $distPrice = 0;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $centerx = '';

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $centery = '';

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $errorMessageBounds = '';

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $errorMessageNotFound = '';

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $searchPlaceholder = '';

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $inputPlaceholder = '';

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $language = 0;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $currency = '€';
    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $tariffDisplay = 0;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    protected $displayText = '';

    /**
     * @var string
     * @ORM\Column(type="string", length=1)
     */
    protected $hideDisplay = '0';

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $limitAutocomplete = 10;
    
    /**
     * @var null
     * @ORM\Column(type="array")
     */
    protected $addPriceOptions = [];

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getTstamp(): int
    {
        return $this->tstamp;
    }

    /**
     * @param int $tstamp
     */
    public function setTstamp(int $tstamp): void
    {
        $this->tstamp = $tstamp;
    }

    /**
     * @return int
     */
    public function getimportId(): int
    {
        return $this->importId;
    }

    /**
     * @param int $importId
     */
    public function setImportId(int $importId): void
    {
        $this->importId = $importId;
    }

    /**
     * @return string
     */
    public function getCaption(): string
    {
        return $this->caption;
    }

    /**
     * @param string $caption
     */
    public function setCaption(string $caption): void
    {
        $this->caption = $caption;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }
    
    /**
     * @return string
     */
    public function getStartBboxUpperx(): string
    {
        return $this->startBboxUpperx;
    }
    
    /**
     * @param string $startBboxUpperx
     */
    public function setStartBboxUpperx(string $startBboxUpperx): void
    {
        $this->startBboxUpperx = $startBboxUpperx;
    }
    
    /**
     * @return string
     */
    public function getStartBboxUppery(): string
    {
        return $this->startBboxUppery;
    }
    
    /**
     * @param string $startBboxUppery
     */
    public function setStartBboxUppery(string $startBboxUppery): void
    {
        $this->startBboxUppery = $startBboxUppery;
    }
    
    /**
     * @return string
     */
    public function getStartBboxDownerx(): string
    {
        return $this->startBboxDownerx;
    }
    
    /**
     * @param string $startBboxDownerx
     */
    public function setStartBboxDownerx(string $startBboxDownerx): void
    {
        $this->startBboxDownerx = $startBboxDownerx;
    }
    
    /**
     * @return string
     */
    public function getStartBboxDownery(): string
    {
        return $this->startBboxDownery;
    }
    
    /**
     * @param string $startBboxDownery
     */
    public function setStartBboxDownery(string $startBboxDownery): void
    {
        $this->startBboxDownery = $startBboxDownery;
    }

    /**
     * @return array
     */
    public function getTariffs(): array
    {
        return $this->tariffs;
    }

    /**
     * @param array $tariffs
     */
    public function setTariffs(array $tariffs): void
    {
        $this->tariffs = $tariffs;
    }

    /**
     * @return int
     */
    public function getWithDateTime(): int
    {
        return $this->withDateTime;
    }

    /**
     * @param int $withDateTime
     */
    public function setWithDateTime(int $withDateTime): void
    {
        $this->withDateTime = $withDateTime;
    }

    /**
     * @return int
     */
    public function getDistPrice(): int
    {
        return $this->distPrice;
    }

    /**
     * @param int $distPrice
     */
    public function setDistPrice(int $distPrice): void
    {
        $this->distPrice = $distPrice;
    }

    /**
     * @return string
     */
    public function getCenterx(): string
    {
        return $this->centerx;
    }

    /**
     * @param string $centerx
     */
    public function setCenterx(string $centerx): void
    {
        $this->centerx = $centerx;
    }

    /**
     * @return string
     */
    public function getCentery(): string
    {
        return $this->centery;
    }

    /**
     * @param string $centery
     */
    public function setCentery(string $centery): void
    {
        $this->centery = $centery;
    }

    /**
     * @return string
     */
    public function getErrorMessageBounds(): string
    {
        return $this->errorMessageBounds;
    }

    /**
     * @param string $errorMessageBounds
     */
    public function setErrorMessageBounds(string $errorMessageBounds): void
    {
        $this->errorMessageBounds = $errorMessageBounds;
    }

    /**
     * @return string
     */
    public function getErrorMessageNotFound(): string
    {
        return $this->errorMessageNotFound;
    }

    /**
     * @param string $errorMessageNotFound
     */
    public function setErrorMessageNotFound(string $errorMessageNotFound): void
    {
        $this->errorMessageNotFound = $errorMessageNotFound;
    }

    /**
     * @return string
     */
    public function getSearchPlaceholder(): string
    {
        return $this->searchPlaceholder;
    }

    /**
     * @param string $searchPlaceholder
     */
    public function setSearchPlaceholder(string $searchPlaceholder): void
    {
        $this->searchPlaceholder = $searchPlaceholder;
    }

    /**
     * @return string
     */
    public function getInputPlaceholder(): string
    {
        return $this->inputPlaceholder;
    }

    /**
     * @param string $inputPlaceholder
     */
    public function setInputPlaceholder(string $inputPlaceholder): void
    {
        $this->inputPlaceholder = $inputPlaceholder;
    }
    
    /**
     * @return int
     */
    public function getLanguage(): int
    {
        return $this->language;
    }

    /**
     * @param int $language
     */
    public function setLanguage(int $language): void
    {
        $this->language = $language;
    }

    /**
     * @return int
     */
    public function getTariffDisplay(): int
    {
        return $this->tariffDisplay;
    }

    /**
     * @param int $tariffDisplay
     */
    public function setTariffDisplay(int $tariffDisplay): void
    {
        $this->tariffDisplay = $tariffDisplay;
    }

    /**
     * @return string
     */
    public function getDisplayText(): string
    {
        return $this->displayText;
    }

    /**
     * @param string $displayText
     */
    public function setDisplayText(string $displayText): void
    {
        $this->displayText = $displayText;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * @return int
     */
    public function getLimitAutocomplete(): int
    {
        return $this->limitAutocomplete;
    }

    /**
     * @param int $limitAutocomplete
     */
    public function setLimitAutocomplete(int $limitAutocomplete): void
    {
        $this->limitAutocomplete = $limitAutocomplete;
    }

    /**
     * @return string
     */
    public function getWithPositionButton(): string
    {
        return $this->withPositionButton;
    }

    /**
     * @param string $withPositionButton
     */
    public function setWithPositionButton(string $withPositionButton)
    {
        $this->withPositionButton = $withPositionButton;
    }

    /**
     * @return string
     */
    public function getWithSubmitButton(): string
    {
        return $this->withSubmitButton;
    }

    /**
     * @param string $withSubmitButton
     */
    public function setWithSubmitButton(string $withSubmitButton)
    {
        $this->withSubmitButton = $withSubmitButton;
    }

    /**
     * @return string
     */
    public function getWithDeleteButton(): string
    {
        return $this->withDeleteButton;
    }

    /**
     * @param string $withDeleteButton
     */
    public function setWithDeleteButton(string $withDeleteButton)
    {
        $this->withDeleteButton = $withDeleteButton;
    }

    /**
     * @return string
     */
    public function getOverPositions(): string
    {
        return $this->overPositions;
    }

    /**
     * @param string $overPositions
     */
    public function setOverPositions(string $overPositions): void
    {
        $this->overPositions = $overPositions;
    }

    /**
     * @return int
     */
    public function getTimeAtStop(): int
    {
        return $this->timeAtStop;
    }

    /**
     * @param int $timeAtStop
     */
    public function setTimeAtStop(int $timeAtStop): void
    {
        $this->timeAtStop = $timeAtStop;
    }

    /**
     * @return string
     */
    public function getAddTimes(): string
    {
        return $this->addTimes;
    }

    /**
     * @param string $addTimes
     */
    public function setAddTimes(string $addTimes): void
    {
        $this->addTimes = $addTimes;
    }
    
    /**
     * @return string
     */
    public function getHideDisplay(): string
    {
        return $this->hideDisplay;
    }

    /**
     * @param string $hideDisplay
     */
    public function setHideDisplay(string $hideDisplay)
    {
        $this->hideDisplay = $hideDisplay;
    }

    /**
     * @return null
     */
    public function getAddPriceOptions()
    {
        return $this->addPriceOptions;
    }

    /**
     * @param null $addPriceOptions
     */
    public function setAddPriceOptions($addPriceOptions): void
    {
        $this->addPriceOptions = $addPriceOptions;
    }

}