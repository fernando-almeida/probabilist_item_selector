<?php

use ItemsSelector\Selector;
use ItemsSelector\SelectorInterface;
use ItemsSelector\Selectors\FirstItemSelector;
use ItemsSelector\Selectors\LowestCurrentProbabilitySelector;
use ItemsSelector\Selectors\LowestDesiredProbabilitySelector;
use ItemsSelector\Selectors\HighestDesiredProbabilitySelector;


use PHPUnit\Framework\TestCase;

class ItemsSelectorTest extends TestCase
{
	const MAX_ITERATIONS = 8;
	const UNEQUAL_PROB_DISTRIBUTION = [0.2, 0.3, 0.35, 0.15];

	const ITEMS = ["Url1", "Url2", "Url3", "Url4"];


	/**
	 * Build the expected output array for a equal distribution of items
	 * @return Array of item values for an equal distribution of items
	 */ 
	private static function buildEqualDistributionProbability( array $items ) {
		$probDistribution = [];
    	for ( $i=0; $i < count( $items ); $i++ ) {
    		array_push( $probDistribution, 1.0 / count($items) );
    	}
    	return $probDistribution;
	}

	/**
	 * Build the expected output array for a equal distribution of items
	 * @return Array of item values for an equal distribution of items
	 */ 
	private static function buildEqualDistributionExpectedOutput( array $items ) {
		$expectedOutput = [];
    	for ( $i=0; $i < self::MAX_ITERATIONS; $i++ ) {
    		array_push( $expectedOutput, $items[$i % count($items)] );
    	}
    	return $expectedOutput;
	}


	/**
	 * Helper function to build expected output from an array of indexes
	 * @param array indexes Array of ordered item indexes that represent the output
	 * @return Array item values based on the provided ordered indexes
	 */
	private static function buildExpectedOutputFromIndexes( array $indexes, array $items ) {
		$output = [];
		foreach ( $indexes as $idx ) {
			array_push( $output, $items[$idx] );
		}

		return $output;
	}


	/**
	 * Build output array for a given selector based on a maximum number of iterations
	 */
	private static function buildOutput( SelectorInterface $selector, $maxIterations = self::MAX_ITERATIONS ) {
		$output = [];
		for ( $i = 0; $i < $maxIterations ; $i++ ) {
			$selector->next();
			$nextItem = $selector->current();
			array_push($output, $nextItem);
		}

		return $output;
	}

	/**
	 *
	 */
    public function testEqualDistributionImplicit()
    {   	
    	$itemSelector = new LowestCurrentProbabilitySelector();
    	$selector = new Selector( self::ITEMS, $itemSelector);

    	$expectedOutput = self::buildEqualDistributionExpectedOutput( self::ITEMS );

    	$output = self::buildOutput( $selector, count( $expectedOutput ) );

    	$this->assertEquals($output, $expectedOutput);
    }

	/**
	 *
	 */
    public function testEqualDistributionExplicit()
    {   	
    	$itemSelector = new LowestCurrentProbabilitySelector();
    	$desiredProbDistribution = self::buildEqualDistributionProbability( self::ITEMS );
    	$selector = new Selector(self::ITEMS, $itemSelector, $desiredProbDistribution);

    	$expectedOutput = self::buildEqualDistributionExpectedOutput( self::ITEMS );

    	$output = self::buildOutput( $selector, count( $expectedOutput ) );

    	$this->assertEquals( $output, $expectedOutput );
    }


	/**
	 *
	 */
	public function testHighestDesiredProbabilityFirst() {
		$itemSelector = new HighestDesiredProbabilitySelector();
		$desiredProbDistribution = [0.2, 0.3, 0.35, 0.15];
		$selector = new Selector( self::ITEMS, $itemSelector, $desiredProbDistribution );

		$expectedOutputIndexes = [ 2, 1, 0, 2, 1, 0, 2, 1, 3 ];
		$expectedOutput = self::buildExpectedOutputFromIndexes( $expectedOutputIndexes, self::ITEMS );

		$output = self::buildOutput( $selector, count( $expectedOutput ) );

		$this->assertEquals( $output, $expectedOutput );
	}

	/**
	 *
	 */
	public function testLowestDesiredProbabilityFirst() {
		$itemSelector = new LowestDesiredProbabilitySelector();
		$desiredProbDistribution = [0.2, 0.3, 0.35, 0.15];
		$selector = new Selector( self::ITEMS, $itemSelector, $desiredProbDistribution);

		$expectedOutputIndexes = [ 3, 0, 1, 2, 1, 0, 2, 3, 1 ];
		$expectedOutput = self::buildExpectedOutputFromIndexes( $expectedOutputIndexes, self::ITEMS );
		

		$output = self::buildOutput( $selector, count( $expectedOutput ) );

		$this->assertEquals( $output, $expectedOutput );
	}

}

?>