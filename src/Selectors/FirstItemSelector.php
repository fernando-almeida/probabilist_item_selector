<?php
/**
 * Implementation of the MultipleItemSelectorInterface that chooses the first item from a set of eligible items
 *
 * @package      ItemsSelector
 * @author       Fernando Almeida <nanditu@gmail.com>
 */


namespace ItemsSelector\Selectors;

class FirstItemSelector implements MultipleItemSelectorInterface
{
  const NAME = "FirstItemSelector";

  public function getName()
  {
    return self::NAME;
  }

  public function select(\ItemsSelector\SelectorInterface $selector, array $eligible_items_idxs)
  {
    return $eligible_items_idxs[0];
  }
}
