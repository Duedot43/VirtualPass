<?php

/** 
 * Custom modules
 * 
 * PHP version 8.1
 * 
 * @file     /src/include/customModules.php
 * @category Functions
 * @package  VirtualPass
 * @author   Jack <duedot43@noreplay-github.com>
 * @license  https://mit-license.org/ MIT
 * @link     https://github.com/Duedot43/VirtualPass
 */
// TODO make auto detect with this
/**
 * Parse a CSV file
 *
 * @param string $file Is the CSV file you want to parse into an array
 * 
 * @return array returns the CSV file as an array
 */
function parseCsv(string $file)
{
    return array_map(
        'str_getcsv',
        explode("\n", $file)
    );
}
/**
 * Can import?
 *
 * @return boolean
 */
function canImport(): bool
{
    return false;
}
/**
 * Decompile admin csv file
 *
 * @param string $csv The CSV file to be decompiled
 * 
 * @return array
 */
function decompileAdmin(string $csv): array
{
    $csv = parseCsv($csv);
    $output = array();
    foreach ($csv as $section) {
        $output[] = array("uname" => $csv[0], "passwd" => $csv[1], "uuid");
    }
    return $output;
}
/**
 * Decompile teacher CSV
 *
 * @param string $csv The CSV file to be decompiled
 * 
 * @return array
 */
function decompileTeacher(string $csv): array
{
    return array();
}
/**
 * Decompile user CSV
 *
 * @param string $csv The CSV file to be decompiled
 * 
 * @return array
 */
function decompileUser(string $csv): array
{
    return array();
}
/**
 * Decompile room CSV
 *
 * @param string $csv The CSV file to be decompiled
 * 
 * @return array
 */
function decompileRoom(string $csv): array
{
    return array();
}
