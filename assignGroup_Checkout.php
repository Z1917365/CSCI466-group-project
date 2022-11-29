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
            echo "</th></tr> </table> <br/> <br/>";

            // Access User
            $rs = $pdo->query("SELECT * FROM User;");   // Select 'User' from Maria
            $rowsUse = $rs->fetchAll(PDO::FETCH_NUM);   // By Index
            // Access Cart
            $rs = $pdo->query("SELECT * FROM Cart;");   // Select 'Cart' from Maria
            $rowsCart = $rs->fetchAll(PDO::FETCH_NUM);  // By Index
            // Access Inventory
            $rs = $pdo->query("SELECT * FROM Inventory;");  // Select 'Inventory' from Maria
            $rowsIn = $rs->fetchAll(PDO::FETCH_NUM);        // By Index

            // Customer Selection Confrimation
            if (!(isset($_POST["custSelect"]))) { // Only if it hasn't happened yet
                echo "<form method=\"POST\">",
                     "<br/> <input type=\"submit\" name=\"custSelect\" value=\"CONFIRM IDENTITY\" /> <br/>";

                // User Checkout Form
                echo "<p>Customer Selection:</p>";
                foreach($rowsUse as $rowUse) {
                    if ($rowUse[7] == 1) {
                        echo "<input type=\"radio\" name=\"user\" value=\"", $rowUse[0], "\" />", $rowUse[0], "<br/> ";
                    }
                }
                echo "</form> <br/>";
            } 

            // Only Confirm Orders if Selection made
            if ((isset($_POST["custSelect"]))) {
                // Selected User Display
                $user = NULL;   // Save Username for Orders
                foreach($rowsUse as $rowUse) {
                    if ($_POST["user"] == $rowUse[0]) {    // If Username was selected
                        $user = $rowUse[0];
                        echo "User: ", strval($rowUse[0]), "<br/>",
                             "Address: ", strval($rowUse[2]), "<br/>",
                             "Email: ", strval($rowUse[3]), "<br/>",
                             "CCN: ************", $rowUse[5][12] . $rowUse[5][13] . $rowUse[5][14] . $rowUse[5][15], "<br/>"; 
                    }
                }
                
                // Confirm Form
                echo "<form action=\"https://students.cs.niu.edu/~z1838505/assignGroup.php\" method=\"POST\">
                      <br/> <input type=\"submit\" name=\"ordered\" value=\"CONFIRM ORDERS\" /> <br/>
                      </form <br/>";
                
                // Record Cart into Orders
                if ($user != NULL) {    // IF username actually selected
                    foreach($rowsCart as $rowCart) {
                        // Build add_note
                        $note = strval($rowCart[1]) . " : " . strval($rowCart[3]);
                        $pdo->query("INSERT INTO Orders (amountPaid, track_order, add_note) 
                                                 VALUES (\"" . strval($rowCart[2]) . "\", \"" . strval($user) . "\", \"" . $note . "\");");
                                               //VALUES (" . $_POST["quantSelect"] . ", " . ($_POST["quantSelect"] * $rowIn[2]) . ", " . $rowIn[0] . ");");
                    }

                    // Empty Cart
                    $pdo->query("DELETE FROM Cart;");
                }
            }

        ?>

    </body>
</html>