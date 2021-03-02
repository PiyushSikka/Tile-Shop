<?php
#Revision History 
#
#Dev             Date                  Desc
#PS(2013552)   2020-11-18      Added error handler functionality to code
#PS(2013552)   2020-11-18      Added exception handler functionality to code
#PS(2013552)   2020-11-18      created Log file 
#PS(2013552)   2020-11-18      Added Missing headers
#PS(2013552)   2020-12-03      created new constant and new page to navigation menu
#PS(2013552)   2020-12-03      Added force secured connection(https)
#PS(2013552)   2020-12-04      Added login login in one function called Login
#PS(2013552)   2020-12-06      Added  some common code  in  funtion
#PS(2013552)   2020-12-07      Defined constants for classes


define("folder_images", "images/"); #  declaring constants
define("folder_classes", "classes/");
define("Customer_Class", folder_classes."Customer.php");
define("Product_Class", folder_classes."product.php");
define("Purchase_Class", folder_classes."purchase.php");
define("Products_Class", folder_classes."products.php");
define("Purchases_Class", folder_classes."purchases.php");
define("folder_css", "css/");
define("Styleh", "stylel.css");
define("Clogo", "logo.jpg");
define("Social", "f.png");
define("Socialg", "g.png");
define("Sociali", "i.png");
define("Socials", "s.png");
define("page_index", "index.php");
define("page_buying", "buy.php");
define("page_purchases", "purchases.php");
define("page_account", "account.php");
define("ad_tile1", folder_images . "tile1.jpg");
define("ad_tile2", folder_images . "tile2.jpg");
define("ad_tile3", folder_images . "tile3.jpg");
define("ad_tile4", folder_images . "tile4.jpg");
define("ad_tile5", folder_images . "tile5.jpg");
define("database_connection", "databaseConnection.php");
define("collection","collection.php");
define("folder_Javascript", "javascript/");
define("Ajax",folder_Javascript."ajax.js");


$advertising = array(ad_tile1 ,ad_tile2, ad_tile3, ad_tile4 , ad_tile5); # declaring global variable

function test_header($title) 
{
    header('Expires:Fri, 02 Dec 1994 16:00:00 GMT');
    header('Cache-Control: no-cache');
    header('Pragma: no-cache');
    header('Content-Type: text/html; charset=UTF_8');
    if ((!isset($_SERVER["HTTPS"])) || isset($_SERVER["HTTPS"]) != "on")
        {
            header('Location: https://' . $_SERVER["HTTP_HOST"]. $_SERVER["REQUEST_URI"]);
           die();
        }
    ErrorAndExceptionHandlers();  
    echo "<!DOCTYPE html>";
    echo "<html>";
    echo "<head>";
    echo "<meta charset=\"UTF-8\">";
    echo "<title>".$title."</title>";
    link_css();
    ?>
<script lang="javascript" type="text/javascript" src="<?php echo Ajax;?>"></script>
    <?php
    echo "</head>";
    echo '<body>';
       echo '<header>';
	echo '<div class="container">';
		echo '<div id="branding">';
                         echo '<img src = "' . folder_images . Clogo . '">';
			  echo  '<h1> <span class="highlight">Tile Shop</span> Montreal</h1>';
		   echo '</div>' ;
                   echo '<nav>';
                   echo '<ul>';
                   echo  '<li>'; 
                   navigation_menu(); 
                   echo  '</li>';  # <!-- Using function for navigation 	-->
                   echo  '</ul>';
                   echo  '</nav>';
             echo  '</div>';              
 echo '</header>';
}

function ErrorAndExceptionHandlers()
{
    function myErrorHandler($errno, $errstr, $errfile, $errline) {
        $debug =  true;    
        if($debug)
        {
        echo "<b>Custom error:</b> [$errno] $errstr<br>";
        echo " Error on line $errline in $errfile<br>";
        echo "Date or Error : " . date("y/m/d"). "\t" .date("h:i:sa") . "\n";
        }  
        $errorfile = fopen("LogFile.txt", 'a') or die("Unable to open file!");
        $txt= "Errorno - . $errno . \nErrorName -  . $errstr . \nErrorr on line - . $errline . \nErrorFile - . $errfile". date("y/m/d"). "\t" .date("h:i:sa") ; 
        fwrite($errorfile, $txt. "\r\n");
        fclose($errorfile);
        die ("PHP ENDED BECAUSE OF AN ERROR");
    }

    function myExceptionHandler($exception) {
        $debug =  true;    
        if($debug)
        {
        echo "<br>Error: " . $exception->getMessage();
        echo "<br>FileName: " . $exception->getFile();
        echo "<br>FileLine: " . $exception->getLine();
        echo "Date or Error : " . date("y/m/d"). "\t" .date("h:i:sa") . "\n";
        }  
        $errorfile = fopen("LogFile.txt", 'a') or die("Unable to open file!");
        $txt= "Error: " . $exception->getMessage();
        fwrite($errorfile, $txt. "\r\n");
        fclose($errorfile);
        die ("PHP ENDED BECAUSE OF AN EXCEPTION");
    }
    set_error_handler("myErrorHandler");
    set_exception_handler("myExceptionHandler");
}

