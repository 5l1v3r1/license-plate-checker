# Singapore Vehicle License Plate Checker
PHP library for checking Singapore Vehicle License Plates.
Created this to detect and validate license plates at work.

The algorithm is based on the [Wikipedia article on "Vehicle registration plates of Singapore"](https://en.wikipedia.org/wiki/Vehicle_registration_plates_of_Singapore#Checksum).

## Usage
Using the library is easy! Simply load the `lib/init.php` file through `require_once`.

```php
require_once dirname(__FILE__) . '/lib/init.php';
```

### Checking
Code:

```php
$checker = new Checker;
var_dump($checker->check('SBS3229P'));
```

Output:
```
bool(true)
```

### Detecting:
Code:

```php
$detector = new Detector;
var_dump($detector->detect('My favourite bus is SBS3229P.'));
```

Output:
```
array(1) {
  [0]=>
  string(8) "SBS3229P"
}
```

## Composer Installation
You can install the bindings via Composer. Run the following command:

```bash
composer require theroyalstudent/license-plate-checker
```

To use the bindings, use Composer's autoload:

```php
require_once 'vendor/autoload.php';
```

## Contributing
Please feel free to make open an issue if you encounter any issue with the library, or make a pull request if you've improved upon my library!

## Licenses

Copyright (C) 2018 [Edwin A.](https://theroyalstudent.com) \<edwin@theroyalstudent.com\>

This work is licensed under the GNU General Public License v3.0.

See `COPYING <COPYING>`_ to see the full text.