    <?php
    include_once 'PHP/Function.php';
    
    include_once Purchases_Class;
    include_once Customer_Class;
    include_once Product_Class;
    include_once Products_Class;
    session_start();
    if(isset($_POST['searchQuery']))
    {
        $searchQuery = htmlspecialchars($_POST['searchQuery']);
        $purchases = new purchases($_SESSION['userID'], $searchQuery);
        $customer = new customer();
        $product = new product();
        $customer->Load($_SESSION['userID']);
        #echo "<table class='tblPurchases'>"; <?php
           
        ?>
    <table id="tblPurchases">
        <tr>
            <th></th>
            <th>Product Code</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>City</th>
            <th>Comments</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Sub Total</th>
            <th>Taxes</th>
            <th>Grand Total</th>
        </tr>
<?php
        foreach($purchases->items as $purchase)
        {
            $product->Load($purchase->getProductUUID());
            echo "<tr>";
            ?>
            <td>
                <form method="POST" action="<?php echo page_purchases; ?>">
                    <input type="hidden" name="purchase_uuid" value="<?php echo $purchase->getPurchaseUUID();?>">
                    <input type="submit" name="delete" value="Delete">
                </form>
            </td>
            <?php 
            echo "<td>".$product->getProductCode()."</td>";
            echo "<td>".$customer->getFirstname()."</td>";
            echo "<td>".$customer->getLastname()."</td>";
            echo "<td>".$customer->getCity()."</td>";
            echo "<td>".$purchase->getComments()."</td>";
            echo "<td>".$product->getPrice().' $'."</td>";
            echo "<td>".$purchase->getQuantity()."</td>";
            echo "<td>".$purchase->getSubTotal().' $'."</td>";
            echo "<td>".$purchase->getTaxes().' $'."</td>";
            echo "<td>".$purchase->getGrandTotal().' $'."</td>";
            
            echo "</tr>";
        }
        echo "</table>";
    }
?>

