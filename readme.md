# Leven Database Adapter Interface

## Features
- 🧪 abstract access to the database
- 🏗 simple query builder with nested conditions support
- 🔐 automatic escaping of table and column names and values

## Usage examples

### Select
```php
$result = $db->select('foo_table')
    ->columns('id', 'name') // optional, defaults to all columns
    ->where('id', '>', 1)->orWhere('age', '>', 22)
    ->orWhere(fn(\Leven\DBA\Common\BuilderPart\WhereGroup $w) => $w
        ->where('name', 'IN', ['Foo', 'Bar'])
        ->andWhere('description', 'LIKE', '%foo%')
    )
    ->orderDesc('id')->orderAsc('name')
    ->limit(1)->offset(1)
    ->execute();

foreach($result as $row) {} // you can iterate over the rows
$result->rows; // or access the rows as an array
$result->count; // count of rows returned
```

### Insert
```php
$result = $db->insert('foo_table', ['name' => 'Foo']);

$result->lastId; // last inserted id (auto increment) or null
```

### Update
```php
$db->update('foo_table')
    ->set('name', 'Foo')
    ->where('id', '!=', 3)
    ->limit(10)
    ->execute();
```

### Delete
```php
$db->delete('foo_table')
    ->where('id', 5)
    ->limit(11)
    ->execute();
```

## Implementations

### 📦 MySQL
```shell
composer require leven-framework/dba-mysql
```

```php
require 'vendor/autoload.php';

// all arguments are optional except for database
$db = new \Leven\DBA\MySQL\MySQLAdapter(
    database: 'example',
    user: 'username',
    password: 'password',
    host: 'localhost',
    port: 3306,
    charset: 'utf8',
    tablePrefix: 'prefix_'
);

// or use an existing PDO instance
$db = new \Leven\DBA\MySQL\MySQLAdapter($pdo);
```

### 📦 Mock
```shell
composer require leven-framework/dba-mock
```
```php
require 'vendor/autoload.php';

// saving and loading the database in JSON is slow but useful for development
$db = new \Leven\DBA\Mock\MockAdapter(
    fn() => json_decode(file_get_contents('db.json'), true),
    fn(\Leven\DBA\Mock\Structure\Database $db) => file_put_contents('db.json', json_encode($db->toArray(), JSON_PRETTY_PRINT))
);

// first argument can also be an array representing the database
$dbArray = [
    'foo_table' => [
        ['id' => 'int', 'name' => 'varchar'],
        [1, 'Foo'],
        [2, 'Bar'],
    ],
];
```