<?php use Contao\DC_Table;

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
$strName = 'tl_c4g_travel_costs_tariffs';

$GLOBALS['TL_DCA'][$strName] = array
(

    // Config
    'config' => array
    (
        'dataContainer'               => DC_Table::class,
        'enableVersioning'            => true,
        'onsubmit_callback'           => array(
            array('\con4gis\CoreBundle\Classes\C4GAutomator', 'purgeApiCache')
        )
    ),

    // List
    'list' => array
    (
        'sorting' => array
        (
            'mode'                    => 1,
            'fields'                  => array('caption'),
            'flag'                    => 1,
            'icon'                    => 'bundles/con4giscore/images/be-icons/con4gis_blue.svg',
        ),
        'label' => array
        (
            'fields'                  => array('caption'),
            'format'                  => '%s'
        ),
        'global_operations' => array
        (
            'all' => [
                'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'                => 'act=select',
                'class'               => 'header_edit_all',
                'attributes'          => 'onclick="Backend.getScrollOffset();" accesskey="e"'
            ],
            'back' => [
                'href'                => 'key=back',
                'class'               => 'header_back',
                'button_callback'     => ['\con4gis\CoreBundle\Classes\Helper\DcaHelper', 'back'],
                'icon'                => 'back.svg',
                'label'               => &$GLOBALS['TL_LANG']['MSC']['backBT'],
            ],
        ),
        'operations' => array
        (
            'edit' => array
            (
                'label'               => &$GLOBALS['TL_LANG'][$strName]['edit'],
                'href'                => 'act=edit',
                'icon'                => 'edit.svg',
            ),
            'copy' => array
            (
                'label'               => &$GLOBALS['TL_LANG'][$strName]['copy'],
                'href'                => 'act=copy',
                'icon'                => 'copy.svg'
            ),
            'delete' => array
            (
                'label'               => &$GLOBALS['TL_LANG'][$strName]['delete'],
                'href'                => 'act=delete',
                'icon'                => 'delete.svg',
                'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
            ),
            'show' => array
            (
                'label'               => &$GLOBALS['TL_LANG'][$strName]['show'],
                'href'                => 'act=show',
                'icon'                => 'show.svg'
            )
        )
    ),

    // Palettes
    'palettes' => array
    (
        '__selector__'                => array(''),
        'default'                     => '{general_legend},caption;'
            . '{price_legend},basePrice,distancePrice,timePrice,stopTime,interimPrice;'
            .'{weekday_legend:hide},monday,tuesday,wednesday,thursday,friday,saturday,sunday;'
    ),


    // Subpalettes
    'subpalettes' => array
    (

    ),

    // Fields
    'fields' => array
    (
        'caption' => [
            'label'                   => &$GLOBALS['TL_LANG'][$strName]['caption'],
            'default'                 => '',
            'inputType'               => 'text',
            'eval'                    => ['decodeEntities'=>true, 'maxlength'=>255, 'tl_class'=>'long'],
        ],
        'basePrice' => [
            'label'                   => &$GLOBALS['TL_LANG'][$strName]['basePrice'],
            'default'                 => 0,
            'inputType'               => 'text',
            'save_callback'           => [[\con4gis\TravelCostsBundle\Classes\Backend\TariffsBackendCallback::class, 'storeBasePrice']],
            'load_callback'           => [[\con4gis\TravelCostsBundle\Classes\Backend\TariffsBackendCallback::class, 'loadBasePrice']],
            'eval'                    => [],
        ],
        'distancePrice' => [
            'label'                   => &$GLOBALS['TL_LANG'][$strName]['distancePrice'],
            'default'                 => '',
            'inputType'               => 'multiColumnWizard',
            'eval'                    => [
                'columnFields' => [
                    'name' => [
                        'label'             => &$GLOBALS['TL_LANG'][$strName]['name'],
                        'default'           => 0,
                        'inputType'         => 'text',
                    ],
                    'fromKilometer' => [
                        'label'             => &$GLOBALS['TL_LANG'][$strName]['fromKilometer'],
                        'default'           => 0,
                        'inputType'         => 'text',
                        'eval'              => ['regxp'=>'digit']
                    ],
                    'toKilometer' => [
                        'label'             => &$GLOBALS['TL_LANG'][$strName]['toKilometer'],
                        'default'           => 0,
                        'inputType'         => 'text',
                        'eval'              => ['regxp'=>'digit']
                    ],'kilometerPrice' => [
                        'label'             => &$GLOBALS['TL_LANG'][$strName]['kilometerPrice'],
                        'default'           => 0,
                        'inputType'         => 'text',
                        'eval'              => ['regxp'=>'digit']
                    ]
                ]
            ],
        ],
        'timePrice' => [
            'label'                   => &$GLOBALS['TL_LANG'][$strName]['timePrice'],
            'default'                 => 0,
            'inputType'               => 'text',
            'eval'                    => ['regxp'=>'digit'],
        ],
        'stopTime' => [
            'label'                   => &$GLOBALS['TL_LANG'][$strName]['stopTime'],
            'default'                 => 0,
            'inputType'               => 'text',
            'eval'                    => ['regxp'=>'digit'],
        ],
        'interimPrice' => [
            'label'                   => &$GLOBALS['TL_LANG'][$strName]['interimPrice'],
            'default'                 => 0,
            'inputType'               => 'text',
            'eval'                    => ['regxp'=>'digit'],
        ],
        'monday' => array
        (
            'label'                   => &$GLOBALS['TL_LANG'][$strName]['monday'],
            'default'                 => time(),
            'exclude'                 => true,
            'inputType'               => 'multiColumnWizard',
            'eval'                    => array('columnFields'	=> array
            (
                'time_begin' => array
                (
                    'label'                   => &$GLOBALS['TL_LANG'][$strName]['time_begin'],
                    'exclude'                 => true,
                    'inputType'               => 'text',
                    'eval'                    => array('rgxp'=>'time', 'mandatory'=>false, 'doNotCopy'=>true, 'datepicker'=>true, 'tl_class'=>'w50 wizard')
                ),
                'time_end' => array
                (
                    'label'                   => &$GLOBALS['TL_LANG'][$strName]['time_end'],
                    'exclude'                 => true,
                    'inputType'               => 'text',
                    'eval'                    => array('rgxp'=>'time', 'mandatory'=>false, 'doNotCopy'=>true, 'datepicker'=>true, 'tl_class'=>'w50 wizard')
                )
            ))
        ),
        'tuesday' => array
        (
            'label'                   => &$GLOBALS['TL_LANG'][$strName]['tuesday'],
            'default'                 => time(),
            'exclude'                 => true,
            'inputType'               => 'multiColumnWizard',
            'eval'                    => array('columnFields'	=> array
            (
                'time_begin' => array
                (
                    'label'                   => &$GLOBALS['TL_LANG'][$strName]['time_begin'],
                    'exclude'                 => true,
                    'inputType'               => 'text',
                    'eval'                    => array('rgxp'=>'time', 'mandatory'=>false, 'doNotCopy'=>true, 'datepicker'=>true, 'tl_class'=>'w50 wizard')
                ),
                'time_end' => array
                (
                    'label'                   => &$GLOBALS['TL_LANG'][$strName]['time_end'],
                    'exclude'                 => true,
                    'inputType'               => 'text',
                    'eval'                    => array('rgxp'=>'time', 'mandatory'=>false, 'doNotCopy'=>true, 'datepicker'=>true, 'tl_class'=>'w50 wizard')
                )
            ))
        ),

        'wednesday' => array
        (
            'label'                   => &$GLOBALS['TL_LANG'][$strName]['wednesday'],
            'default'                 => time(),
            'exclude'                 => true,
            'inputType'               => 'multiColumnWizard',
            'eval'                    => array('columnFields'	=> array
            (
                'time_begin' => array
                (
                    'label'                   => &$GLOBALS['TL_LANG'][$strName]['time_begin'],
                    'exclude'                 => true,
                    'inputType'               => 'text',
                    'eval'                    => array('rgxp'=>'time', 'mandatory'=>false, 'doNotCopy'=>true, 'datepicker'=>true, 'tl_class'=>'w50 wizard')
                ),
                'time_end' => array
                (
                    'label'                   => &$GLOBALS['TL_LANG'][$strName]['time_end'],
                    'exclude'                 => true,
                    'inputType'               => 'text',
                    'eval'                    => array('rgxp'=>'time', 'mandatory'=>false, 'doNotCopy'=>true, 'datepicker'=>true, 'tl_class'=>'w50 wizard')
                )
            ))
        ),

        'thursday' => array
        (
            'label'                   => &$GLOBALS['TL_LANG'][$strName]['thursday'],
            'default'                 => time(),
            'exclude'                 => true,
            'inputType'               => 'multiColumnWizard',
            'eval'                    => array('columnFields'	=> array
            (
                'time_begin' => array
                (
                    'label'                   => &$GLOBALS['TL_LANG'][$strName]['time_begin'],
                    'exclude'                 => true,
                    'inputType'               => 'text',
                    'eval'                    => array('rgxp'=>'time', 'mandatory'=>false, 'doNotCopy'=>true, 'datepicker'=>true, 'tl_class'=>'w50 wizard')
                ),
                'time_end' => array
                (
                    'label'                   => &$GLOBALS['TL_LANG'][$strName]['time_end'],
                    'exclude'                 => true,
                    'inputType'               => 'text',
                    'eval'                    => array('rgxp'=>'time', 'mandatory'=>false, 'doNotCopy'=>true, 'datepicker'=>true, 'tl_class'=>'w50 wizard')
                )
            ))
        ),

        'friday' => array
        (
            'label'                   => &$GLOBALS['TL_LANG'][$strName]['friday'],
            'default'                 => time(),
            'exclude'                 => true,
            'inputType'               => 'multiColumnWizard',
            'eval'                    => array('columnFields'	=> array
            (
                'time_begin' => array
                (
                    'label'                   => &$GLOBALS['TL_LANG'][$strName]['time_begin'],
                    'exclude'                 => true,
                    'inputType'               => 'text',
                    'eval'                    => array('rgxp'=>'time', 'mandatory'=>false, 'doNotCopy'=>true, 'datepicker'=>true, 'tl_class'=>'w50 wizard')
                ),
                'time_end' => array
                (
                    'label'                   => &$GLOBALS['TL_LANG'][$strName]['time_end'],
                    'exclude'                 => true,
                    'inputType'               => 'text',
                    'eval'                    => array('rgxp'=>'time', 'mandatory'=>false, 'doNotCopy'=>true, 'datepicker'=>true, 'tl_class'=>'w50 wizard')
                )
            ))
        ),

        'saturday' => array
        (
            'label'                   => &$GLOBALS['TL_LANG'][$strName]['saturday'],
            'default'                 => time(),
            'exclude'                 => true,
            'inputType'               => 'multiColumnWizard',
            'eval'                    => array('columnFields'	=> array
            (
                'time_begin' => array
                (
                    'label'                   => &$GLOBALS['TL_LANG'][$strName]['time_begin'],
                    'exclude'                 => true,
                    'inputType'               => 'text',
                    'eval'                    => array('rgxp'=>'time', 'mandatory'=>false, 'doNotCopy'=>true, 'datepicker'=>true, 'tl_class'=>'w50 wizard')
                ),
                'time_end' => array
                (
                    'label'                   => &$GLOBALS['TL_LANG'][$strName]['time_end'],
                    'exclude'                 => true,
                    'inputType'               => 'text',
                    'eval'                    => array('rgxp'=>'time', 'mandatory'=>false, 'doNotCopy'=>true, 'datepicker'=>true, 'tl_class'=>'w50 wizard')
                )
            ))
        ),

        'sunday' => array
        (
            'label'                   => &$GLOBALS['TL_LANG'][$strName]['sunday'],
            'default'                 => time(),
            'exclude'                 => true,
            'inputType'               => 'multiColumnWizard',
            'eval'                    => array('columnFields'	=> array
            (
                'time_begin' => array
                (
                    'label'                   => &$GLOBALS['TL_LANG'][$strName]['time_begin'],
                    'exclude'                 => true,
                    'inputType'               => 'text',
                    'eval'                    => array('rgxp'=>'time', 'mandatory'=>false, 'doNotCopy'=>true, 'datepicker'=>true, 'tl_class'=>'w50 wizard')
                ),
                'time_end' => array
                (
                    'label'                   => &$GLOBALS['TL_LANG'][$strName]['time_end'],
                    'exclude'                 => true,
                    'inputType'               => 'text',
                    'eval'                    => array('rgxp'=>'time', 'mandatory'=>false, 'doNotCopy'=>true, 'datepicker'=>true, 'tl_class'=>'w50 wizard')
                )
            ))
        ),

        'timeBegin' => [
            'default' => 0,
        ],
        'timeEnd' => [
            'default' => 0,
        ],
        'beginDistance' => [
            'default' => 0,
        ],
        'endDistance' => [
            'default' => 0,
        ],
        'importId' => [
            'default' => 0,
            'eval' => ['doNotCopy' => true]
        ],

    )
);

