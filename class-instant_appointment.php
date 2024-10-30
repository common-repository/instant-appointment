<?php
class Instant_appointment{
  private static $_instance = null;

    public $_version;

    public function __construct ( $file = '', $version = '1.5.27' ) {
        $this->_version = $version;
    }

    public static function instance ( $file = '', $version = '1.2.1' ) {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self( $file, $version );
        }
        return self::$_instance;
    } // End instance ()
} ;
