Simple pattrn hash array demo for https://www.linux.org.ru/forum/development/13492726

```php
$hash = new PatternHashArray();

$hash[['^(any|key|be|no|key)$', PatternHashArray::REGEXP]] = 'value';
$hash['hello'] = 'world';
$hash[['foo*bar', PatternHashArray::GLOB]] = 'Dummy staff';

dump(
	$hash['any'],
	$hash['hello'],
	$hash['fooizmus lebart'],
	$hash['fooizmus lebar']
);
```

Result:

```
"value"
"world"
NULL
"Dummy staff"

```
