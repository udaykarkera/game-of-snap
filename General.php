<?php
Class General {

    public static function takeInput() {
        $handle = fopen("php://stdin","r");
        $line = fgets($handle);
        return trim($line);
    }

    public static function printLines(Array $printStmts) {
        echo implode(PHP_EOL,$printStmts) . PHP_EOL;
    }

}