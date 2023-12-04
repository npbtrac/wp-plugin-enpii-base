<?php

namespace Enpii_Base\Tests\Unit\Foundation\Database;

use Enpii_Base\Tests\Support\Unit\Libs\Unit_Test_Case;
use Enpii_Base\Foundation\Database\Wpdb_Connection;
use PDO;

class Wpdb_Connection_Test extends Unit_Test_Case {

	/**
	 * @throws \ReflectionException
	 */
	public function test_constructor() {
		$pdoMock = $this->getMockBuilder( PDO::class )
						->disableOriginalConstructor()
						->getMock();
		$config  = [
			'wpdb' => 'mock_wpdb_instance',
		];

		$wpdb_connection = new Wpdb_Connection( $pdoMock, 'database', 'prefix', $config );
		$property_value  = $this->get_class_property_value( $wpdb_connection, 'wpdb' );

		// Verify that the $wpdb property is set correctly
		$this->assertEquals( 'mock_wpdb_instance', $property_value );
	}
}
