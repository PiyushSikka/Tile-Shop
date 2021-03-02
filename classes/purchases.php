<?php

#Revision History 

#Dev             Date                  Desc
#PS(2013552)   2020-12-07       created purchases class

include_once 'PHP/Function.php';  # using single php function file
include_once database_connection; # created single database connection file and using it here 
include_once collection;
include_once Purchase_Class;

class purchases extends collection  #class purchases inherits class collection
{
    function __construct($customer_uuid, $searchDate)
    {
        global $conn;
        $sqlQuery = "CALL filter(:p_customer_uuid, :p_search_date)";
        $stmt = $conn->prepare($sqlQuery);
        $stmt->bindParam(':p_customer_uuid', $customer_uuid);
        $stmt->bindParam(':p_search_date', $searchDate);
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $purchase = new purchase($row['purchase_uuid'],$row['product_uuid'], $row['quantity'], $row['comments'], $row['subtotal'], $row['taxes'], $row['grandtotal']);
            $this->add($row['purchase_uuid'], $purchase);
        }
    }
}

