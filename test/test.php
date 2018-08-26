<?php

require_once dirname(__FILE__) . '/../lib/init.php';

use SG\LicensePlate\Checker;
use SG\LicensePlate\Detector;

$checker = new Checker;
var_dump($checker->check('SBS3229P'));

$detector = new Detector;
var_dump($detector->detect('My favourite bus is SBS3229P.'));

?>