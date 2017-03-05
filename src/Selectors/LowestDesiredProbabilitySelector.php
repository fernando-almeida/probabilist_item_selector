<?php
/**
 * Implementation of the MultipleItemSelectorInterface
 *
 * Choose the eligible item with the lowest desired probability in items order
 * If multiple items have the same probability it chooses the first one found in items order
 *
 * @package      ItemsSelector
 * @author       Fernando Almeida <nanditu@gmail.com>
 */

namespace ItemsSelector\Selectors;

class LowestDesiredProbabilitySelector implements MultipleItemSelectorInterface
{
  const NAME = "LowestDesiredProbabilitySelector";

  public function getName()
  {
    return self::NAME;
  }
    
  public function select(\ItemsSelector\SelectorInterface $selector, array $eligible_items_idxs)
  {
    $minIdx = 0;
    $minProb = $selector->getDesiredProbability($eligible_items_idxs[0]);
    for ($idx = 1; $idx < count($eligible_items_idxs); $idx++) {
      $newProb = $selector->getDesiredProbability($eligible_items_idxs[$idx]);
      if ( $newProb < $minProb ) {
        $minProb = $newProb;
        $minIdx = $idx;
      }
    }

    return $eligible_items_idxs[$minIdx];
  }
}
