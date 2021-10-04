<?php

namespace App\Models;

use PDO;
use App\Utils\PropertyParser;

/**
 * BaseModel - All models extends this Model.
 *
 * @author      David Márquez <ibisdavi012@gmail.com>
 * @license     MIT
 *
 */
abstract class BaseModel
{

    protected $db_table;

    protected $errors = array();

    protected $db_connection_handle = null;

    protected $query_statement = null;

    protected $parseable_attributes;

    protected $custom_attributes;

    /**
     * Returns a list of the errors detected in any of the field values
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Logs an error.
     *
     * @param  string $source
     * @param  string $description
     * @return void
     */
    protected function logError($source, $description)
    {
        $this->errors[$source] = $description;
    }

    public function __construct($db_table)
    {
        $this->db_table = $db_table;
        $this->connect();
    }

    /**
     * Stablish the connection to the Database
     *
     * @return void
     */
    private function connect()
    {
        try {
            $dsn = sprintf("mysql:host=%s;dbname=%s", DATABASE_HOST, DATABASE_NAME);
            $this->db_connection_handle = new PDO($dsn, DATABASE_USER, DATABASE_PASSWORD);
        } catch (PDOException $e) {
            $this->logError("MYSQL_CONNECT", "MySQL connection error.");
        }
    }

    /**
     * Executes a query against the database.
     *
     * @param  string $query
     * @param  array $parameters
     * @return void
     */
    public function executeQuery($query, $parameters = array())
    {
        if (!$this->db_connection_handle) {
            return null;
        }
        $this->query_statement = $this->db_connection_handle->prepare($query);

        // Especificamos el fetch mode antes de llamar a fetch()
        $this->query_statement->setFetchMode(PDO::FETCH_ASSOC);

        // Bind parameters
        for ($paramIndex = 1; $paramIndex <= count($parameters); $paramIndex++) {
            $this->query_statement->bindParam($paramIndex, $parameters[$paramIndex - 1]);
        }

        // Execute query
        if (!$this->query_statement->execute()) {
            $this->logError('DATABASE_QUERY_EXECUTION', $this->query_statement->errorInfo());
            return false;
        }

        $query_result = array();

        while ($row = $this->query_statement->fetch()) {
            $query_result[] = $row;
        }

        if (strpos($query, 'INSERT') !== false) {
            return $this->db_connection_handle->lastInsertId();
        }

        if (strpos($query, 'DELETE') !== false || strpos($query, 'UPDATE') !== false) {
            return $this->query_statement->rowCount();
        }

        return $query_result;
    }

    /**
     * Returns an array of all elements in the table define in $db_table.
     *
     * @return array
     */
    protected function findAll()
    {
        return $this->executeQuery("SELECT * FROM {$this->db_table} ORDER BY id ASC");
    }

    /**
     * Delete one element by its ID
     *
     * @param  int $id
     * @return void
     */
    protected function deleteById($id)
    {
        return $this->executeQuery("DELETE FROM {$this->db_table} WHERE id = $id");
    }


    /**
     * Parses/Extracts attributes from a JSON string or an Array
     *
     * @param  array $source
     * @param  string $attributesList
     * @return void
     */
    private function parseAttributes($source, $attributesList)
    {

        if (is_null($source) || !$source) {
            return false;
        }

        foreach ($source as $column => $value) {
            $property = "set" . ucfirst($column);
            if (is_array($attributesList) && in_array($column, $attributesList)) {
                $this->$property($value);
            }
        }
    }

    /**
     * Extracts attributes from an array into their respective Fields
     *
     * @param  array $source
     * @return void
     */
    private function parseFromArray($source)
    {

        $this->parseAttributes($source, $this->parseable_attributes);

        $customAttributes = json_decode($source['custom_attributes'], true);

        $this->parseAttributes($customAttributes, $this->custom_attributes);
    }

    /**
     * Extracts attributes from a JSON string into their respective Fields
     *
     * @param  string $source
     * @return void
     */
    private function parseFromString($source)
    {
        $attributes = json_decode($source, true);
        $this->parseAttributes($attributes, $this->parseable_attributes);
        $this->parseAttributes($attributes, $this->custom_attributes);
    }


    /**
     * Parses a JSON or Array into the object's fields
     *
     * @param  mixed $source
     * @return void
     */
    public function parse($source)
    {

        if (is_array($source)) {
            $this->parseFromArray($source);
        } elseif (is_string($source)) {
            $this->parseFromString($source);
        } else {
            return null;
        }
    }

    /**
     * Find one Element by its ID
     *
     * @param  mixed $id
     * @return void
     */
    public function findById($id)
    {
        $result = $this->executeQuery("SELECT * FROM {$this->db_table} WHERE id = $id");

        if (count($result)) {
            $type = "App\\Models\\" . ucfirst($result[0]['type']);

            $model = !class_exists($type, true) ? new Product() : new $type();

            $model->parse($result[0]);

            return $model->toArray();
        }

        return null;
    }

    abstract public function toArray();
    abstract public function save();
    abstract public function delete();
    abstract public function update();
}
