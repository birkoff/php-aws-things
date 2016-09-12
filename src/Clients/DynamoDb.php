<?php

namespace leisureManager\Clients;

require '../../vendor/autoload.php';

date_default_timezone_set('UTC');

use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\DynamoDb\Marshaler;

class DynamoDb
{
    private $dynamoDb;

    private $marshaler;

    public function __construct()
    {
        $sdk = new \Aws\Sdk([
            'hostname' => 'https://eu-west-1.amazonaws.com',
            //'profile'  => 'birkoff',
            'region'   => 'eu-west-1',
            'version'  => 'latest'
        ]);

        $this->dynamoDb = $sdk->createDynamoDb();
        $this->marshaler = new Marshaler();
    }

    public function query($criteria)
    {
        $response = $this->dynamoDb->query($criteria);

        print_r($response['Items']);
    }

    public function scan($table)
    {
        $response = $this->dynamoDb->scan([
            'TableName' => $table
        ]);

        return $response;
    }

    public function createTable(array $params)
    {
        try {
            $result = $this->dynamoDb->createTable($params);
            echo 'Created table.  Status: ' .
                $result['TableDescription']['TableStatus'] ."\n";

        } catch (DynamoDbException $e) {
            echo "Unable to create table:\n";
            echo $e->getMessage() . "\n";
        }
    }

    public function saveItem($tableName, $json)
    {
        $params = [
            'TableName' => $tableName,
            'Item' => $this->marshaler->marshalJson($json)
        ];

        try {
            $result = $this->dynamoDb->putItem($params);
            echo "Item saved: \n";
            print_r($result);
        } catch (DynamoDbException $e) {
            echo "Unable to add venue:\n";
            print_r($params);
            echo $e->getMessage() . "\n";
        }
    }
}

?>