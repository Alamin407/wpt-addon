<?php
namespace Wpt;

class Activate{
    public static function activate(){
        flush_rewrite_rules();
    }
}