<?php
namespace Wpt;

class Deactivate{
    public static function deactivate(){
        flush_rewrite_rules();
    }
}