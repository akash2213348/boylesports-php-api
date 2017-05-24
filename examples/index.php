<?php
/**
 * Boylesports PHP implementation.
 *
 * (c) Alexander Sharapov <alexander@sharapov.biz>
 * http://sharapov.biz/
 *
 */

require_once "../vendor/autoload.php";

$api = new \Sharapov\BoylesportsPHP\BoylesportsAPI();

// Request examples

// get sports list
$response = $api->index()->json();

// get FOOTBALL bets
$response = $api->EURFOOTBALL()->json();

print '<pre>';
print_r( json_decode($response->getBody()->getContents()) );
print '</pre>';