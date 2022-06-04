# nova-persian-date
Persian Date Field for Laravel Nova

## Installation

You can install the package via composer:

```bash
composer require amidesfahani/nova-persian-date
```
The package will automatically register itself.

## Examples
```php
NovaPersianDate::make('Join Date', 'created_at')
    ->min('lastmonth')
    ->max('nextday')
    ->format('jYYYY-jMM-jDD')
    ->formats([
        'FormField' => 'jYYYY/jMM/jDD HH:mm',
        'IndexField' => 'jYYYY/jMM/jDD',
        'DetailField' => 'jYYYY/jMM/jDD HH:mm'
    ])
    ->humanize()
    ->type('datetime')
    ->sortable(),
```

```css
.vpd-dir-rtl {
  font-family: 'IranSans'
}
.vpd-dir-ltr {
  font-family: 'Tahoma'
}
```

# Alternatives

* [dpsoft/nova-persian-date](https://github.com/dpsoft-official/nova-persian-date)

## Licence
This package is [Treeware](https://treeware.earth). If you use it in production, then we ask that you [**buy the world a tree**](https://plant.treeware.earth/https://github.com/amidesfahani/nova-persian-date) to thank us for our work. By contributing to the Treeware forest you’ll be creating employment for local families and restoring wildlife habitats.