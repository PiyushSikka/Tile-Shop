<?php

#Revision History 

#Dev             Date                  Desc
#PS(2013552)   2020-12-07       created Customer class
#PS(2013552)   2020-12-07       Added private properties and getters and setters for all properties
#PS(2013552)   2020-12-08       created Product and purchase class
#PS(2013552)   2020-12-10       Creating Load and save function 




    require_once ('databaseConnection.php');
    #  defining Constants 
    define("FIRSTNAME_MAX_LENGTH",20);
    define("LASTNAME_MAX_LENGTH",20);
    define("ADDRESS_MAX_LENGTH", 25);
    define("CITY_MAX_LENGTH", 25);
    define("PROVINCE_MAX_LENGTH", 25);
    define("POSTALCODE_MAX_LENGTH", 7);
    define("USERNAME_MAX_LENGTH", 12);
    define("PASSWORD_MAX_LENGTH",30);

class Customer  # creating class customer
{
    private $customer_uuid = '';  # creating private properties 
    private $firstname = '';
    private $lastname = '';
    private $address = '';
    private $city = '';
    private $province = '';
    private $postalcode = '';
    private $username = '';
    private $password = '';
    
    # Creating constructor intialize  object
    public function __construct($customer_uuid = '', $firstname = '', $lastname = '', $address = '', $city = '', $province = '', $postalcode = '', $username = '', $password = '') 
    {
        $this->customer_uuid = $customer_uuid;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->address = $address;
        $this->city = $city;
        $this->province = $province;
        $this->postalcode = $postalcode;
        $this->username = $username;
        $this->password = $password;
    }
    # getters and Setters for every property 
    function getCustomerUUID()
    {
        return $this->customer_uuid;
    }
    function getFirstname()  #getting Firstname  
    {
        return $this->firstname;
    }
    function setFirstname($newFirstname)# setting Firstname
    {
        if(mb_strlen($newFirstname) == 0)
        {
            return "First Name cannot be empty";
        }
        else if(mb_strlen($newFirstname) > FIRSTNAME_MAX_LENGTH)
        {
            return "FirstName cannot contain have more than ".FIRSTNAME_MAX_LENGTH." characters";
        }
        else
        {
            $this->firstname = $newFirstname;
            return '';
        }
    }
    function getLastname() #getting Lasttname 
    {
        return $this->lastname;
    }
    function setLastname($newLastname)  # setting lastname 
    {
        if(mb_strlen($newLastname) == 0)
        {
            return "LastName cannot be empty";
        }
        else if(mb_strlen($newLastname) > LASTNAME_MAX_LENGTH)
        {
            return "LastName cannot have more than ".LASTNAME_MAX_LENGTH." characters";
        } 
        else
        {
            $this->lastname = $newLastname;
            return '';
        }
    } 
    function getAddress() # getting Address 
    {
        return $this->address;
    }
    function setAddress($newAddress) # setting address 
    {
        if(mb_strlen($newAddress) > ADDRESS_MAX_LENGTH)
        {
            return "Address cannot have more than ".ADDRESS_MAX_LENGTH." characters";
        }
        else if(mb_strlen($newAddress) == 0)
        {
            return "Address cannot be empty";
        }
        else
        {
            $this->address = $newAddress;
            return '';
        }
    }
function getCity() #getting  city 
    {
        return $this->city;
    }
    function setCity($newCity) #Setting city 
    {
        if(mb_strlen($newCity) > CITY_MAX_LENGTH)
        {
            return "City cannot have more than ".CITY_MAX_LENGTH." characters";
        }
        else if(mb_strlen($newCity) == 0)
        {
            return "City cannot be empty";
        }
        else
        {
            $this->city = $newCity;
            return '';
        }
    }
    
    function getProvince() # getting province 
    {
        return $this->province;
    }
    function setProvince($newProvince) # setting province
    {
        if(mb_strlen($newProvince) > PROVINCE_MAX_LENGTH)
        {
            return "Province cannot have more than ".PROVINCE_MAX_LENGTH." characters";
        }
        else if(mb_strlen($newProvince) == 0)
        {
            return "City cannot be empty";
        }
        else
        {
            $this->province = $newProvince;
            return '';
        }
    }
    
    function getPostalcode() #  getting postal code 
    {
        return $this->postalcode;
    }
    function setPostalcode($newPostalcode) # setting postal code 
    {
        if(mb_strlen($newPostalcode) > POSTALCODE_MAX_LENGTH)
        {
            return "Postal Code cannot have more than ".POSTALCODE_MAX_LENGTH." characters";
        }
        else if(mb_strlen($newPostalcode) == 0)
        {
            return "Postal Code cannot be empty";
        }
        else
        {
            $this->postalcode = $newPostalcode;
            return '';
        }
    }
    
