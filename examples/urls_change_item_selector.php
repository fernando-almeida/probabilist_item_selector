<?php

require_once 'utils.php';

use \ItemsSelector\Selector;
use \ItemsSelector\Selectors\HighestDesiredProbabilitySelector;
use \ItemsSelector\Selectors\FirstItemSelector;
use \ItemsSelector\Selectors\LowestCurrentProbabilitySelector;
use \ItemsSelector\Selectors\RandomSelector;

/*
 * Data structure to support change item selector interface after X requests
 */


$ITEMS_SELECTORS_CONFIG = [
	[ "nrequests" => 13, "itemSelector" => new HighestDesiredProbabilitySelector() ],
	[ "nrequests" => 15, "itemSelector" => new FirstItemSelector() ],
	[ "nrequests" => 12, "itemSelector" => new LowestCurrentProbabilitySelector() ],
];


$selector = new Selector(TARGET_URLS, new RandomSelector(), UNEQUAL_PROB_DISTRIBUTION);

for ( $i = 0; $i < count($ITEMS_SELECTORS_CONFIG); $i++ ) {
	$config = $ITEMS_SELECTORS_CONFIG[$i];
	$itemSelector = $config["itemSelector"];
	$selector->setMultipleItemSelector($itemSelector);

	$msg = sprintf("Making %d requests with item selector %s",
					$config["nrequests"],
					$itemSelector->getName());
	echo PHP_EOL . $msg;
	echo PHP_EOL;
	chooseUrls( $selector, $config["nrequests"] );
	showStatistics( $selector, TARGET_URLS );
}

echo PHP_EOL;

?>