<?php

namespace GeorgRinger\Savebuttonsorting\Xclass;

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

use TYPO3\CMS\Backend\Template\Components\Buttons\InputButton;
use TYPO3\CMS\Backend\Template\Components\Buttons\SplitButton;

/**
 * Xclass SplitButton to add getters and setters
 */
class ImprovedSplitButton extends SplitButton
{

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @return InputButton
     */
    public function getPrimaryButton()
    {
        return $this->items['primary'];
    }

    /**
     * @return InputButton[]
     */
    public function getOptionButtons()
    {
        return $this->items['options'];
    }

    /**
     * @param array $items
     */
    public function setItems(array $items)
    {
        $this->items = $items;
    }
}