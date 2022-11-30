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

            // New User Data Entry
            if (isset($_POST["username"])) {
                $pdo->query("INSERT INTO User (Username, Password, Address, Email, CCV, CC_Num, CC_Exp, Iscust, Isemp)
                             VALUES (\"" . strval($_POST["username"]) . "\", \"" . strval($_POST["password"]) . "\", \"" . strval($_POST["address"]) . "\", \""
                                         . strval($_POST["email"]) . "\", " . $_POST["ccv"] . ", \"" . strval($_POST["cc_num"]) . "\", \""
                                         . strval($_POST["cc_exp"]) . "\", " . strval($_POST["isCust"]) . ", " . strval($_POST["isEmp"]) . ");");
                // Refresh User Query
                $rs = $pdo->query("SELECT * FROM User;");   // Select 'User' from Maria
                $rowsUse = $rs->fetchAll(PDO::FETCH_NUM);   // By Index
            }
            
            // Customer Selection Confrimation
            echo "<u><b>Customer Selection:</u></b>";
            if (!(isset($_POST["custSelect"]))) { // Only if it hasn't happened yet
                echo "<form method=\"POST\">";

                // User Checkout Form
                foreach($rowsUse as $rowUse) {
                    if ($rowUse[7] == 1) {
                        echo "<input type=\"radio\" name=\"user\" value=\"", $rowUse[0], "\" />", $rowUse[0], "<br/> ";
                    }
                }
                /* Pretty Source Code */ echo "\n";

                echo "<u>PASSWORD:</u><nbsp> <input type=\"text\" name=\"custPass\"/> <br/>",
                     "<br/> <input type=\"submit\" name=\"custSelect\" value=\"CONFIRM IDENTITY\" /> ",
                     "</form> <br/><br/><br/>";

                // New User Redirect
                echo "<u><b>New User?</u></b>",
                     "<form action=\"https://students.cs.niu.edu/~z1838505/assignGroup_User.php\" method=\"POST\">",
                     "<input type=\"hidden\" name=\"url\" value=\"https://students.cs.niu.edu/~z1838505/assignGroup_Checkout.php\"/>",   // Send current webpage
                     "<br/> <input type=\"submit\" name=\"newCust\" value=\"NEW USER ENTRY\" /> <br/>",
                     "</form> <br/>";

                /* Pretty Source Code */ echo "\n";

            } 

            // Only Confirm Orders if Selection made
            if (isset($_POST["custSelect"])) {
                // Selected User Display
                $user = NULL;       // Save Username for Orders
                $passBool = false;  // Print correct error message
                if (isset($_POST["user"]) && !(empty($_POST["custPass"]))) {    // If User & Password were even selected
                    $passBool = true;
                    foreach($rowsUse as $rowUse) {
                        if ($_POST["user"] == $rowUse[0] && strval($_POST["custPass"]) == $rowUse[1]) {
                            $user = $rowUse[0];
                            echo "<br/><br/>",
                                 "User: ", strval($rowUse[0]), "<br/>",
                                 "Address: ", strval($rowUse[2]), "<br/>",
                                 "Email: ", strval($rowUse[3]), "<br/>",
                                 "CCN: ************", $rowUse[5][12] . $rowUse[5][13] . $rowUse[5][14] . $rowUse[5][15], "<br/>"; 
                        }

                        /* Pretty Source Code */ echo "\n";
                        
                    } 
                } else {
                    echo "<h4>PLEASE SELECT USER & ENTER PASSWORD</h4>",
                         "<form action=\"https://students.cs.niu.edu/~z1838505/assignGroup_Checkout.php\" method=\"POST\">",
                         "<input type=\"submit\" name=\"checkout\" value=\"RETURN\" /> <br/>",
                         "</form> <br/>";
                }
                
                // Record Cart into Orders
                if ($user != NULL) {    // IF username actually selected
                    // Confirm Form
                    echo "<form action=\"https://students.cs.niu.edu/~z1838505/assignGroup.php\" method=\"POST\">
                          <br/> <input type=\"submit\" name=\"ordered\" value=\"CONFIRM ORDERS\" /> <br/>
                          </form> <br/>";

                    foreach($rowsCart as $rowCart) {
                        // Build add_note
                        $note = strval($rowCart[1]) . ":" . strval($rowCart[3] . ":");
                        // Record
                        $pdo->query("INSERT INTO Orders (amountPaid, track_order, add_note) 
                                                 VALUES (\"" . strval($rowCart[2]) . "\", \"" . strval($user) . "\", \"" . $note . "\");");

                        /* Pretty Source Code */ echo "\n";
                        
                    }

                    // Empty Cart
                    $pdo->query("DELETE FROM Cart;");

                } elseif ($passBool) {
                    echo "<h4>USERNAME / PASSWORD INCORRECT</h4>",
                         "<form action=\"https://students.cs.niu.edu/~z1838505/assignGroup_Checkout.php\" method=\"POST\">",
                         "<input type=\"submit\" name=\"checkout\" value=\"RETURN\" /> <br/>",
                         "</form> <br/>";
                }
            }

        ?>

        <br/>
        <h4><b>Return to Homepage?</b></h4>
        <form action="https://students.cs.niu.edu/~z1838505/assignGroup.php" method="POST">
            <input type="submit" name="go" value="RETURN" /> <br/>
        </form> <br/>

    </body>
</html>