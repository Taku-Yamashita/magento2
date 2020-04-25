<?php declare(strict_types=1);
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Framework\Module\Test\Unit;

use Magento\Framework\Component\ComponentRegistrar;
use Magento\Framework\Component\ComponentRegistrarInterface;
use Magento\Framework\Module\Dir;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class DirTest extends TestCase
{
    /**
     * @var Dir
     */
    protected $_model;

    /**
     * @var ComponentRegistrarInterface|MockObject
     */
    protected $moduleRegistryMock;

    protected function setUp(): void
    {
        $this->moduleRegistryMock = $this->createMock(ComponentRegistrarInterface::class);

        $this->_model = new Dir($this->moduleRegistryMock);
    }

    public function testGetDirModuleRoot()
    {
        $this->moduleRegistryMock->expects($this->once())
            ->method('getPath')
            ->with(ComponentRegistrar::MODULE, 'Test_Module')
            ->will($this->returnValue('/Test/Module'));

        $this->assertEquals('/Test/Module', $this->_model->getDir('Test_Module'));
    }

    public function testGetDirModuleSubDir()
    {
        $this->moduleRegistryMock->expects($this->once())
            ->method('getPath')
            ->with(ComponentRegistrar::MODULE, 'Test_Module')
            ->will($this->returnValue('/Test/Module'));

        $this->assertEquals('/Test/Module/etc', $this->_model->getDir('Test_Module', 'etc'));
    }

    public function testGetSetupDirModule()
    {
        $this->moduleRegistryMock->expects($this->once())
            ->method('getPath')
            ->with(ComponentRegistrar::MODULE, 'Test_Module')
            ->willReturn('/Test/Module');

        $this->assertEquals('/Test/Module/Setup', $this->_model->getDir('Test_Module', 'Setup'));
    }

    public function testGetDirModuleSubDirUnknown()
    {
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('Directory type \'unknown\' is not recognized');
        $this->moduleRegistryMock->expects($this->once())
            ->method('getPath')
            ->with(ComponentRegistrar::MODULE, 'Test_Module')
            ->will($this->returnValue('/Test/Module'));

        $this->_model->getDir('Test_Module', 'unknown');
    }

    public function testGetDirModuleIncorrectlyRegistered()
    {
        $this->expectException('InvalidArgumentException');
        $this->expectExceptionMessage('Module \'Test Module\' is not correctly registered.');
        $this->moduleRegistryMock->expects($this->once())
            ->method('getPath')
            ->with($this->identicalTo(ComponentRegistrar::MODULE), $this->identicalTo('Test Module'))
            ->willReturn(null);
        $this->_model->getDir('Test Module');
    }
}
