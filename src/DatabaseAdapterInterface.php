<?php namespace Leven\DBA\Common;

use Leven\DBA\Common\Exception\{ArgumentValidationException, Driver\DriverException, EmptyResultException};

interface DatabaseAdapterInterface {

    public function escapeValue(string $string);
    public function escapeName(string $string);

    /**
     * @throws DriverException
     */
    public function schema(string $table): array;

    /**
     * @throws DriverException
     */
    public function count(string $table): int;

    /**
    * @throws ArgumentValidationException
    * @throws DriverException
    * @throws EmptyResultException
    */
    public function get(string $table, array|string $columns = '*', array $conditions = [], array $options = []): DatabaseAdapterResponse;

    /**
    * @throws ArgumentValidationException
    * @throws DriverException
    */
    public function insert(string $table, array $data): DatabaseAdapterResponse;

    /**
    * @throws ArgumentValidationException
    * @throws DriverException
    */
    public function update(string $table, array $data, array $conditions = [], array $options = []): DatabaseAdapterResponse;

    /**
    * @throws ArgumentValidationException
    * @throws DriverException
    */
    public function delete(string $table, array $conditions = [], array $options = []): DatabaseAdapterResponse;



    /**
    * @throws DriverException
    */
    public function txnBegin();

    /**
    * @throws DriverException
    */
    public function txnCommit();

    /**
    * @throws DriverException
    */
    public function txnRollback();

}
