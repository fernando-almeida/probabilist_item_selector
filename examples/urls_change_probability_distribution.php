<?php

require_once 'utils.php';

use \ItemsSelector\Selector;
use \ItemsSelector\Selectors\HighestDesiredProbabilitySelector;

/*
 * Data structure to support change of probability distribution after X requests
 */


// Translates to => [0.2, 0.3, 0.35, 0.15]
const ANY_RANGE_DISTRIBUTION =  [20, 30, 35, 15];

// Translates to => [0.3333333333, 0.1, 0.1333333333, 0.4333333333]
const NON_NORMALIZED_DISTRIBUTION =  [0.5, 0.15, 0.2, 0.65];

// No change => [0.15, 0.4, 0.25, 0.2] 
const NORMALIZED_DISTRIBUTION  = [0.15, 0.4, 0.25, 0.2];

const PROBABILITY_DISTRIBUTIONS_CONFIG = [
	[ "nrequests" => 15, "probDistribution" => ANY_RANGE_DISTRIBUTION ],

	[ "nrequests" => 10, "probDistribution" => NON_NORMALIZED_DISTRIBUTION ],
	[ "nrequests" => 12, "probDistribution" => NORMALIZED_DISTRIBUTION ]
];

$itemSelector = new HighestDesiredProbabilitySelector();
$selector = new Selector(TARGET_URLS, $itemSelector);

for ( $i= 0; $i < count(PROBABILITY_DISTRIBUTIONS_CONFIG); $i++ ) {
	$config = PROBABILITY_DISTRIBUTIONS_CONFIG[$i];
	$selector->setDesiredProbabilityDistribution($config["probDistribution"]);

	$msg = sprintf("Making %d requests with probability distribution to %s",
					$config["nrequests"],
					json_encode($config["probDistribution"]));
	echo PHP_EOL . $msg;
	chooseUrls( $selector, $config["nrequests"] );
	showStatistics( $selector, TARGET_URLS );
}


echo PHP_EOL;

?>