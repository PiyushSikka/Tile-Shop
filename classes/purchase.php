<?php

#Revision History 

#Dev             Date                  Desc
#PS(2013552)   2020-12-07       created purchase  class
#PS(2013552)   2020-12-07       Added private properties and getters and setters for all properties
#PS(2013552)   2020-12-07       created Load Save Delete function

include_once 'PHP/Function.php'; # using single php function file 
include_once database_connection; # created single database connection file and using it here 
# defining Constants
define("QUANTITY_MAX_LENGTH",99);
define("QUANTITY_MIN_LENGTH",1);
define("COMMENTS_MAX_LENGTH",200);
define("TAX_RATE", 15.2);

class purchase
{
    private $purchase_uuid = '';
    private $customer_uuid = '';
    private $product_uuid = '';
    private $quantity = 0;
    private $comments = '';
    private $subtotal = 0.0;
    private $taxes = 0.0;
    private $grandtotal = 0.0;
    
    # costructor  - Tbis function will be called when objects are created 
    public function __construct($purchase_uuid = '' ,$product_uuid = '', $quantity = '', $comments = '', $subtotal = '', $taxes = '', $grandtotal = '') 
    {
        $this->purchase_uuid = $purchase_uuid; 
        $this->product_uuid = $product_uuid;
        $this->quantity = $quantity;
        $this->comments = $comments;
        $this->subtotal = $subtotal;
        $this->taxes = $taxes;
        $this->grandtotal = $grandtotal;
    }
    
   # getter and setters 
    
    function getPurchaseUUID()  # getting PurchaseUUID
    {
        return $this->purchase_uuid;
    }
    function setPurchaseUUID($newUUID) 
    {
        $this->purchase_uuid = $newUUID;
    }
    
    function getCustomerUUID() #Getting CustomerUUID
    {
        return $this->customer_uuid;
    }
    
    function setCustomerUUID($customer_uuid) # setting CustomerUUID
    {
        $this->customer_uuid = $customer_uuid;
    }
    
    function getProductUUID() # getting ProductUUID
    {
        return $this->product_uuid;
    }
    
    function setProductUUID($productUUID) #setting PRoductUUID
    {
        $this->product_uuid = $productUUID;
    }
    
    function getSubTotal() # getting Subtotal
    {
        return $this->subtotal;
    }
    function setSubTotal($price) # setting Subtotal
    {
        $this->subtotal = round($this->quantity * $price, 2);
    }
    
    function getTaxes() #getting Taxes
    {
        return $this->taxes;
    }
    function setTaxes() # setting Taxes
    {
        $this->taxes = round($this->subtotal*TAX_RATE/100, 2);
    }
    
    function getGrandTotal() # getting Grand Total
    {
        return $this->grandtotal;
    }
    function setGrandTotal() # setting Grand Total
    {
        $this->grandtotal = round($this->subtotal + $this->taxes , 2);
    }
    
    function getQuantity() # Getting Quantity
    {
        return $this->quantity;
    }
    
    function setQuantity($newQuantity) # setting Quantity 
    {
        #Setting quantity and validating quantity according to the requirements
        if(strpos($newQuantity,".") == false)  
            {
                if(is_numeric($newQuantity) && !is_float($newQuantity))   
                {
                    if($newQuantity > QUANTITY_MAX_LENGTH)  
                    {   
                        return "Quantity can not be more than ".QUANTITY_MAX_LENGTH;
                    }
                    else if($newQuantity < QUANTITY_MIN_LENGTH) 
                    {
                        return "Quantity cannot be less than ".QUANTITY_MIN_LENGTH;
                    }
                }
                else if($newQuantity == "")    
                {
                    return "Quantity cannot be Empty";
                }   
                else 
                {
                    return "Quantity is not Numeric";
                }
            }
        if(strpos($newQuantity, "."))    
        {
            return "Decimals are not allowed";
        }
        else 
        {
            $this->quantity = $newQuantity;
        }
    }
    
