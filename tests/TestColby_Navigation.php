<?php

namespace Colby\Plugins\Colby_Navigation\Tests;

use \WP_UnitTestCase as WP_UnitTestCase;
use Colby\Plugins\Colby_Navigation\{Colby_Navigation, Navigation_Menu};

class TestColby_Navigation extends WP_UnitTestCase {
    public function test_get() {
        $colby_navigation = new Colby_Navigation( [ 'option' => true ] );

        $this->assertTrue( $colby_navigation->get( 'option' ) );
        $this->assertNull( $colby_navigation->get( 'other-option' ) );
    }

    public function test_get_menus() {
        $menus = colby_navigation( true )->get_menus();

        $this->assertCount( 1, $menus );
        $this->assertInstanceOf( Navigation_Menu::class, reset( $menus ) );
    }

    public function test_create_menu() {
        $this->assertNull( colby_navigation( true )->create_menu( [] ) );
    }
}