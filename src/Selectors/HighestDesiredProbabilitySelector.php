<?php
/**
 * Implementation of the MultipleItemSelectorInterface
 *
 * Choose the eligible item with the highest desired probability in items order
 * If multiple items have the same probability it chooses the first one found in items order
 *
 * @package      ItemsSelector
 * @author       Fernando Almeida <nanditu@gmail.com>
 */

namespace ItemsSelector\Selectors;

class HighestDesiredProbabilitySelector implements MultipleItemSelectorInterface
{
  const NAME = "HighestDesiredProbabilitySelector";

  public function getName()
  {
    return self::NAME;
  }
    
  public function select(\ItemsSelector\SelectorInterface $selector, array $eligible_items_idxs)
  {
    $maxIdx = 0;
    $maxProb = $selector->getDesiredProbability($eligible_items_idxs[0]);
    for ($idx = 1; $idx < count($eligible_items_idxs); $idx++) {
      $newProb = $selector->getDesiredProbability($eligible_items_idxs[$idx]);
      if ( $newProb > $maxProb ) {
        $maxProb = $newProb;
        $maxIdx = $idx;
      }
    }

    return $eligible_items_idxs[$maxIdx];
  }
}
