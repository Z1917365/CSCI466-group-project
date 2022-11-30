<html>
    <head><title>CSCI 466: Group 5</title></head>
    <body>
        <h1>Employee Portal</h1>
        <h2>CSCI 466 Group Project</h2>
        <?php
            // Incudes
            include ("assignGroup_lib.php");
            include ("secrets.php");

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

            // Access User
            $rs = $pdo->query("SELECT * FROM User;");   // Select 'User' from Maria
            $rowsUse = $rs->fetchAll(PDO::FETCH_NUM);   // By Index
            // Access Inventory
            $rs = $pdo->query("SELECT * FROM Inventory;");  // Select 'Inventory' from Maria
            $rowsIn = $rs->fetchAll(PDO::FETCH_NUM);        // By Index
            // Access Orders
            $rs = $pdo->query("SELECT * FROM Orders;");     // Select 'Orders' from Maria
            $rowsOrd = $rs->fetchAll(PDO::FETCH_NUM);       // By Index

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

            // Employee Data Altercations (lol) //
            // Current Inventory
            if (isset($_POST["enterCI"])) {
                //idCI
                //prodCat Name, Price, Quantity
                //strval(datum)
                if (empty($_POST["idCI"]) || empty($_POST["prodCat"]) || empty($_POST["datum"])) {
                    echo "<h3 style=\"background-color:powderblue;\">ALTER ERROR: Fill Entire Form</h3>";
                } else {
                    foreach ($rowsIn as $rowIn) {
                        if ($_POST["idCI"] == $rowIn[0] && $_POST["user"] == $rowIn[1]) {
                            if ($_POST["prodCat"] == "Name") {
                                $pdo->query("UPDATE Inventory SET Name = \"" . strval($_POST["datum"]) . "\" WHERE Product_ID = " . strval($rowIn[0]) . ";");
                            } elseif ($_POST["prodCat"] == "Price" && strval($_POST["datum"]) == strval(intval($_POST["datum"]))) {
                                $pdo->query("UPDATE Inventory SET Price = " . strval($_POST["datum"]) . " WHERE Product_ID = " . strval($rowIn[0]) . ";");
                            } elseif ($_POST["prodCat"] == "Quantity" && $_POST["datum"] == strval(intval($_POST["datum"]))) {
                                $pdo->query("UPDATE Inventory SET QuantityinStock = " . strval($_POST["datum"]) . " WHERE Product_ID = " . strval($rowIn[0]) . ";");
                            } else {echo "<h3 style=\"background-color:powderblue;\">ALTER ERROR: Price & Quantity MUST be Numeric</h3>";}
                        } else {echo "<h3 style=\"background-color:powderblue;\">ALTER ERROR: Product not Found</h3>";}
                    }
                    // Update Inventory
                    $rs = $pdo->query("SELECT * FROM Inventory;");  // Select 'Inventory' from Maria
                    $rowsIn = $rs->fetchAll(PDO::FETCH_NUM);        // By Index
                }
            }    
            // New Inventory
            if (isset($_POST["enterNI"])) {
                //strval(nameNI)
                //priceNI
                //quantNI
                if (empty($_POST["nameNI"]) || empty($_POST["priceNI"]) || empty($_POST["quantNI"])) {
                    echo "<h3 style=\"background-color:powderblue;\">ALTER ERROR: Fill Entire Form</h3>";
                } else {
                    $pdo->query("INSERT INTO Inventory (Name, Price, QuantityinStock, Username)
                            VALUES (\"" . strval($_POST["nameNI"]) . "\", " . strval($_POST["priceNI"]) . ", " . strval($_POST["quantNI"]) . ", \"" . strval($_POST["user"]) . "\");");
                    
                    // Update Inventory
                    $rs = $pdo->query("SELECT * FROM Inventory;");  // Select 'Inventory' from Maria
                    $rowsIn = $rs->fetchAll(PDO::FETCH_NUM);        // By Index
                }
            }    
            // Orders
            if (isset($_POST["enterO"])) {
                //idO
                //orderProc Yes, No
                //orderShip Yes, No
                //strval(oNotes)
                if (empty($_POST["idO"]) || (empty($_POST["orderProc"]) && empty($_POST["orderShip"]))) {
                    echo "<h3 style=\"background-color:powderblue;\">ALTER ERROR: Fill Entire Form</h3>";
                } else {
                    foreach ($rowsOrd as $rowOrd) {
                        if ($_POST["idO"] == $rowOrd[0]) {
                            if (isset($_POST["orderProc"])) {
                                if ($_POST["orderProc"] == "Yes") {$pdo->query("UPDATE Orders SET Is_processed = 1 WHERE Confirm_Num = " . strval($rowOrd[0]) . ";");}
                                else {$pdo->query("UPDATE Orders SET Is_processed = 0 WHERE Confirm_Num = " . strval($rowOrd[0]) . ";");}
                            }
                            if (isset($_POST["orderShip"])) {
                                if ($_POST["orderShip"] == "Yes") {$pdo->query("UPDATE Orders SET Is_shipped = 1 WHERE Confirm_Num = " . strval($rowOrd[0]) . ";");}
                                else {$pdo->query("UPDATE Orders SET Is_shipped = 0 WHERE Confirm_Num = " . strval($rowOrd[0]) . ";");}
                            }
                            if (isset($_POST["oNotes"])) {
                                $pdo->query("UPDATE Orders SET add_note = \"" . strval($rowOrd[5]) . strval($_POST["oNotes"]) . "\" WHERE Confirm_Num = " . strval($rowOrd[0]) . ";");
                            }
                        }
                    }
                    // Update Orders
                    $rs = $pdo->query("SELECT * FROM Orders;");     // Select 'Orders' from Maria
                    $rowsOrd = $rs->fetchAll(PDO::FETCH_NUM);       // By Index
                }
            }     

            // Customer Selection Confrimation
            if (!(isset($_POST["empSelect"]))) { // Only if it hasn't happened yet
                echo "<u><b>Employee Check-In:</u></b> <br/>",
                     "<form method=\"POST\">";

                // User Checkout Form
                foreach($rowsUse as $rowUse) {
                    if ($rowUse[8] == 1) {
                        echo "<input type=\"radio\" name=\"user\" value=\"", $rowUse[0], "\" />", $rowUse[0], "<br/> ";
                    }
                }
                /* Pretty Source Code */ echo "\n";

                echo "<u>PASSWORD:</u><nbsp> <input type=\"text\" name=\"empPass\"/> <br/>",
                     "<br/> <input type=\"submit\" name=\"empSelect\" value=\"CONFIRM IDENTITY\" /> ",
                     "</form> <br/><br/><br/>";

                // New User Redirect
                echo "<u><b>New User?</u></b>",
                     "<form action=\"https://students.cs.niu.edu/~z1838505/assignGroup_User.php\" method=\"POST\">",
                     "<input type=\"hidden\" name=\"url\" value=\"https://students.cs.niu.edu/~z1838505/assignGroup_Emp.php\"/>",   // Send current webpage
                     "<br/> <input type=\"submit\" name=\"newEmp\" value=\"NEW USER ENTRY\" /> <br/>",
                     "</form> <br/>";

                /* Pretty Source Code */ echo "\n";

            } 
            // Confirm Employee if Selection made
            if (isset($_POST["empSelect"])) {
                $user = NULL;   // Save User Array for Inventory & Orders
                // Selected User Display
                if (isset($_POST["user"]) && !(empty($_POST["empPass"]))) {    // If User & Password were even selected
                    // Employee Data
                    foreach($rowsUse as $rowUse) {
                        if ($_POST["user"] == $rowUse[0] && strval($_POST["empPass"]) == $rowUse[1]) {
                            $user = $rowUse;
                            echo "<br/><br/>",
                                 "User: ", strval($rowUse[0]), "<br/>",
                                 "Address: ", strval($rowUse[2]), "<br/>",
                                 "Email: ", strval($rowUse[3]), "<br/>"; 
                        }
                    }
                    /* Pretty Source Code */ echo "\n";

                    // If User was found
                    if ($user != NULL) {
                        $userInv = array(" ");     // Save User-Related ProductIDs
                        // Inventory Print
                        echo "<h4>Inventory:</h4>",
                             "<table width=100% border=3 cellspacing=1> <tr>",
                             "<th>ProductID:</th>",
                             "<th>Name:</th>",
                             "<th>Price:</th>",
                             "<th>Quantity:</th>";

                        foreach($rowsIn as $rowIn) {
                            if ($user[0] == $rowIn[1]) {
                                array_push($userInv, $rowIn[0]);
                                echo "<tr><td>" . 
                                     $rowIn[0] . "</td> <td>" .
                                     $rowIn[4] . "</td> <td>" .
                                     "$" . $rowIn[2] . "</td> <td>" . 
                                     $rowIn[3] . "</td> </tr>";
                                     
                                /* Pretty Source Code */ echo "\n";
                            }
                        }
                        /* Pretty Source Code */ echo "\n";

                        echo "</table> <br/>";

                        // Orders Print
                        echo "<h4>Orders:</h4>",
                             "<table height=20% width=100% border=3> <tr>";
                        $lineCount = 0; // Sub-Table Formatting
                        $sBuff = "";    // Extract data from add_note with string Buffer
                        $sCount = 0;    // Assist sBuff, ':' counter
                        $quant;         // Hold Quantity
                        $prodID;        // Hold ProductID
                        foreach($rowsOrd as $rowOrd) {
                            // Find ProductID & Quantity
                            foreach(str_split($rowOrd[5]) as $cBuff) {
                                switch ($cBuff) {
                                    case ':':
                                        $sCount++;
                                        if ($sCount == 1) { // Record Quantity 
                                            $quant = $sBuff;
                                            $sBuff = "";
                                        }
                                        if ($sCount == 2) { // Record ProductID
                                            $prodID = $sBuff;
                                            $sBuff = "";
                                        }
                                        break;

                                    default:
                                        $sBuff = $sBuff . $cBuff;
                                        break;
                                }
                            }
                            // Check against User Products
                            foreach($userInv as $invID) {
                                // Print Order
                                if ($invID == $prodID) {
                                    echo "<th width=25%>", 
                                        "Tracking #: ", $rowOrd[0], "<br/>",
                                        "ProductID: ", $prodID, "<br/>",
                                        "Quantity: ", $quant, "<br/>",
                                        "To: ", $rowOrd[4], "<br/>",
                                        "Paid: $", $rowOrd[3], "<br/>";
                                    if ($rowOrd[1] == 0) {echo "PROCESSING... <br/>";}
                                    else {echo "FULLY PROCESSED <br/>";}
                                    if ($rowOrd[2] == 0) {echo "NOT SHIPPED <br/>";}
                                    else {echo "SHIPPED <br/>";}
                                    echo "Further Notes:" . $sBuff . "</th>";

                                    /* Pretty Source Code */ echo "\n";
                                }
                            }
                            // Newline Control
                            $lineCount++;
                            if ($lineCount > 3) {echo "</tr> <tr>"; $lineCount = 0;}

                            // Reset
                            $sCount = 0;
                            $sBuff = "";

                        }
                        echo "</table></th></tr>";

                        /* Pretty Source Code */ echo "\n";

                        // Employee Alterations
                        echo "<h4>Alterations:</h4>",
                             "<table height=20% width=100% border=10> <tr>",
                             "<th width=33%>Current Inventory:</th>",
                             "<th width=33%>New Inventory:</th>",
                             "<th width=33%>Orders:</th></tr> <tr>",
                             "<form method=\"POST\"> <br/>",
                             "<input type=\"hidden\" name=\"empSelect\" value=\"yes\"/>",           // Ensure Employee Selection Sticks Around
                             "<input type=\"hidden\" name=\"user\" value=\"", $user[0], "\"/>",     // Ensure Employee Selection Data Sticks Around
                             "<input type=\"hidden\" name=\"empPass\" value=\"", $_POST["empPass"], "\"/>";     // Ensure Employee Selection Data Sticks Around

                        /* Pretty Source Code */ echo "\n";

                        // Current Inventory
                        echo "<td>",
                             "<u>Product ID:</u><nbsp> <input type=\"number\" name=\"idCI\" min=\"1\"/> <br/>",
                             "<br/><u>Category:</u><br/>",
                             "<input type=\"radio\" name=\"prodCat\" value=\"Name\"/> Name<br/>",
                             "<input type=\"radio\" name=\"prodCat\" value=\"Price\"/> Price<br/>",
                             "<input type=\"radio\" name=\"prodCat\" value=\"Quantity\"/> Quantity<br/>",
                             "<br/><u>New Datum:</u><nbsp> <input type=\"text\" name=\"datum\"/> <br/>",
                             "<br/><input type=\"submit\" name=\"enterCI\" value=\"ENTER\"/> <br/><br/> </td>";

                        /* Pretty Source Code */ echo "\n";

                        // New Inventory
                        echo "<td>",
                             "<br/><u>Name:</u><nbsp> <input type=\"text\" name=\"nameNI\"/><br/>",
                             "<br/><u>Price:</u><nbsp> $ <input type=\"number\" name=\"priceNI\" min=\"1\"/><br/>",
                             "<br/><u>Quantity:</u><nbsp> <input type=\"number\" name=\"quantNI\" min=\"1\"/><br/>",
                             "<br/><input type=\"submit\" name=\"enterNI\" value=\"ENTER\"/> <br/><br/> </td>";

                        /* Pretty Source Code */ echo "\n";

                        // Orders
                        echo "<td>",
                             "<u>Tracking #:</u><nbsp> <input type=\"number\" name=\"idO\" min=\"1\"/> <br/>",
                             "<br/><u>Processed:</u><nbsp>",
                             "<input type=\"radio\" name=\"orderProc\" value=\"Yes\"/> YES<nbsp>",
                             "<input type=\"radio\" name=\"orderProc\" value=\"No\"/> NO<nbsp><br/>",
                             "<br/><u>Shipped:</u><nbsp>",
                             "<input type=\"radio\" name=\"orderShip\" value=\"Yes\"/> YES<nbsp>",
                             "<input type=\"radio\" name=\"orderShip\" value=\"No\"/> NO<nbsp><br/>",
                             "<br/><u>Optional Notes:</u><nbsp> <input type=\"text\" name=\"oNotes\"/> <br/>",
                             "<br/><input type=\"submit\" name=\"enterO\" value=\"ENTER\"/>", 
                             "</form> <br/><br/> </td>";

                        /* Pretty Source Code */ echo "\n";

                        echo "</tr></table>";
                    } else {
                        echo "<h4>USERNAME / PASSWORD INCORRECT</h4>",
                             "<form action=\"https://students.cs.niu.edu/~z1838505/assignGroup_Emp.php\" method=\"POST\">",
                             "<input type=\"submit\" name=\"empPortal\" value=\"RETURN\" /> <br/>",
                             "</form> <br/>";
                    }
                } else {
                    echo "<h4>PLEASE SELECT USER & ENTER PASSWORD</h4>",
                         "<form action=\"https://students.cs.niu.edu/~z1838505/assignGroup_Emp.php\" method=\"POST\">",
                         "<input type=\"submit\" name=\"empPortal\" value=\"RETURN\" /> <br/>",
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
