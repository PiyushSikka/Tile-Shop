<?php

#Revision History 

#Dev             Date                  Desc
#PS(2013552)   2020-12-07       created products classes

include_once 'PHP/Function.php'; # using single php function file 
include_once database_connection; # created single database connection file and using it here 
include_once collection;
include_once Product_Class;

class products extends collection
{
    function __construct()  #constructor
    {
        global $conn;
        $sqlQuery = "CALL products_select()";
        $stmt = $conn->prepare($sqlQuery);
        $stmt->execute();  
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) #loop  in the results
        {
            $product = new product($row['product_uuid'], $row['productcode'], $row['description'], $row['price'], $row['costprice']);
            $this->add($row['product_uuid'], $product);
        }
    }
}

