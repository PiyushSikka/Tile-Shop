<?php
#Revision History 

#Dev             Date                  Desc
#PS(2013552)   2020-12-07       created customers classes

include_once 'PHP/Function.php';  # using single php function file
include_once database_connection; # created single database connection file and using it here 
include_once collection;
include_once Customer_Class;

class customers extends collection
{
    function __construct()
    {
        global $conn;
        $sqlQuery = "CALL customers_select()";
        $stmt = $conn->prepare($sqlQuery);
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $customer = new customer($row['customer_uuid'],$row['firstname'], $row['lastname'], $row['address'], $row['city'], $row[province], $row['postalcode'], $row['username'], $row['password']);
            $this->add($row['customer_uuid'], $customer);
        }
    }
}

