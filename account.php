<?php
#Revision History 

#Dev             Date                  Desc
#PS(2013552)   2020-12-03      Created account.php page
#PS(2013552)   2020-12-05      Made code easier  to  maintain 
#PS(2013552)   2020-12-07      Created session 

include_once 'PHP/Function.php';
test_header("Account");
include_once Customer_Class;
session_start();
    $firstname = $lastname = $address = $city = $province = $postalcode = $username = $password = '';
    
    $firstnameerr = $lastnameerr = $addresserr = $cityerr =  
    $provinceerr = $postalcodeerr = $usernameerr = $passworderr = '';
if(isset($_SESSION['userID']))
{
    $customer = new Customer();
    if($customer->Load($_SESSION['userID']))
    {
        $firstname = $customer->getFirstname();
        $lastname = $customer->getLastname();
        $address = $customer->getAddress();
        $city = $customer->getCity();
        $province = $customer->getProvince();
        $postalcode = $customer->getPostalcode();
        $username = $customer->getUsername();
    }
}
else 
{
    Login();
    test_footer();
    die();
}
if(isset($_POST['update']))
{
    $firstname = htmlspecialchars($_POST['firstname']);
    $lastname = htmlspecialchars($_POST['lastname']);
    $address = htmlspecialchars($_POST['address']);
    $city = htmlspecialchars($_POST['city']);
    $province = htmlspecialchars($_POST['province']);
    $postalcode = htmlspecialchars($_POST['postalcode']);
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    
    $firstnameerr = $customer->setFirstname($firstname);
    $lastnameerr = $customer->setLastname($lastname);
    $addresserr = $customer->setAddress($address);
    $cityerr = $customer->setCity($city);
    $provinceerr = $customer->setProvince($province);
    $postalcodeerr = $customer->setPostalcode($postalcode);
    $usernameerr = $customer->setUsername($username);
    $passworderr = $customer->setPassword($password);
    
    if($firstnameerr == '' && $lastnameerr == '' && $addresserr == '' && $cityerr == '' && $provinceerr == '' && $postalcodeerr == '' && $usernameerr == '' && $passworderr == '')
        {
            if($customer->Save())
            {
                $firstname = $customer->getFirstname();
                $lastname = $customer->getLastname();
                $address = $customer->getAddress();
                $city = $customer->getCity();
                $province = $customer->getProvince();
                $postalcode = $customer->getPostalcode();
                $username = $customer->getUsername();
                $password = '';
            }
            else
            {
                echo "Data was not Saved due to an Error";
            }
        }
}
?>
 <section class="front_page">	
 <div class="container">
     <form method="POST">
         <h3 span class="red"> * = Required </h3>
                Firstname:<span class="red"> * </span><input name="firstname" type="text" value="<?php echo $firstname;?>"><br><div class="red"><?php echo $firstnameerr ?> </div> <br>
                Lastname:<span class="red"> * </span><input name="lastname" type="text" value="<?php echo $lastname;?>"><br><div class="red"><?php echo $lastnameerr ?> </div> <br>
                Address:<span class="red"> * </span><input name="address" type="text" value="<?php echo $address;?>"><br><div class="red"><?php echo $addresserr ?> </div> <br>
                City:<span class="red"> * </span><input name="city" type="text" value="<?php echo $city;?>"><br><div class="red"><?php echo $cityerr ?> </div> <br>
                Province:<span class="red"> * </span><input name="province" type="text" value="<?php echo $province;?>"><br><div class="red"><?php echo $provinceerr ?> </div> <br>
                Postalcode:<span class="red"> * </span><input name="postalcode" type="text" value="<?php echo $postalcode;?>"><br><div class="red"><?php echo $postalcodeerr ?> </div> <br>
                Username:<span class="red"> * </span><input name="username" type="text" value="<?php echo $username;?>"><br><div class="red"><?php echo $usernameerr ?> </div> <br>
                Password:<span class="red"> * </span><input name="password" type="password" value="<?php echo $password;?>"><br><div class="red"><?php echo $passworderr ?> </div> <br><br>
                <input name="update" type="submit" value="Update" /> <br>
            </form>  
<?php 
    Logout();
    ?>
 </div>
 </section>
     <?php
    test_footer();



