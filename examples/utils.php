<?php

require_once __DIR__ . '/../vendor/autoload.php';

use \ItemsSelector\SelectorInterface;

const UNEQUAL_PROB_DISTRIBUTION = [0.2, 0.3, 0.35, 0.15];

const MAX_REQUESTS = 37;
const TARGET_URLS = [ "http://www.example.com/prod1",
		 		      "http://www.example.com/prod2", 
			    	  "http://www.example.com/prod3", 
			    	  "http://www.example.com/prod4"];

function chooseUrls( SelectorInterface $selector, $numIterations = MAX_REQUESTS ) {

	echo PHP_EOL . "Selector Details";
	echo PHP_EOL . $selector;

	echo PHP_EOL . PHP_EOL . "Chosen URLs";
	for ( $i = 0; $i < $numIterations ; $i++ ) {
		$selector->next();
		$nextUrlKey = $selector->key();
		$nextUrlValue = $selector->current();
		
		$msg = sprintf("#%d\tURL=%s\tKey=%d",
						$i,
						$nextUrlValue ,
						$nextUrlKey );
		
		echo PHP_EOL . $msg;

		echo PHP_EOL . "CurrentProbDistribution=" 
					 . json_encode($selector->getCurrentProbabilityDistribution());
	}
}

function showStatistics( SelectorInterface $selector, array $urls ) {
	// Get Target URL counts
	echo PHP_EOL . PHP_EOL . "Selector Statistics";
	for ( $i = 0; $i < count($urls); $i++ ) {
		$msg = sprintf("#%d URL=%s\tCount=%d\tPercentage=%.2f%%",
						$i,
						$urls[$i],
						$selector->getItemCount($i),
						1.0 * $selector->getItemCount($i) / $selector->getTotalCount() * 100 );
		
		echo PHP_EOL . $msg;
	}
	
}

?>