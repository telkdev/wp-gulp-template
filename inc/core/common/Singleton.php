<?php

if ( ! trait_exists( 'Singleton' ) ) {

    trait Singleton {
        static private $instance = null;

        private function __construct() {
        }

        private function __clone() {
        }

        private function __wakeup() {
        }

        static public function get_instance() {

            return ( self::$instance === null ) ? self::$instance = new static() : self::$instance;
        }
    }
}
