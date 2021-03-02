<?php
#Revision History 

#Dev             Date                  Desc
#PS(2013552)   2020-09-25      Created First Page of project called  index.php
#PS(2013552)   2020-09-26      Added Functionality to my project
#PS(2013552)   2020-09-30      Completed Index.php page 
#PS(2013552)   2020-10-02      Started to build remaining two pages 
#PS(2013552)   2020-12-03      Added link to downlaod cheat sheet
#PS(2013552)   2020-12-05      Made code easier  to  maintain 



include_once 'PHP/Function.php';
include_once Products_Class;
include_once Purchase_Class;
include_once Product_Class;
test_header("Buy");
session_start();
$comments = '';
$quantity = '';
$commentserr = '';
$quantityerr = '';
if(isset($_SESSION['userID']))
{
    $products = new products();
    $purchase = new purchase();
    if(isset($_POST['buy']))
    {
        $productUUID = $_POST['productUUID'];
        $comments = htmlspecialchars($_POST['comments']);
        $quantity = htmlspecialchars($_POST['quantity']);
        $commentserr = $purchase->setComments($comments);
        $quantityerr = $purchase->setQuantity($quantity);
        if($commentserr == '' && $quantityerr=='')
        {
            foreach ($products->items as $product)
            {
                if($product->getProductUUID() == $productUUID)
                {
                    $purchase->setSubTotal($product->getPrice());
                    $purchase->setTaxes();
                    $purchase->setGrandTotal();
                    $purchase->setProductUUID($productUUID);
                    $purchase->setCustomerUUID($_SESSION['userID']);
                }
            }
            if($purchase->Save())
            {
                $comments = '';
                $quantity = '';
                echo "Purchase Done!";
            }
        }
    }
}
else
{
    Login();
    test_footer();
    die();
}
?>
<section class="front_page">	
    <div class="container">    
        <form method="POST">
            <h3 class = "red"> * = Required </h3>
            Product Code:<span class="red"> * </span>
                <select name="productUUID">
                    <?php
                    foreach ($products->items as $product)
                    {
                        ?><option value="<?php echo $product->getProductUUID(); ?>"><?php echo $product->getProductCode()." ".$product->getDescription(); ?></option>
                    <?php
                        }
                    ?>
                </select>
                <br>
         
                Comments:<?php echo $commentserr; ?>
                <input type="text" name="comments" value="<?php echo $comments;?>"/>
                
                Quantity:<span class="red"> * </span> <?php echo $quantityerr; ?>
                <input type="text" name="quantity" value="<?php echo $quantity?>"/>
    
                <input type="submit" value="Buy" name="buy">
            
        </form>
        <?php
        echo  '<br> <br>';
        Logout();
        ?>
    </div>
</section>
<?php
#Logout();
test_footer();