function test_footer() 
{
   ?>
            <footer>    
                <a href="https://www.facebook.com/">  <?php echo '<img src = "' . folder_images . Social . '">';?>
		<a href="https://www.instagram.com/"> <?php echo '<img src = "' . folder_images . Sociali . '">';?>
		<a href="https://plus.google.com/">   <?php echo '<img src = "' . folder_images . Socialg . '">';?>
		<a href="https://www.skype.com/en/">  <?php echo '<img src = "' . folder_images . Socials . '">';?>
            </footer>
         
    <?php
    
    echo "<br>";
                    
    echo "<span class = 'footer'> &copy; Piyush Sikka (2013552) ". date("Y") . "</span>";      
    echo "</body>";
    echo "</html>";   
}

function navigation_menu()
{
    echo "<br><br>";
    echo '&nbsp; <a href = "' .page_index. '"> Home</a>'; 
    echo '&nbsp; <a href = "' .page_buying . '"> Buy</a>'; 
    echo '&nbsp; <a href = "' .page_purchases. '"> Purchases</a>'; 
    echo '&nbsp; <a href = "' .page_account. '"> Account</a>';
}
function link_css()
{
    ?>
    <link rel="stylesheet" type="text/css" href="<?php echo folder_css . Styleh ;?>">
    <?php
}
function Login()
{
    ?>
    <section class="front_page">	
    <div class="container">
    <?php
    include_once database_connection;
    include_once Customer_Class;
    $customer = new Customer(); 
    $usernameerr = '';
    $passworderr = '';
    if(isset($_POST['Login']))
    {
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);
        if(mb_strlen($username) == 0)
        {
            $usernameerr = "username can't be empty";
        }
        if(mb_strlen($password) == 0)
        {
            $passworderr = "password can't be empty";
        }      
        if($usernameerr == '' && $passworderr == '')
        {
            $fetched_password = '';
            global $conn;

            $sqlQuery = "CALL retrieve_password(:username)";

            $stmt = $conn->prepare($sqlQuery);
            
            $stmt->bindParam(':username', $username);
                    
            $stmt->execute();
            
            while($row=$stmt->fetch())
            {
                $fetched_password = $row['password'];
            }     
            unset($stmt);
            
            if(password_verify($password, $fetched_password))
            {
               if ($customer->myfunc($username , $fetched_password))
               {
                   echo 'working';
                   $_SESSION['userID'] = $customer->getCustomerUUID();
                   var_dump($_SESSION['userID']);
                   header("Location: ".$_SERVER["REQUEST_URI"]);
               }
            }
            else
            {
                unset($_SESSION['userID']);
                echo "Username or Password Incorrect<br>"; 
            }
        }
    }
    ?>     
        <form method="POST">
            Username: <?php echo $usernameerr; ?><input name="username" type="text" /><br>
            Password: <?php echo $passworderr; ?><input name="password" type="password" /><span><br><br>
        <input name="Login" type="submit" value="Login" /> <br>     
        <h3>Need  a user account ? <a href= "Register.php">Register<a/> </h3>
    </form>  
    </div>
    </section>
    <?php    
}

    function Logout()
    {
        include_once Customer_Class;
        $customer = new Customer();
        $customer->Load($_SESSION['userID']);
        echo "<h3 style='text-align: center;margin:20px 0 0 0;'>Welcome ".$customer->getFirstname()." ".$customer->getLastname()."</h3>";
        if(isset($_POST['logout']))
        {
            unset($_SESSION['userID']);
            header('Location: '.$_SERVER['REQUEST_URI']);
        }
        ?>
        <form method="POST">
            <input type="submit" name="logout" value="Logout">
        </form>
        <?php
    }
