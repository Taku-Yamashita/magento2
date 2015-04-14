<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Quote\Test\Unit\Model;

/**
 * Unit test for \Magento\Quote\Model\QuoteIdMask
 */
class QuoteIdMaskTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \Magento\Quote\Model\QuoteIdMask
     */
    protected $quoteIdMask;

    protected function setUp()
    {
        $helper = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);
        $this->quoteIdMask = $helper->getObject('Magento\Quote\Model\QuoteIdMask');
    }

    public function testBeforeSave()
    {
        $this->quoteIdMask->beforeSave();
        $this->assertNotNull($this->quoteIdMask->getMaskedId(), 'Masked identifier is not generated.');
    }
}
