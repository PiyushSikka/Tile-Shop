<?php
#Revision History 

#Dev             Date                  Desc
#PS(2013552)   2020-09-25      Created First Page of project called  index.php
#PS(2013552)   2020-09-26      Added Functionality to my project
#PS(2013552)   2020-09-30      Completed Index.php page 
#PS(2013552)   2020-10-02      Started to build remaining two pages 
#PS(2013552)   2020-12-03      Added link to downlaod cheat sheet
#PS(2013552)   2020-12-05      Made code easier  to  maintain 
 
include 'PHP/Function.php';  # inculding PHP single function file
test_header("Home");         //calling single header function for same lines

?>
    <section class="front_page">	
		<div class="container">
                    <?php shuffle($advertising);  
                     echo '<img  class "ads" src = "' .$advertising[0]. '">';
                    ?>
                    <p>Tile and stone comes in a variety of textures, sizes and finishes. 
                    It can be used on your floors, walls, back splashes as well as on your counter tops. 
                    Tile offers beauty, durability and endless design possibilities because 
                    it comes in so many colors and varieties. 
                    It’s unlikely that you would not be able to find a combination just right for your living space.</p>                              
		</div>
        
        <a href="cheet sheet.txt" download>Cheat sheet</a>

    </section>
<?php
echo "<br><br><br>";

#############################
test_footer(); # calling single function for footer

