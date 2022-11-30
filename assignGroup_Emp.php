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
            // Access Inventory
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
                // Selected User Display
                if (isset($_POST["user"])) {    // If User was even selected
                    // Employee Data
                    foreach($rowsUse as $rowUse) {
                        if ($_POST["user"] == $rowUse[0]) {    // If Username was selected
                            $user = $rowUse[0];
                            echo "<br/><br/>",
                                 "User: ", strval($rowUse[0]), "<br/>",
                                 "Address: ", strval($rowUse[2]), "<br/>",
                                 "Email: ", strval($rowUse[3]), "<br/>"; 
                        }

                        /* Pretty Source Code */ echo "\n";
                        
                    }
                    // Employee Product Data
                    //foreach()
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