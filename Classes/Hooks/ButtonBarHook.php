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

use GeorgRinger\Savebuttonsorting\Xclass\ImprovedSplitButton;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ButtonBarHook
{
    /**
     * @param array $params
     * @return array
     */
    public function modify(array $params)
    {
        if (empty($params['buttons']) || !isset($params['buttons']['left'])) {
            return $params['buttons'];
        }

        foreach ($params['buttons']['left'] as &$items) {
            foreach ($items as &$button) {
                if ($button instanceof ImprovedSplitButton) {
                    $options = $this->getButtonVariants($button);

                    $sortedOptions = $this->sortOptions($options);

                    $changedSplitButton = [
                        'primary' => array_shift($sortedOptions),
                        'options' => $sortedOptions
                    ];
                    $button->setItems($changedSplitButton);
                }
            }
        }

        return $params['buttons'];
    }

    /**
     * @param ImprovedSplitButton $button
     * @return array
     */
    protected function getButtonVariants(ImprovedSplitButton $button)
    {
        $options = [];
        $primary = $button->getPrimaryButton();
        $options[$primary->getName()] = $primary;

        foreach ($button->getOptionButtons() as $item) {
            $name = $item->getName();
            $options[$name] = $item;
        }
        return $options;
    }

    /**
     * @param $options
     * @return array
     */
    protected function sortOptions($options)
    {
        $newOrder = [];
        $sortingConfiguration = $this->getTsConfig('default');
        if (!empty($sortingConfiguration)) {
            $split = GeneralUtility::trimExplode(',', $sortingConfiguration, true);
            foreach ($split as $name) {
                $name = '_' . $name;
                if (isset($options[$name])) {
                    $newOrder[$name] = $options[$name];
                    unset($options[$name]);
                }
            }

            if (!empty($options)) {
                $newOrder += $options;
            }
            return $newOrder;
        }
        return $options;
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