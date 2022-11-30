<html>
    <head><title>CSCI 466: Group 5</title></head>
    <body>
        <h1>FULL ORDERS LIST</h1>
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

            // Access Inventory
            $rs = $pdo->query("SELECT * FROM Inventory;");  // Select 'Inventory' from Maria
            $rowsIn = $rs->fetchAll(PDO::FETCH_NUM);        // By Index
            // Access Orders
            $rs = $pdo->query("SELECT * FROM Orders;");     // Select 'Orders' from Maria
            $rowsOrd = $rs->fetchAll(PDO::FETCH_NUM);       // By Index
            
            // Print out All Inventory
            echo "<h4>ALL INVENTORY:</h4>",
                 "<table width=100% border=3 cellspacing=1> <tr>",
                 "<th width=10%>ProductID:</th>",
                 "<th>Name:</th>",
                 "<th>Quantity:</th>",
                 "<th>Price:</th> </tr>";
            foreach ($rowsIn as $rowIn) {
                echo "<tr>",
                     "<td>", $rowIn[0], "</td>",
                     "<td>", $rowIn[4], "</td>",
                     "<td>", $rowIn[3], "</td>",
                     "<td>$", $rowIn[2], "</td>",
                     "</tr>";
            }
            echo "</table> <br/>";

            // Print out All Orders
            echo "<h4>ALL ORDERS:</h4>",
                 "<table width=100% border=5> <tr><th>",
                 "<table width=100%> <tr>";

            // Find ProductID & Quantity
            $lineCount = 0; // Sub-Table Formatting
            $sBuff = "";    // Extract data from add_note with string Buffer
            $sCount = 0;    // Assist sBuff, ':' counter
            $quant;         // Hold Quantity
            foreach ($rowsOrd as $rowOrd) {
                foreach(str_split($rowOrd[5]) as $cBuff) {
                    switch ($cBuff) {
                        case ':':
                            $sCount++;
                            if ($sCount == 1) { // Record Quantity 
                                $quant = $sBuff;
                                $sBuff = "";
                            }
                            break;

                        default:
                            if ($sCount < 2) {$sBuff = $sBuff . $cBuff;}
                            break;
                    }
                }
                // Print
                echo "<th height=200 width=25%>", 
                        "Tracking Number: ", $rowOrd[0], "<br/>",
                        "ProductID: ", $sBuff, "<br/>",
                        "Quantity: ", $quant, "<br/>",
                        "To: ", $rowOrd[4], "<br/>",
                        "Payment: $", $rowOrd[3], "<br/>";
                if ($rowOrd[1] == 0) {echo "PROCESSING... <br/>";}
                else {echo "FULLY PROCESSED <br/>";}
                if ($rowOrd[2] == 0) {echo "NOT SHIPPED <br/>";}
                else {echo "SHIPPED <br/>";}
                echo "</th>";

                // Newline Control
                $lineCount++;
                if ($lineCount > 3) {echo "</tr> <tr>"; $lineCount = 0;}

                // Reset
                $sCount = 0;
                $sBuff = "";

            }
            echo "</tr></table> </th></tr></table>";
        ?>

        <h4><u>Return to Homepage?</u></h4>
        <form action="https://students.cs.niu.edu/~z1838505/assignGroup.php" method="POST">
            <input type="submit" name="go" value="RETURN" />
        </form>

    </body>
</html>