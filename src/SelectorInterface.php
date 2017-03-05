<?php
/**
 * Interface definition for the implementation of selectors
 *
 * @package      ItemsSelector
 * @author       Fernando Almeida <nanditu@gmail.com>
 */

namespace ItemsSelector;

use \ItemsSelector\Selectors\MultipleItemSelectorInterface;

interface SelectorInterface
{
    
  /**
     * Retrieve the desired probability for the item at the given index
     * @param int index The position occupied by the item
     * @return Desired probability of item at the specified index
     */
  public function getDesiredProbability($index);

  /**
     * Retrieve the normalized desired probability distribution
     * @return Array with the normalized desired probability distribution for all items
     */
  public function getDesiredProbabilityDistribution();

  /**
     * Retrieve the current probability for the item at the given index
     * @param int index The position occupied by the item
     * @return Current probability of item at the specified index
     */
  public function getCurrentProbability($index);

  /**
     * Retrieve the normalized current probability distribution for the items
     * @return Array with the current probability distribution for the items
     */
  public function getCurrentProbabilityDistribution();


  /**
     * Retrieve the number of times the item was iterated
     * @param int index The position occupied by the item
     * @return Number of items the item at the given index was iterated
     */
  public function getItemCount($index);

  /**
     * Get the total number of times that items were requested
     * @return Total number of times that items were requested
     */
  public function getTotalCount();

  /**
     * Get instance that governs the selection of an eligible item
     * @return Instance that governs the selection of an eligible item
     */
  public function getMultipleItemSelector();

  /**
     * Get the raw item at the given index
     * @param int index The position occupied by the item
     * @return The item stored at the index
     */
  public function getItem($index);


  /**
     * Set the desired probability distribution for the items
     * @param array probDistribution Desired probability distribution for the items
     */
  public function setDesiredProbabilityDistribution(array $probDistribution);

  /**
    * Set initial count for all the items
    * @param array itemCount Array of counts for each item
    */
  public function setItemCount(array $itemCount);

  /**
    * Set the multiple item selector interface to use
    * @param MultipleItemSelectorInterface selector Multiple item selector instance
    */
  public function setMultipleItemSelector(MultipleItemSelectorInterface $selector);

  /**
    * Reset the item count of the current selector
    */
  public function reset();

  /**
     * Get array of all items
     * @return List of all items
     */
  public function getItems();
}
