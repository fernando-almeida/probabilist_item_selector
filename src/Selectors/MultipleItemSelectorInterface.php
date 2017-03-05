<?php
/**
 * Interface definition that abstracts the selection of an item from a set of eligible items
 *
 * @package      ItemsSelector
 * @author       Fernando Almeida <nanditu@gmail.com>
 */


namespace ItemsSelector\Selectors;

use \ItemsSelector\SelectorInterface;

interface MultipleItemSelectorInterface
{
  
  /**
     * Calculate the index of the eligible items that should be chosen according to the selection strategy
     * @param SelectorInterface Selector interface from which to retrieve metadata
     * @param array eligible_items_idxs
     * @return Index of the eligible item that should be selected
     */
  public function select(SelectorInterface $selector, array $eligible_items_idxs);

  /**
     * Get the selector's instance name
     * @return Selector's instance name
     */
  public function getName();
}
