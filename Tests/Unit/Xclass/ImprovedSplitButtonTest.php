<?php

namespace GeorgRinger\Savebuttonsorting\Unit\Xclass;

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
use TYPO3\CMS\Backend\Template\Components\Buttons\InputButton;
use TYPO3\CMS\Core\Tests\UnitTestCase;

/**
 * Unit test for ImprovedSplitButton
 */
class ImprovedSplitButtonTest extends UnitTestCase
{


    /**
     * @test
     */
    public function testBasicGetter()
    {
        $items = ['dummy', 'button'];
        $splitButton = new ImprovedSplitButton();
        $splitButton->setItems($items);
        $this->assertEquals($items, $splitButton->getItems());
    }

    /**
     * @test
     */
    public function testPrimaryGetter()
    {
        $primary = new InputButton();
        $primary->setName('primary');
        $items = ['dummy', 'button', 'primary' => $primary];

        $splitButton = new ImprovedSplitButton();
        $splitButton->setItems($items);
        $this->assertEquals($primary, $splitButton->getPrimaryButton());
    }

    /**
     * @test
     */
    public function testOptionGetter()
    {
        $option1 = new InputButton();
        $option1->setName('option 1');
        $option2 = new InputButton();
        $option2->setName('option 1');
        $options = [$option1, $option2];
        $items = ['dummy', 'button', 'options' => $options];

        $splitButton = new ImprovedSplitButton();
        $splitButton->setItems($items);
        $this->assertEquals($options, $splitButton->getOptionButtons());
    }

}
