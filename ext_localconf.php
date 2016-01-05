<?php
defined('TYPO3_MODE') or die();

$boot = function () {


    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['Backend\Template\Components\ButtonBar']['getButtonsHook'][]
        = \GeorgRinger\Savebuttonsorting\Hooks\ButtonBarHook::class . '->modify';

    $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\TYPO3\CMS\Backend\Template\Components\Buttons\SplitButton::class] = array(
        'className' => \GeorgRinger\Savebuttonsorting\Xclass\ImprovedSplitButton::class,
    );
};

$boot();
unset($boot);