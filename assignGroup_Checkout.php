<html>
    <head><title>CSCI 466: Group 5</title></head>
    <body>
        <h1>Checkout:</h1>
        <h2>CSCI 466 Group Project</h2>

        <?php
            // Includes
            include ("secrets.php");
            include ("assignGroup_lib.php");

            // Try to Access MariaDB
            try {
                $dsn = "mysql:host=courses;dbname=z1838505";
                $pdo = new PDO($dsn, $username, $password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);   // Fix crap default errors
            }
            // Catch Failed Access
            catch(PDOexception $e) {
                echo "Connection to database failed: " . $e->getMessage();
            }

            // Distinguish Main page for Button visibility
            echo "<form method=\"POST\"> 
                  <input type=\"hidden\" name=\"custOut\" value=\"True\"/>
                  </form>";

            // Display Shopping Cart
            echo "<h3>Shopping Cart:</h3>",
                 "<table border=10 height=10% width=100%> <tr><th>";
            drawShop($pdo);     // Print Cart Contents
            echo "<form action=\"https://students.cs.niu.edu/~z1838505/assignGroup.php\" method=\"POST\">
                  <input type=\"submit\" name=\"ordered\" value=\"CONFIRM ORDERS\" />
                  </form> <br/> </th></tr> </table> <br/>";
        ?>

    </body>
</html>