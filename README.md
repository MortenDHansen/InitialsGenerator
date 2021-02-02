# Initials generator

## Description

Will try 5 times to generate initials from names based on priorities.

 1. If name has more than two parts (eg. George Walker Bush), it will use first letter of first name, first letter of first middlename and first letter of last name. "GWB". - If name had no middle part, it uses first letter of first name, and first two letters of last name. (Geroge Bush = GBU).
 2. If those were taken, use first two letters from first name, and first letter from last name
 3. If that was not available, and there was a middlename, try using first letter from first name and first two letters from middle name
 4. Use first letter from first name + first and last letter from last name. (George Bush = GBH)

## Usage
```php
<?php 
require_once "vendor/autoload.php";

$generator = new Generator();

// First argument is name, second is a list of initials that cannot be chosen.
$initials = $generator->generate('Peter Pingo Pan', ['ppa', 'ppe']);


```