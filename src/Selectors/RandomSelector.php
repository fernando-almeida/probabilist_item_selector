<?php
/**
 * Implementation of the MultipleItemSelectorInterface
 *
 * Choose between eligible items randomly, ignoring any affinity with probability distributions
 *
 * @package      ItemsSelector
 * @author       Fernando Almeida <nanditu@gmail.com>
 */

namespace ItemsSelector\Selectors;

class RandomSelector implements MultipleItemSelectorInterface
{
  const NAME = "RandomSelector";

  public function getName()
  {
    return self::NAME;
  }
    
  public function select(\ItemsSelector\SelectorInterface $selector, array $eligible_items_idxs)
  {
    $idx = rand(0, count($eligible_items_idxs) - 1);
    return $eligible_items_idxs[ $idx ];
  }
}
