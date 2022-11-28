<?php
    // drawTable Function
    function drawTable($rows) {
        try {
            echo "<table border=3 cellspacing=1> <tr>";
        
            // Print Table Header
            foreach($rows[0] as $key => $item) {
                echo "<th>$key</th>";
            }
            echo "</tr>";

            /* Pretty Source Code */ echo "\n";

            // Print Table Contents
            foreach($rows as $row) {
                echo "<tr>";
                foreach($row as $key => $item) {
                    echo "<td>$item</td>";
                }
                echo "</tr>";

                /* Pretty Source Code */ echo "\n";

            }
            echo "</table>";
        }
        catch (Exception $e) {
            echo "DRAW TABLE ERROR: ", $e->getMessage(), "\n";
        }
    }

    // drawDogs Function
    function drawDogs($pdo) {

        try {
            // Access Inventory
            $rs = $pdo->query("SELECT * FROM Inventory;");              // Select 'Inventory' from Maria
            $rowsIn = $rs->fetchAll(PDO::FETCH_ASSOC);  // By Column Name
            // Access Pics
            $rs = $pdo->query("SELECT * FROM Pics;");                         // Select 'Pics' from Maria
            $rowsPic = $rs->fetchAll(PDO::FETCH_NUM);   // By Index

            echo "<table border=10 width=100%> <tr>";
            $printNum = 0;  // Print Formatting (Control number of Entries before "newline")
            $picIndex = 0;  // Picture Selection Index

            // Button Prep
            echo "<form method=\"POST\">";
            
            // Print Pic & Name
            foreach($rowsIn as $rowIn) {

                /* Pretty Source Code */ echo "\n";

                $rowInSize = array_key_last($rowIn);

                // Pic Picker
                if (array_key_exists($picIndex, $rowsPic)) {
                    echo "<th><img src=", $rowsPic[$picIndex][1], "/> <br/> <br/>";
                } else {
                    echo "<th><img src=", PIC_DEFAULT, "/> <br/> <br/>";
                }
                // Name Print
                $name = $rowIn[$rowInSize];
                echo "<input type=\"submit\" name=\"Dog" . strval($picIndex + 1), "\"value=\"", $name, "\"/> <br/> </th>";
                $picIndex++;

                // Newline Control
                $printNum++;
                if ($printNum == 4) {
                    $printNum = 0;
                    echo "</tr>", "<tr>";
                }
            }
            // Ensure Uneven Newline Closure
            if ($printNum != 0) {
                echo "</tr>";
            }

            echo "</table>",
                 "</form>";
            
        }
        catch (Exception $e) {
            echo "DRAW DOGS ERROR: ", $e->getMessage(), "\n";
        }
    }

    // drawShop Function
    function drawShop($pdo) {
        try {
            // Access Cart
            $rs = $pdo->query("SELECT * FROM Cart;");              // Select 'Cart' from Maria
            $rowsCart = $rs->fetchAll(PDO::FETCH_NUM);  // By Index
            // Access Inventory
            $rs = $pdo->query("SELECT * FROM Inventory;");         // Select 'Inventory' from Maria
            $rowsIn = $rs->fetchAll(PDO::FETCH_NUM);    // By Index

            // Vars
            $total = 0;     // Sum of all Cost in Cart
            $subCount = 0;  // Counter for Sub-Table Formatting

            // If Cart has anything
            if ($rowsCart != NULL) {

                // Sub-Table Start
                echo "<table width=100%> <tr>";

                // Print it Out
                foreach($rowsCart as $rowCart) {
                    echo "<th width=25%>"; // Sub-Table Cont.

                    // Order Number
                    echo "OrderID: ", $rowCart[0], "<br/>",
                         $rowCart[1], " : ";

                    // Find Dog Name
                    foreach($rowsIn as $rowIn) {
                        if ($rowCart[3] == $rowIn[0]) {
                            echo $rowIn[3];
                        }
                    }
                    if ($rowCart[1] > 1) {echo "s";}    // Plural Formatting

                    // Price
                    echo "<br/>", "Price: $", $rowCart[2], "<br/> <br/>";
                    $total += $rowCart[2];

                    echo "</th>";   // Sub-Table Cont. Cont.
                    $subCount++;
                    if ($subCount > 3) {
                        echo "</tr> <tr>";
                        $subCount = 0;
                    }

                    /* Pretty Source Code */ echo "\n";
                }
                
                // Sub-Table End
                echo "</tr> </table>";

                // Total Cost Print
                echo "TOTAL COST IN CART: $", $total, "<br/>",
                     "<form action=\"https://students.cs.niu.edu/~z1838505/assignGroup_Checkout.php\" method=\"POST\"> ";
                     
                if (!(isset($_POST["checkout"]))) {
                    echo "<input type=\"submit\" name=\"checkout\" value=\"CHECKOUT\"/> <br/>";
                }
                
                echo "<input type=\"hidden\" name=\"totalCost\" value=\"", $total,"\"/> ", 
                     "</form>";

            } else {
                // Otherwise Blank
                echo " ";
            }
        }
        catch (Exception $e) {
            echo "SHOPPING CART CONFIRMATION ERROR: ", $e->getMessage(), "\n";
        }

        /* Pretty Source Code */ echo "\n\n";
    }

    // cartSelect Function
    function cartSelect($pdo) {
        try {
            // Access Inventory
            $rs = $pdo->query("SELECT * FROM Inventory;");              // Select 'Inventory' from Maria
            $rowsIn = $rs->fetchAll(PDO::FETCH_NUM);  // By Index
            // Access Pics
            $rs = $pdo->query("SELECT * FROM Pics;");                         // Select 'Pics' from Maria
            $rowsPic = $rs->fetchAll(PDO::FETCH_NUM);   // By Index

            foreach($rowsIn as $rowIn) {
                // Selection is Made
                if(isset($_POST["Dog" . $rowIn[0]])) {
                    // Print Selection
                    echo "<th style=\"width:15%\"> <img src=", $rowsPic[$rowIn[0] - 1][1], "/> </th>",
                         "<th style=\"width:10%\">"; 
                         
                    if ($rowIn[2] > 0) {
                        echo "<form method=\"POST\">",
                             "<input type=\"number\" name=\"quantSelect\" value=\"1\" min=\"1\" max=\"", $rowIn[2], "\"/> :: ", $rowIn[2], "<br/> <br/>",
                             "<input type=\"submit\" name=\"cartSubmit\" value=\"", $rowIn[3], "\"/> <br/> </th>",
                             "</form> </th>";
                    } else {
                        echo "OUT OF STOCK </th>";
                    }
                }
                // Record Selection in Cart
                if(isset($_POST["cartSubmit"]) && $_POST["cartSubmit"] == $rowIn[3]) {
                    $pdo->query("INSERT INTO Cart (Quantity, Total, Product_ID)
                                    VALUES (" . $_POST["quantSelect"] . ", " . ($_POST["quantSelect"] * $rowIn[1]) . ", " . $rowIn[0] . ");");
    
                    // Calculate new Quantity in Stock
                    $quantChange = $rowIn[2] - $_POST["quantSelect"];
                    if ($quantChange < 0) {$quantChange = 0;} // Just in Case
    
                    // Subtract Selection from Quantity
                    $pdo->query("UPDATE Inventory SET QuantityinStock = " . strval($quantChange) . " WHERE Product_ID = " . strval($rowIn[0]) . ";");
                }
            }

            /* Pretty Source Code */ echo "\n";

        }
        catch (Exception $e) {
            echo "SHOPPING CART SELECTION ERROR: ", $e->getMessage(), "\n";
        }
    }
?>