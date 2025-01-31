<?php


namespace con4gis\TravelCostsBundle\Resources\contao\modules;

use con4gis\CoreBundle\Classes\C4GUtils;
use con4gis\CoreBundle\Classes\ResourceLoader;
use con4gis\TravelCostsBundle\Entity\TravelCostsSettings;
use Contao\Controller;
use Contao\System;
use Contao\Module;
use Contao\BackendTemplate;

class ModuleC4gTariffs extends Module
{
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'c4g_tariffs';

    /**
     * Generate content element
     */
    public function generate()
    {
        if (C4GUtils::isBackend()) {
            $objTemplate = new BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### '.$GLOBALS['TL_LANG']['FMD']['c4g_tariffs'][0].' ###';
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
        ResourceLoader::loadJavaScriptResource("bundles/con4giscore/vendor/jQuery/jquery-ui-1.12.1.custom/jquery-ui.min.js", ResourceLoader::JAVASCRIPT,'jquery-ui');
        ResourceLoader::loadJavaScriptResource("bundles/con4gistravelcosts/build/tariff-finder.js", ResourceLoader::JAVASCRIPT,"tariff-finder" );
        ResourceLoader::loadCssResource("bundles/con4gistravelcosts/dist/css/travel-finder.min.css", "travel-finder");
        ResourceLoader::loadCssResource("/bundles/con4giscore/vendor/jQuery/jquery-ui-1.12.1.custom/jquery-ui.min.css",'jquery-ui-css' );
        $template = $this->Template;
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
                $template->bBox = json_encode($bBox);
            }
            $template->posButton = $tariffConfig->getWithPositionButton();

        }
        $template->tariffDisplay = $tariffConfig->getTariffDisplay();
        $template->hideDisplay = $tariffConfig->getHideDisplay();
        $template->customText = $tariffConfig->getDisplayText();
        $template->currency = $tariffConfig->getCurrency();
        if ($tariffConfig->getLanguage()) {
            $language = $tariffConfig->getLanguage() === 1 ? "en" : "de";
        }
        else {
            $language = C4GUtils::replaceInsertTags("{{page::language}}");
        }
        $template->lang = $language;
        $template->settingId = $settingsId;
    }
}