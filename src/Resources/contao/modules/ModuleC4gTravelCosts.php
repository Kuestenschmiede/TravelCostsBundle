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
namespace con4gis\TravelCostsBundle\Resources\contao\modules;


use con4gis\CoreBundle\Classes\C4GUtils;
use con4gis\CoreBundle\Classes\ResourceLoader;
use con4gis\CoreBundle\Resources\contao\models\C4gSettingsModel;
use con4gis\MapsBundle\Resources\contao\models\C4gMapProfilesModel;
use con4gis\TravelCostsBundle\Entity\TravelCostsSettings;
use Contao\System;
use Doctrine\ORM\EntityManager;
use Contao\Controller;
use Contao\Module;
use Contao\StringUtil;
use Contao\BackendTemplate;

/**
 * Class ModuleC4gTravelCosts
 * @package \con4gis\TravelCostsBundle\Resources\contao\modules
 */
class ModuleC4gTravelCosts extends Module
{
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'c4g_travel_costs';

    /**
     * Generate content element
     */
    public function generate()
    {
        if (C4GUtils::isBackend()) {
            $objTemplate = new BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### '.$GLOBALS['TL_LANG']['FMD']['c4g_travel_costs'][0].' ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->title;
            $objTemplate->href = 'contao?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;
            return $objTemplate->parse();
        }
        return parent::generate();
    }

    /**
     * Generate module
     */
    protected function compile()
    {
        $pageId = $this->mapPage;
        $pageUrl = C4GUtils::replaceInsertTags("{{link_url:: " . $pageId . "}}");
        ResourceLoader::loadJavaScriptResource("bundles/con4giscore/vendor/jQuery/jquery-ui-1.12.1.custom/jquery-ui.min.js", ResourceLoader::JAVASCRIPT, 'jquery-ui');
        ResourceLoader::loadJavaScriptResource( "bundles/con4gistravelcosts/build/travel-finder.js", ResourceLoader::JAVASCRIPT, "travel-finder");
        ResourceLoader::loadCssResource("bundles/con4gistravelcosts/dist/css/travel-finder.min.css", "travel-finder");
        ResourceLoader::loadCssResource("/bundles/con4giscore/vendor/jQuery/jquery-ui-1.12.1.custom/jquery-ui.min.css", 'jquery-ui-css');
        $template = $this->Template;
        $objSettings = C4gSettingsModel::findSettings();
        $objMapsProfile = C4gMapProfilesModel::findByPk($objSettings->defaultprofile);
        $arrSettings = [];
        if($objMapsProfile->geosearchParams){
            $arrSettings['geosearchParams'] = [];
            foreach(unserialize($objMapsProfile->geosearchParams) as $geosearchParam){
                $arrSettings['geosearchParams'] = array_merge($arrSettings['geosearchParams'], [$geosearchParam['keys'] => $geosearchParam['params']]);
            }
        }
        $arrSettings['proxyUrl'] = $objSettings->con4gisIoUrl;
        $arrSettings['keyReverse'] = C4GUtils::getKey($objSettings,3);
        $arrSettings['keyForward'] = C4GUtils::getKey($objSettings,2);
        $arrSettings['keyAutocomplete'] = C4GUtils::getKey($objSettings,7);
        $settingsId = $this->expense_settings_id;
        $tariffConfig = System::getContainer()->get("doctrine.orm.default_entity_manager")->getRepository(TravelCostsSettings::class)
            ->findOneBy(['id' => $settingsId]);
        if ($tariffConfig instanceof TravelCostsSettings) {
            $bBox = [$tariffConfig->getStartBboxDownerx(), $tariffConfig->getStartBboxDownery(), $tariffConfig->getStartBboxUpperx(), $tariffConfig->getStartBboxUppery()];

            if($bBox) {
                // swap if coordinates build no bbox in the current form
                if ($bBox[0] > $bBox[2]) {
                    $bboxSaver = $bBox[0];
                    $bBox[0] = $bBox[2];
                    $bBox[2] = $bboxSaver;
                }
                if ($bBox[1] > $bBox[3]) {
                    $bboxSaver = $bBox[1];
                    $bBox[1] = $bBox[3];
                    $bBox[3] = $bboxSaver;
                }
                if ($bBox[0] === $bBox[1] && $bBox[1] === $bBox[2] && $bBox[2] === $bBox[3]) {
                    // catch case all bbox params are empty strings
                    $arrSettings['bBox'] = "";
                } else {
//                    $bBox = str_replace("\"", "\\\"", json_encode($bBox));
                    $arrSettings['bBox'] = $bBox;
                }

            }
            if ($tariffConfig->getCenterX() && $tariffConfig->getCenterY()) {
                $arrSettings['center'] = [$tariffConfig->getCenterX(), $tariffConfig->getCenterY()];
            }
            $arrSettings['errMsgBounds'] = $tariffConfig->getErrorMessageBounds();
            $arrSettings['errMsgNotFound'] = $tariffConfig->getErrorMessageNotFound();
            $arrSettings['searchPlaceholder'] = $tariffConfig->getSearchPlaceholder();
            $arrSettings['inputPlaceholder'] = $tariffConfig->getInputPlaceholder();
            $arrSettings['posButton'] = $tariffConfig->getWithPositionButton();
            $arrSettings['delButton'] = $tariffConfig->getWithDeleteButton();
            $arrSettings['submitButton'] = $tariffConfig->getWithSubmitButton();
            $arrSettings['overPositions'] = $tariffConfig->getOverPositions();
            $arrSettings['addTime'] = $tariffConfig->getAddTimes();
            if ($tariffConfig->getAddPriceOptions()) {
                $arrSettings['addPriceOptions'] = StringUtil::deserialize($tariffConfig->getAddPriceOptions());
            }
            $arrSettings['hideDisplay'] = $tariffConfig->getHideDisplay();
            $arrSettings['displayType'] = $tariffConfig->getTariffDisplay();
            $arrSettings['currency'] = $tariffConfig->getCurrency();
        }
        if ($tariffConfig->getLanguage()) {
             $language = $tariffConfig->getLanguage() === 1 ? "en" : "de";
        }
        else {
            $language = C4GUtils::replaceInsertTags("{{page::language}}");
        }
        $arrSettings['lang'] = $language;
        $arrSettings['autoLength'] = $tariffConfig->getLimitAutocomplete() ?: 10;
        $arrSettings['settingId'] = $settingsId;
        $template->arrSettings = $arrSettings;
    }
}