    function getUsername()  # getting usernae m
    {
        return $this->username;
    }
    function setUsername($newUsername) # setting username 
    {
        if(mb_strlen($newUsername) > USERNAME_MAX_LENGTH)
        {
            return "Username cannot have more than ".USERNAME_MAX_LENGTH." characters";
        }
        else if(mb_strlen($newUsername) == 0)
        {
            return "Username cannot be empty";
        }
        else
        {
            $this->username = $newUsername;
            return '';
        }
    }
    
    function getPassword() # getting password 
    {
        return $this->password;
    }
    function setPassword($newPassword)  # setting password 
    {
        if(mb_strlen($newPassword) > PASSWORD_MAX_LENGTH)
        {
            return "Password cannot have  more than ".PASSWORD_MAX_LENGTH." characters";
        }
        else if(mb_strlen($newPassword) == 0)
        {
            return "Password cannot be empty";
        }
        else
        {
            $this->password = $newPassword;
            return '';
        }
    }

    public function Save()
    {
        global $conn;   
            if($this->customer_uuid == '') 
            {              
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    #  calling customer insert stored procedure
                    $sqlquery = "CALL customer_insert(:firstname , :lastname , :address , :city , :province , :postalcode , :username , :password );";
                    # preparing Connection
                    $stmt = $conn->prepare($sqlquery);
                    #  hashing password
                    $hashed_password = password_hash($this->password,PASSWORD_DEFAULT);
                    #Bind parameters to the variables
                    $stmt->bindParam(':firstname', $this->firstname);
                    $stmt->bindParam(':lastname', $this->lastname );
                    $stmt->bindParam(':address', $this->address);
                    $stmt->bindParam(':city', $this->city);
                    $stmt->bindParam(':province', $this->province);
                    $stmt->bindParam(':postalcode', $this->postalcode);
                    $stmt->bindParam(':username', $this->username);
                    $stmt->bindParam(':password', $hashed_password);
                    echo "Connected successfully";

                    $stmt->execute(); # executing stored procedure customer  insert 
                    $Rows_affected  =  $stmt->rowCount();  #wil display how many rows are affected
                    echo "<br>". $Rows_affected . " rows effected";
                if($Rows_affected == 1)
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
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                #calling customer update stored procedure 
                $sqlquery = "CALL customer_update(:firstname , :lastname , :address , :city , :province , :postalcode , :username , :password, :p_customer_uuid );";
                # prepering connection
                $stmt = $conn->prepare($sqlquery);
                # hashing password 
                $hashed_password = password_hash($this->password,PASSWORD_DEFAULT);
                # binding  parameters
                $stmt->bindParam(':firstname', $this->firstname);
                $stmt->bindParam(':lastname', $this->lastname );
                $stmt->bindParam(':address', $this->address);
                $stmt->bindParam(':city', $this->city);
                $stmt->bindParam(':province', $this->province);
                $stmt->bindParam(':postalcode', $this->postalcode);
                $stmt->bindParam(':username', $this->username);
                $stmt->bindParam(':password', $hashed_password);  
                $stmt->bindParam(':p_customer_uuid', $this->customer_uuid);
                $stmt->execute();
                return true;
            } 
    }
    
    public function myfunc($newusername, $newpassword ) 
    {
        global  $conn;
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        #calling customer login stored procedure  
        $sqlQuery = "CALL customer_login(:username , :password)";
        $stmt = $conn->prepare($sqlQuery);
        $stmt->bindParam(':username', $newusername);
        $stmt->bindParam(':password', $newpassword);
        $stmt->execute();
        
        while($row=$stmt->fetch())  # Fetching all data using while loop 
         {
            $this->firstname  =  $row['firstname'];
            $this->lastname = $row['lastname'];
            $this->customer_uuid = $row['customer_uuid'];          
        }
        return true;
    }
    public function Load($customer_uuid) # creating Load function which will load all data
    {
        global $conn;
        $sqlQuery = "CALL customer_load(:p_customer_uuid)";
        $stmt = $conn->prepare($sqlQuery);
        $stmt->bindParam(':p_customer_uuid', $customer_uuid);
        $stmt->execute();
        if($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $this->customer_uuid = $row['customer_uuid'];
            $this->firstname = $row['firstname'];
            $this->lastname = $row['lastname'];
            $this->address = $row['address'];
            $this->city = $row['city'];
            $this->province = $row['province'];
            $this->postalcode = $row['postalcode'];
            $this->username = $row['username'];
            $this->password = $row['password'];
            return true;
        }
    }
}