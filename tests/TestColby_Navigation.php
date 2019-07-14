<?php

namespace Colby\Plugins\Colby_Navigation\Tests;

use \WP_UnitTestCase as WP_UnitTestCase;
use Colby\Plugins\Colby_Navigation\Colby_Navigation;

class TestColby_Navigation extends WP_UnitTestCase {
    public function test_get() {
        $colby_navigation = new Colby_Navigation( [ 'option' => true ] );

        $this->assertTrue( $colby_navigation->get( 'option' ) );
        $this->assertNull( $colby_navigation->get( 'other-option' ) );
    }
}