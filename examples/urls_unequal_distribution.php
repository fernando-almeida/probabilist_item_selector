<?php

require_once 'utils.php';

use \ItemsSelector\Selector;
use \ItemsSelector\Selectors\HighestDesiredProbabilitySelector;

$itemSelector = new HighestDesiredProbabilitySelector();
$selector = new Selector(TARGET_URLS, $itemSelector, UNEQUAL_PROB_DISTRIBUTION);

chooseUrls( $selector, MAX_REQUESTS );
showStatistics( $selector, TARGET_URLS );

echo PHP_EOL;


?>