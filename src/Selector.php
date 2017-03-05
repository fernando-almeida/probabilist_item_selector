<?php
/**
 * General implementation of the SelectorInterface
 *
 * @package      ItemsSelector
 * @author       Fernando Almeida <nanditu@gmail.com>
 */

namespace ItemsSelector;

use \ItemsSelector\Selectors\MultipleItemSelectorInterface;

/**
 * @implements SelectorInterface
 */
class Selector implements SelectorInterface
{

  private $items;
  private $desiredProbDistribution;

  private $multipleItemSelector;
  private $itemCount;
  private $totalCount;

  private $key;
  private $current;

     

  public function __construct(
      array $items,
      MultipleItemSelectorInterface $multipleItemSelector,
      array $desiredProbDistribution = null
  ) {
    if ( $items == null || count($items) == 0 ) {
      throw new AssertionError("Items cannot be NULL nor empty");
    }

    $this->items = $items;
    $this->multipleItemSelector = $multipleItemSelector;

    if ( $desiredProbDistribution == null ) {
      $totalWeight = 1.0;
      $equal_item_prob = $totalWeight / count($items);
      $this->desiredProbDistribution = array_fill(0, count($items), $equal_item_prob);
    } else {
      if ( count($items) != count($desiredProbDistribution) ) {
        $msg = sprintf(
            "Number of items (%d) and desired probabitily entries (%d) mismatch",
            count($items),
            count($desiredProbDistribution)
        );
        throw new AssertionError($msg);
      }

      // Normalize desired probability distribution
      $this->desiredProbDistribution = $this->normalize($desiredProbDistribution);
    }
        
    $this->reset();
    $this->key = null;
  }


  /**
     * Find indices of eligible items to be retrieved
     * @return Array of indices of eligible items
     */
  private function findEligibleItems()
  {
    $eligible_item_idxs = [];
    if ( $this->totalCount == 0 ) {
      for ($idx= 0; $idx < count($this->items); $idx++) {
        array_push($eligible_item_idxs, $idx);
      }
    } else {
      for ($idx = 0; $idx < count($this->items); $idx++) {
        $itemProb = $this->getCurrentProbability($idx);
        if ( $itemProb <= $this->desiredProbDistribution[$idx] ) {
          array_push($eligible_item_idxs, $idx);
        }
      }
    }

    return $eligible_item_idxs;
  }

  /**
     * Normalize an array of values to the range [0,1]
     * @param array values Array of values to normalize
     * @return Normalize array of values
     */
  private function normalize(array $values)
  {
    $total = array_sum($values);
    for ($idx = 0; $idx < count($values); $idx++) {
      $values[$idx] /= $total;
    }

    return $values;
  }

  /**
     * Get current value
     */
  public function current()
  {
    if ( $this->key === null ) {
      throw new AssertionError("Current index is NULL");
    }

    return $this->items[ $this->key ];
  }

  /**
     * Get current value's key
     */
  public function key()
  {
    if ( $this->key === null ) {
      throw new AssertionError("Current index is NULL");
    }

    return $this->key;
  }

  public function next()
  {
    $eligible_item_idxs = [];

    /*
    * Identify eligible items to be selected
    */
    $eligible_item_idxs = $this->findEligibleItems();

    $selectedIndex = null;
    switch ( count($eligible_item_idxs) ) {
      case 0:
        throw new Exception("Could not find an eligible item to be selected");
      break;
      case 1:
        $selectedIndex = $eligible_item_idxs[0];
        break;
      default:
        /*
        * Use strategy to select among several
        */
        $selectedIndex = $this->multipleItemSelector->select($this, $eligible_item_idxs);
        break;
    }

    if ( $selectedIndex === null ) {
      throw new Exception("An index was not selected (NULL)");
    }

    // Update item count
    $this->itemCount[ $selectedIndex ] += 1;

    // Update total count
    $this->totalCount += 1;

    // Update the  current item
    $this->key = $selectedIndex;
  }

  /**
     * As an iterator this is always valid
     */
  public function valid()
  {
    return $this->key !== null;
  }


  // IMPLEMENTATION OF SELECTOR INTERFACE
    
  public function getDesiredProbability($index)
  {
    assert($index >= 0 && $index < count($this->items));

    return $this->desiredProbDistribution[$index];
  }

  public function getDesiredProbabilityDistribution()
  {
    return $this->desiredProbDistribution;
  }

  public function getCurrentProbability($index)
  {
    assert($index >= 0 && $index < count($this->items));

    return $this->totalCount == 0
    ? 0
    : 1.0 * $this->itemCount[$index] / $this->totalCount;
  }

  public function getCurrentProbabilityDistribution()
  {
    $probDistribution = [];
    for ($i = 0; $i < count($this->items); $i++) {
      array_push($probDistribution, $this->getCurrentProbability($i));
    }

    return $probDistribution;
  }

  public function getItemCount($index)
  {
    assert($index >= 0 && $index < count($this->items));

    return $this->itemCount[$index];
  }

  public function getTotalCount()
  {
    return $this->totalCount;
  }

  public function getMultipleItemSelector()
  {
    return $this->multipleItemSelector;
  }

    
  public function getItem($index)
  {
    assert($index >= 0 && $index < count($this->items));

    return $this->items[$index];
  }


  public function getItems()
  {
    return $this->items;
  }

  public function setDesiredProbabilityDistribution(array $probDistribution)
  {
    if ( count($probDistribution) != count($this->items) ) {
      $msg = sprintf(
          "Number of entries in probability distribution (%d) and current number of items (%d) mismatch",
          count($probDistribution),
          count($this->items)
      );
      throw new AssertionError($msg);
    }

    $this->desiredProbDistribution = $this->normalize($probDistribution);

    return $this;
  }

  public function setItemCount(array $itemCount)
  {
    if ( count($itemCount) != count($this->items) ) {
      $msg = sprintf(
          "Number of entries in item Count (%d) and current number of items (%d) mismatch",
          count($itemCount),
          count($this->items)
      );
      throw new AssertionError($msg);
    }
    $this->itemCount = $itemCount;
    $this->totalCount = array_sum($itemCount);
    $this->key = null;

    return $this;
  }

  public function setMultipleItemSelector(MultipleItemSelectorInterface $selector)
  {
    $this->multipleItemSelector = $selector;

    return $this;
  }

  public function reset()
  {
    $this->itemCount = array_fill(0, count($this->items), 0);
    $this->totalCount = 0;
  }


  // MAGIC METHODS
  public function __toString()
  {
    $str = "Items=" . json_encode($this->items) . PHP_EOL;
    $str .= "ItemSelector=" . $this->multipleItemSelector->getName() . PHP_EOL;
    $str .= "DesiredProbDistribution=" . json_encode($this->desiredProbDistribution) . PHP_EOL;
    $str .= "CurrentProbDistribution=" . json_encode($this->getCurrentProbabilityDistribution()) . PHP_EOL;
    $str .= "CurrentItem=" . ($this->key === null ? "NULL" : "Item=" . $this->current() . " Key=" . $this->key());

    return $str;
  }
}
