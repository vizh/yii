<?php
class CTypedMapTestFoo {}
class CTypedMapTestBar {}

/**
 * CTypedMapTest
 */
class CTypedMapTest extends CTestCase
{
	public function testAddRightType()
	{
		$typedMap = new CTypedMap('CTypedMapTestFoo');
		$typedMap->add(0, new CTypedMapTestFoo());

        // assertExceptionNotThrown()
        $this->assertTrue(true);
    }

	public function testAddWrongType()
	{
		$this->expectException('CException');

		$typedMap = new CTypedMap('CTypedMapTestFoo');
		$typedMap->add(0, new CTypedMapTestBar());
	}
}