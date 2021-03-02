<?php
#Revision History 

#Dev             Date                  Desc
#PS(2013552)   2020-09-25      Created First Page of project called  index.php
#PS(2013552)   2020-09-26      Added Functionality to my project
#PS(2013552)   2020-09-30      Completed Index.php page 
#PS(2013552)   2020-10-02      Started to build remaining two pages 
#PS(2013552)   2020-12-03      Added link to downlaod cheat sheet
#PS(2013552)   2020-12-05      MAde code easier  to  maintain 




include 'PHP/Function.php';  // Set user-defined error handler function
include_once database_connection;
include_once Purchase_Class;
test_header("Purchases");         //calling single function for same lines


    session_start();
    if(isset($_SESSION['userID']))  # checking session is set of not 
    {
        if(isset($_POST['delete']))
        {
            $purchase = new purchase();
            if($purchase->Delete($_POST['purchase_uuid']))
            {
                echo "Deleted Purchase";
            }
        }
    }
    else
    {
        Login();
        test_footer(); # calling single function Footer
        die();
    }
?>

    <section class="front_page">	
        <div class="container">
        <label>Show Purchases made on this day or later: </label>
        <input type="text" placeholder="2020-03-13" id="searchQuery">
        <p>
            <button onclick="searchPurchases()" class="button" name="search">Search</button>
        </p>
    </div>
    <div id="searchResults"> </div>                  
    </section>
<?php
echo "<br><br><br>";
test_footer(); # calling single function for footer 