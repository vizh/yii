<?php

class CApplicationComponentTest extends CTestCase
{
    public function testInitialization()
    {
        /** @var \CApplicationComponent $component */
        $component = $this->getMockForAbstractClass('CApplicationComponent', ['init', 'getIsInitialized'], '', null);
        $this->assertTrue(method_exists($component, 'getIsInitialized'));
        $this->assertFalse($component->getIsInitialized());
        $component->init();
        $this->assertTrue($component->getIsInitialized());
    }
}
