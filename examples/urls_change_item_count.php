<?php

require_once 'utils.php';

use \ItemsSelector\Selector;
use \ItemsSelector\Selectors\HighestDesiredProbabilitySelector;

$itemSelector = new HighestDesiredProbabilitySelector();
$selector = new Selector(TARGET_URLS, $itemSelector, UNEQUAL_PROB_DISTRIBUTION);


chooseUrls($selector, MAX_REQUESTS );
showStatistics( $selector, TARGET_URLS );

// Reset selector and start over
echo PHP_EOL . PHP_EOL . "Selector reset";
$selector->reset();
chooseUrls($selector, MAX_REQUESTS);
showStatistics( $selector, TARGET_URLS );

// Reset selector and start over
echo PHP_EOL . PHP_EOL . "Selector set initial item count";
$selector->setItemCount( [ 30, 15, 10, 40 ] );

echo PHP_EOL . PHP_EOL . "Selector initial statistics";
showStatistics( $selector, TARGET_URLS );
chooseUrls($selector, MAX_REQUESTS);

echo PHP_EOL . PHP_EOL . "Selector final statistics";
showStatistics( $selector, TARGET_URLS );

echo PHP_EOL;

?>