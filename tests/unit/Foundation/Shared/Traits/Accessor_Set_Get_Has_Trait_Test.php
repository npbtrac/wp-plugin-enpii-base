<?php

namespace Enpii_Base\Tests\Unit\Foundation\Shared\Traits;

use Enpii_Base\Foundation\Shared\Traits\Accessor_Set_Get_Has_Trait;
use Enpii_Base\Tests\Support\Unit\Libs\Unit_Test_Case;

class Accessor_Set_Get_Has_Trait_Test extends Unit_Test_Case {
	private $dummy_obj;

	protected function setUp(): void {
		// Create a dummy class that uses the Config_Trait
		$this->dummy_obj = new class() {
			use Accessor_Set_Get_Has_Trait;

			public $property1;
			public $property2;
		};
	}

	public function test_set_property(): void {
		// Set a property using the set_property method
		$this->dummy_obj->set_property( 'property1', 'value' );

		// Assert that the property value is set correctly
		$this->assertEquals( 'value', $this->dummy_obj->get_property( 'property1' ) );
	}

	public function test_get_property(): void {
		// Set new properties
		$this->dummy_obj->property1 = 'value1';
		$this->dummy_obj->property2 = 'value2';
		$result1 = $this->dummy_obj->get_property( 'property1' );
		$result2 = $this->dummy_obj->get_property( 'property2' );

		// Assert that the property value is get correctly
		$this->assertEquals( 'value1', $result1 );
		$this->assertEquals( 'value2', $result2 );
	}

	public function test_has_sroperty(): void {
		// Set new properties
		$this->dummy_obj->property1 = 'value1';
		$result1 = $this->dummy_obj->has_property( 'property1' );

		// Assert that the property exists
		$this->assertTrue( $result1 );
	}

	public function test_non_existing_method_throws_exception() {
		$this->expectException( \BadMethodCallException::class );
		$this->dummy_obj->nonExistingMethod();
	}
}
