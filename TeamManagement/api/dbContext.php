<?php
include '/vendor/autoload.php'; // include Composer's autoloader

    class DbContext {
        public $mongoClient;
        public $db;

        function _construct()
        {
            
            $mongoClient = new MongoDB\Client("mongodb://localhost:27017");
            $this->db = $mongoClient->licApp;
        }

        function getDBName() {
            $mongoClient = new MongoDB\Client("mongodb://localhost:27017", [], [ 'typeMap' => [
               'array' => 'array',
               'document' => 'array',
               'root' => 'array',
           ],]);
            $this->db = $mongoClient->TeamManagementApp;
            return $this->db;
        }

        function create($collectionName, $data){
            
            if ($collectionName == null || $data == null){
                return $result = "Bad request, the controller name is empty";
            } else {
                $collection = $this->getDBName()->$collectionName;
                $result = $collection->insertOne($data);
                if ($result != null) {
                    return $result->getInsertedId();
                }
            }
        }

        function updateOne($collectionName, $filterDef, $data){
            
            if ($collectionName == null || $data == null){
                return $result = "Bad request, the controller name is empty";
            } else {
                $collection = $this->getDBName()->$collectionName;
                $result = $collection->replaceOne($filterDef, $data);
                if ($result != null) {
                    return $result->getModifiedCount();
                }
            }
        }

        function delete($collectionName, $filterDef){
            
            if ($collectionName == null){
                return $result = "Bad request, the controller name is empty";
            } else {
                $collection = $this->getDBName()->$collectionName;
                $result = $collection->deleteOne($filterDef);
                if ($result != null) {
                    return $result->getDeletedCount();
                }
            }
        }

        function getAll($collectionName){
            
            if ($collectionName == null){
                return $result = "Bad request, the controller name is empty";
            } else {
                $collection = $this->getDBName()->$collectionName;
                $cursor = $collection->find();
                return $result = iterator_to_array($cursor);
            }
        }

        function get($collectionName, $queryDefinition){
            
            if ($collectionName == null){
                return $result = "Bad request, the controller name is empty";
            } else {
                $collection = $this->getDBName()->$collectionName;
                
                $doc = $collection->findOne($queryDefinition);

                return $result = (object) $doc;
            }
        }

        function update($collectionName, $updateDefinition){
            
            if ($collectionName == null){
                return $result = "Bad request, the controller name is empty";
            } else {
                $collection = $this->getDBName()->$collectionName;
                return $result = $collection->updateOne($updateDefinition);
            }
        }
    }
                // $db = new DbContext();
                // $collection = $db->getDBName()->Employees;
                // $cursor = $collection->find();

                //  $cursor2array = iterator_to_array($cursor);
                //  var_dump($cursor2array);
                // // foreach ($cursor as $doc) {
                // //     var_dump($doc);
                // // }
?>
