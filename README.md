# Probabilistic ItemSelector PHP Library

## Description
This library enables you to continuosly traverse a set of items based on a given probability distribution and selection strategy to use when multiple eligible items are found.

The library is organized around to 2 interfaces:

* **SelectorInterface**: abstracts the logic that computes the selection of the next eligible item. Can also be used to keep track of the items being selected.
* **MultipleItemSelectorInterface**:  abstracts the logic that decides how an item should be selected among a set of multiple eligible items.

### Selector
A generic selector implementation has been provided which keeps track of the total number of times an item has been traversed. Additionaly, this selector supports the parametrization of the following features during object creation and also during runtime execution:

* Desired probability distribution
* Initial item count
* Multiple item selector strategy

During runtime this selector supports querying of the following data:

* Current probability distribution for items
* Traversal count: per item and total
* Item values

### Multiple eligible items selection strategies
A selection strategy is used to decide how the next item should be chosen when there are several that are eligible.
The following strategies have been implemented:

* **Random**: Choose a random item among all the eligible items
* **First Item**: Choose the first elegible item based on the initial item ordering
* **Highest Desired Probability**: Choose the eligible item with the highest desired probability
* **Lowest Desired Probability**: Choose the eligible with the lowest desired probability
* **Highest Current Probability**: Choose the eligible item with the highest current probability
* **Lowest Current Probability**: Choose the eligible with the lowest current probability


## Requirements
* [PHP 5.4.0 or higher](http://www.php.net/)

## Installation ##


# Examples
See the [`examples/`](examples) directory for examples of the key library features.
Run any example using the PHP CLI
```sh
php 'path/to/example/example.php'
```

## Code Quality ##

Run the PHPUnit tests with PHPUnit from the root directory.
```sh
phpunit
```

### Coding Style

To check for coding style violations, run

```
vendor/bin/phpcs src --standard=style/ruleset.xml -np
```

To automatically fix (fixable) coding style violations, run

```
vendor/bin/phpcbf src --standard=style/ruleset.xml
```