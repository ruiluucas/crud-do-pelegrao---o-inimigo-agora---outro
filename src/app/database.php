<?php

require_once __DIR__ . '/../vendor/autoload.php';

use MongoDB\Client;
use MongoDB\BSON\ObjectId;

class Database
{
    private $clientInstance;

    private $dbInstance;

    private function getClient()
    {
        if (empty($this->clientInstance)) {
            $this->clientInstance = new Client("mongodb://admin:admin@mongo:27017");
        }
        return $this->clientInstance;
    }

    private function getDatabase()
    {
        if (empty($this->dbInstance)) {
            $this->dbInstance = $this->getClient()->getDatabase("teste");
        }
        return $this->dbInstance;
    }

    protected function selectCollection(string $collectionName)
    {
        return $this->getDatabase()->getCollection($collectionName);
    }

    protected function toObjectId($id)
    {
        $objectId = new ObjectId($id);
        return $objectId;
    }

    protected function insert(string $collectionName, $document)
    {
        $collection = $this->selectCollection($collectionName);

        $result = $collection->insertOne($document);

        return $result->getInsertedId();
    }

    protected function find(string $collectionName, array $filter = [], array $options = [])
    {
        $db = $this->getDatabase();
        $collection = $db->selectCollection($collectionName);

        $cursor = $collection->find($filter, $options);

        return $cursor->toArray();
    }

    protected function findOne(string $collectionName, array $filter = [], array $options = [])
    {
        $db = $this->getDatabase();
        $collection = $db->selectCollection($collectionName);

        return $collection->findOne($filter, $options);
    }

    protected function update(string $collectionName, array $filter, array $update)
    {
        $db = $this->getDatabase();
        $collection = $db->selectCollection($collectionName);

        $result = $collection->updateMany($filter, $update);

        return $result->getModifiedCount();
    }

    protected function delete(string $collectionName, array $filter)
    {
        if (empty($filter)) {
            echo "Erro: Filtro de deleção não pode ser vazio para evitar deleção acidental de toda a collection.";
            return 0;
        }

        $db = $this->getDatabase();
        $collection = $db->selectCollection($collectionName);

        $result = $collection->deleteMany($filter);

        return $result->getDeletedCount();
    }
}
