
<?php

#Revision History 

#Dev             Date                  Desc
#PS(2013552)   2020-12-07       created product classes
#PS(2013552)   2020-12-07       Added private properties and getters and setters for all properties



include_once 'PHP/Function.php'; # including common php file 
include_once database_connection; # including connection string

class product # creating class Product
{
    # creating private properties 
    private $product_uuid = ''; 
    private $product_code = '';
    private $description = '';
    private $price = 0.0;
    private $cost_price = 0.0;
    
    # Creating constructor to  initialize  properties while creating objects 
    public function __construct($product_uuid = '', $product_code='', $description = '', $price = '', $cost_price = '') 
    {
        $this->product_uuid = $product_uuid;
        $this->product_code = $product_code;
        $this->description = $description;
        $this->price = $price;
        $this->cost_price = $cost_price;   
    }
    
    #Getter and setters 
    
    function getProductUUID()
    {
        return $this->product_uuid;
    }
    
    function getProductCode() # getting product code 
    {
        return $this->product_code;
    }
    function setProductCode($newProductCode)  # setting product code 
    {
        $this->product_code = $newProductCode;
    }
    
    function getDescription() # getting description
    {
        return $this->description;
    }
    function setDescription($newDescription) # setting description 
    {
        $this->description = $newDescription;
    }
    
    function getPrice() # getting price 
    {
        return $this->price;
    }
    function setPrice($newPrice) # setting price 
    {
        $this->price = $newPrice;
    }
    
    function getCostPrice() # getting costprice 
    {
        return $this->cost_price;
    }
    function setCostPrice($newCostPrice) # setting cost price
    {
        $this->cost_price = $newCostPrice;
    }
    
    public function Load($productUUID) # function to laod  details of particular product using product_uuid
    {
        global $conn;
        $sqlQuery = "CALL product_load(:p_product_uuid)";
        $stmt = $conn->prepare($sqlQuery);
        #  Binding parameters 
        $stmt->bindParam(':p_product_uuid', $productUUID);
        $stmt->execute();
        if($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $this->product_uuid = $row['product_uuid'];
            $this->product_code = $row['productcode'];
            $this->description = $row['description'];
            $this->price = $row['price'];
            $this->cost_price = $row['costprice'];
            return true;
        }
    }
    
}
