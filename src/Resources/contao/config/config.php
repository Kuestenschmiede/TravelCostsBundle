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

/**
 * Backend Modules
 */
$GLOBALS['BE_MOD']['con4gis'] = array_merge($GLOBALS['BE_MOD']['con4gis'], [
        'c4g_travel_costs_tariffs' => ['brick' => 'travel-costs', 'tables' => ['tl_c4g_travel_costs_tariffs'],  'icon' => 'bundles/con4gistravelcosts/images/be-icons/travelcosts_tariff.svg'],
        'c4g_travel_costs_settings' => ['brick' => 'travel-costs', 'tables' => ['tl_c4g_travel_costs_settings','tl_c4g_travel_costs_tariffs'],'icon' => 'bundles/con4giscore/images/be-icons/edit.svg'],
        ]
 );

/**
 * Frontend modules
 */
$GLOBALS['FE_MOD']['con4gis']['c4g_travel_costs'] = 'con4gis\TravelCostsBundle\Resources\contao\modules\ModuleC4gTravelCosts';
$GLOBALS['FE_MOD']['con4gis']['c4g_travel_costs_tariffs'] = 'con4gis\TravelCostsBundle\Resources\contao\modules\ModuleC4gTariffs';
asort($GLOBALS['FE_MOD']['con4gis']);