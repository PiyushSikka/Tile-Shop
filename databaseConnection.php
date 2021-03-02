<?php
#Revision History 

#Dev             Date                  Desc
#PS(2013552)   2020-12-06      created common database  connection
#PS(2013552)   2020-12-10      Set Attribute on my connection string to check errros and exception

   $conn = new PDO("mysql:host=localhost;dbname=database-2013552","user-2013552","123");
   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

