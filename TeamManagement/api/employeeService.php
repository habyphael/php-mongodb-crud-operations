<?php 
include '/vendor/autoload.php'; // include Composer's autoloader
include 'dbContext.php';

class employeeModel {}

class employeeService {
    function createEmployee($data) {
        //More validations can go here
        $dbContext = new DbContext;

        $collectionName = 'Employees';
        $employeeID = $dbContext->create($collectionName, (array) $data);

        //Post Request Validations
    }

    function updateEmployee($id, $data) {//This methods calls mongo replaceOne which replaces the entire doc except the _id
        //More validations can go here
        $dbContext = new DbContext;
        $obj = new employeeModel();
        $obj->_id = new MongoDB\BSON\ObjectID($id);
        $filterDef = (array) $obj;

        $collectionName = 'Employees';
        $countUpdatedEmployees = $dbContext->updateOne($collectionName, $filterDef, (array) $data);

        //Post Request Validations
        if ($countUpdatedEmployees == 1) {
            $response = "updated successfully";
        } else {
            $response = "update failed";
        }
        return $response;
    }
    
    function deleteEmployee($id) {
        //More validations can go here
        $dbContext = new DbContext;
        $obj = new employeeModel();
        $obj->_id = new MongoDB\BSON\ObjectID($id);
        $filterDef = (array) $obj;

        $collectionName = 'Employees';
        $countDeletedEmployees = $dbContext->delete($collectionName, $filterDef);

        //Post Request Validations
        if ($countDeletedEmployees == 1) {
            $response = "success";
        } else {
            $response = "The doc could be deleted";
        }
        return $response;
    }

    function getEmployee($id) {
        //More validations can go here
        $dbContext = new DbContext;
        $obj = new employeeModel();

        $obj->_id = new MongoDB\BSON\ObjectID($id);
        $queryDef = (array) $obj;

        $collectionName = 'Employees';
        $employee = $dbContext->get($collectionName, $queryDef);

        //Post Request Validations
        return $employee;
    }

    function getEmployees() {
        //More validations can go here
        $dbContext = new DbContext;

        $collectionName = 'Employees';
        $employees = $dbContext->getAll($collectionName);

        //Post Request Validations
        return $employees;
    }
}
?>