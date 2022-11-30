<html>
    <head><title>CSCI 466: Group 5</title></head>
    <body>
        <h1>Employee Portal ~In Progress~</h1>
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

            // Customer Selection Confrimation
            if (!(isset($_POST["empSelect"]))) { // Only if it hasn't happened yet
                echo "<u><b>Employee Check-In:</u></b>",
                     "<form method=\"POST\">",
                     "<br/> <input type=\"submit\" name=\"empSelect\" value=\"CONFIRM IDENTITY\" /> <br/><br/>";

                // User Checkout Form
                foreach($rowsUse as $rowUse) {
                    if ($rowUse[8] == 1) {
                        echo "<input type=\"radio\" name=\"user\" value=\"", $rowUse[0], "\" />", $rowUse[0], "<br/> ";
                    }

                    /* Pretty Source Code */ echo "\n";

                }
                echo "</form> <br/>";

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
                if (isset($_POST["user"])) {    // If User was even selected
                    // Employee Data
                    foreach($rowsUse as $rowUse) {
                        if ($_POST["user"] == $rowUse[0]) {
                            $user = $rowUse;
                            echo "<br/><br/>",
                                 "User: ", strval($rowUse[0]), "<br/>",
                                 "Address: ", strval($rowUse[2]), "<br/>",
                                 "Email: ", strval($rowUse[3]), "<br/>"; 
                        }

                        /* Pretty Source Code */ echo "\n";
                        
                    }
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
                                     $rowIn[2] . "</td> <td>" . 
                                     $rowIn[3] . "</td> </tr>";
                                     
                            }

                            /* Pretty Source Code */ echo "\n";

                        }
                        echo "</table> <br/><br/>";

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
                                        "ConfirmationID: ", $rowOrd[0], "<br/>",
                                        "ProductID: ", $prodID, "<br/>",
                                        "Quantity: ", $quant, "<br/>",
                                        "To: ", $rowOrd[4], "<br/>",
                                        "Paid: $", $rowOrd[3], "<br/>";
                                    if ($rowOrd[1] == 0) {echo "PROCESSING... <br/>";}
                                    else {echo "FULLY PROCESSED <br/>";}
                                    if ($rowOrd[2] == 0) {echo "NOT SHIPPED <br/>";}
                                    else {echo "SHIPPED <br/>";}
                                    echo "Further Notes:" . $sBuff . "</th>";
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

                        // Calculate new Quantity in Stock
                        //$quantChange = $rowIn[3] - $_POST["quantSelect"];
                        //if ($quantChange < 0) {$quantChange = 0;} // Just in Case
        
                        // Subtract Selection from Quantity
                        //$pdo->query("UPDATE Inventory SET QuantityinStock = " . strval($quantChange) . " WHERE Product_ID = " . strval($rowIn[0]) . ";");
                        
                    }

                } else {
                    echo "<h4>PLEASE SELECT USER</h4>",
                         "<form action=\"https://students.cs.niu.edu/~z1838505/assignGroup_Emp.php\" method=\"POST\">",
                         "<input type=\"submit\" name=\"empPortal\" value=\"RETURN\" /> <br/>",
                         "</form> <br/>";
                }
            }
            
        ?>
        </body>
</html>