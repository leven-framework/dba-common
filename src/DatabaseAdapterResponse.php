<?php namespace Leven\DBA\Common;

use ArrayIterator, ArrayObject, IteratorAggregate;

class DatabaseAdapterResponse implements IteratorAggregate {

    public function __construct(
        public string|null $query = null,
        public int $count = 0,
        public array $rows = [],
        public array|null $row = null,
        public int|string|null $lastID = null
    ) { }

    public function getIterator(): ArrayIterator
    {
        $o = new ArrayObject($this->rows);
        return $o->getIterator();
    }
}