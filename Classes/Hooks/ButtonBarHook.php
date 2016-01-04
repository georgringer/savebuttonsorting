<?php

namespace GeorgRinger\Savebuttonsorting\Hooks;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use GeorgRinger\News\Xclass\SplitButton;
use TYPO3\CMS\Backend\Template\Components\Buttons\InputButton;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ButtonBarHook
{
    public function modify(array $params)
    {

        foreach ($params['buttons']['left'] as &$items) {
            foreach ($items as &$button) {
                if ($button instanceof SplitButton) {
                    $options = $tmpOptions = [];
                    /** @var SplitButton $button */

                    $primary = $button->getPrimaryButton();
                    $options[$primary->getName()] = $primary;
                    foreach ($button->getOptionButtons() as $item) {
                        /** @var InputButton $item */
                        $name = $item->getName();
                        $options[$name] = $item;
                    }

                    $tsconfig = $this->getTsConfig('default');
                    if (!empty($tsconfig)) {
                        $split = GeneralUtility::trimExplode(',', $tsconfig, true);
                        foreach ($split as $name) {
                            $name = '_' . $name;
                            if (isset($options[$name])) {
                                $tmpOptions[$name] = $options[$name];
                                unset($options[$name]);
                            }
                        }

                        if (!empty($options)) {
                            $tmpOptions += $options;
                        }
                    }

                    print_r(array_keys($tmpOptions));

                    $new = [];
                    $new['primary'] = array_shift($tmpOptions);
                    $new['options'] = $tmpOptions;
                    $button->setItems($new);
                }
            }
        }

        return $params['buttons'];
    }

    /**
     * Get TsConfig value
     *
     * @param string $key
     * @return string
     */
    protected function getTsConfig($key)
    {
        return trim($this->getBackendUser()->getTSConfigVal('options.saveButton.' . $key));
    }

    /**
     * Returns the current BE user.
     *
     * @return \TYPO3\CMS\Core\Authentication\BackendUserAuthentication
     */
    protected function getBackendUser()
    {
        return $GLOBALS['BE_USER'];
    }
}