<?php

/*
 * HiPanel tickets module
 *
 * @link      https://github.com/hiqdev/hipanel-module-ticket
 * @package   hipanel-module-ticket
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\ticket;

class Plugin extends \hiqdev\pluginmanager\Plugin
{
    protected $_items = [
        'aliases' => [
            '@ticket' => '/ticket/ticket',
        ],
        'menus' => [
            'hipanel\modules\ticket\SidebarMenu',
        ],
        'modules' => [
            'ticket' => [
                'class' => 'hipanel\modules\ticket\Module',
            ],
        ],
        'components' => [
            'i18n' => [
                'translations' => [
                    'hipanel/ticket*' => [
                        'class' => 'yii\i18n\PhpMessageSource',
                        'basePath' => '@hipanel/modules/ticket/messages',
                        'fileMap' => [
                            'hipanel/ticket' => 'ticket.php',
                        ],
                    ],
                ],
            ],
        ],

    ];
}
