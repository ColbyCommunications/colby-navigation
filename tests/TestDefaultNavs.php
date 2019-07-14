<?php

namespace Colby\Plugins\Colby_Navigation\Tests;

use \WP_UnitTestCase as WP_UnitTestCase;
use function Colby\Plugins\Colby_Navigation\horizontal_header_nav_configuration;

class TestDefaultNavs extends WP_UnitTestCase {
    public function test_horizontal_header_nav_configuration() {
        $config = horizontal_header_nav_configuration();

        $this->assertEquals( 2, count( $config['filters'] ) );
    }
}