    function getComments() # getting Comments
    {
        return $this->comments;
    }
    function setComments($newComments) #Setting Comments
    {
        #comments validation as per project requirements
        
        if(mb_strlen($newComments) > COMMENTS_MAX_LENGTH) 
        {
            return "Comments cannot contain more than ".COMMENTS_MAX_LENGTH." characters";
        }
        else
        {
            $this->comments = $newComments;
        }    
    }
   
    public function Load($purchase_uuid)
    {
        global $conn; #using  common connection string 
        
        $sqlQuery = "CALL purchase_load(:p_purchase_uuid)";
        
        # preparing connection
        $stmt = $conn->prepare($sqlQuery); 
        
       # Binding parmaeters 
        $stmt->bindParam(':p_purchase_uuid', $purchase_uuid);
        
        $stmt->execute();
        
        if($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $this->purchase_uuid = $row['purchase_uuid'];
            $this->customer_uuid = $row['customer_uuid'];
            $this->product_uuid = $row['product_uuid'];
            $this->quantity = $row['quantity'];
            $this->comments = $row['comments'];
            $this->subtotal = $row['subtotal'];
            $this->taxes = $row['taxes'];
            $this->grandtotal = $row['grandtotal'];
            return true;
        }
        $stmt->closeCursor();   # it will completely end current statement and will help in executing next statemnt completly.
    }
    
    public function Save() #Function Save is used to insert data in the database
    {
        global $conn;
        if($this->purchase_uuid == '')
        {
            # calling purchase insert stored procdure
            $sqlQuery = "CALL purchase_insert(:p_customer_uuid, :p_product_uuid, :p_quantity, :p_comments, :p_subtotal, :p_taxes, :p_grandtotal)";
        
            $stmt = $conn->prepare($sqlQuery);
            # Binding parameters 

            $stmt->bindParam(':p_customer_uuid', $this->customer_uuid);
            $stmt->bindParam(':p_product_uuid', $this->product_uuid);
            $stmt->bindParam(':p_quantity', $this->quantity);
            $stmt->bindParam(':p_comments', $this->comments);
            $stmt->bindParam(':p_subtotal', $this->subtotal);
            $stmt->bindParam(':p_taxes', $this->taxes);
            $stmt->bindParam(':p_grandtotal', $this->grandtotal);
            
            $affectedRows = $stmt->execute(); 
            if($affectedRows == 1)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
           # callingpurchase update stored procedure
            $sqlQuery = "CALL purchase_update(:p_purchase_uuid, :p_customer_uuid, :p_product_uuid, :p_quantity, :p_comments, :p_subtotal, :p_taxes, :p_grandtotal)";
            
            # preparing Connnection 
            $stmt = $conn->prepare($sqlQuery);
            
            #binding parmas to variables
            
            $stmt->bindParam(':p_purchase_uuid', $this->purchase_uuid);
            $stmt->bindParam(':p_customer_uuid', $this->customer_uuid);
            $stmt->bindParam(':p_product_code', $this->product_uuid);
            $stmt->bindParam(':p_quantity', $this->quantity);
            $stmt->bindParam(':p_comments', $this->comments);
            $stmt->bindParam(':p_subtotal', $this->subtotal);
            $stmt->bindParam(':p_taxes', $this->taxes);
            $stmt->bindParam(':p_grandtotal', $this->grandtotal);
            
            $stmt->execute();   
            return true;
        }
    }
    
    public function Delete($purchaseUUID)  # deletee function use to delete item  from databse 
    {
        global $conn;
        
        # calling purchase delete store procedure
        $sqlQuery = "CALL purchase_delete(:p_purchase_uuid)";
        
        # preparing query and connection
        $stmt = $conn->prepare($sqlQuery);
        $stmt->bindParam(':p_purchase_uuid', $purchaseUUID);
        
        $affectedRows = $stmt->execute();
        
        return $affectedRows;
        
    }
}
