<html>
    <head><title>CSCI 466: Group 5</title></head>
    <body>
        <h1>100% Actual Dog Store, For Sure ~In Progress~</h1>
        <h2>CSCI 466 Group Project</h2>
        
        <?php
            // Constants
            const SQL = "main.sql";   // For easy change of SQL Script
            const SQL_RESET = "removeMain.sql"; // To clear space for SQL Script

            const PIC_DEFAULT = "https://i.imgur.com/TaPgJZM.png";  // Default Picture for Dogs when no picture available
            
            // Includes
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

            // Button to Switch to Employee Site
            echo "<table width=100%> <tr><th style=\"width:43%\"></th><th> <table border=25> <tr><th>",
                 "<img src=", PIC_DEFAULT, "/>",
                 "<form action=\"assignGroup_Emp.php\" method=\"POST\">",
                 "<input type=\"submit\" name=\"submitEmp\" value=\"EMPLOYEE PORTAL\"/> </form>",
                 "</th></tr></table> </th></tr> </table>";

            // Shopping Cart
            echo "<h3>Shopping Cart:</h3>",
                 "<table border=10 height=10% width=100%> <tr>"; 
            cartSelect($pdo);   // Display & Submit Cart Selections
            echo "<th>";
            drawShop($pdo);     // Print Cart Contents
            echo "</th> </tr> </table> <br/>";
            
            // Draw Dogs
            echo "<h3>Dog Selection:</h3>";
            drawDogs($pdo);

            /* Pretty Source Code */ echo "\n\n";

            //Test: Draw Tables
            $rs = $pdo->query("SELECT * FROM Inventory;");              // Select 'Inventory' from Maria
            $rows = $rs->fetchAll(PDO::FETCH_ASSOC);
            drawTable($rows);                                           // Draw Table
            //TEST
            $rs = $pdo->query("SELECT * FROM User;");
            $rows = $rs->fetchAll(PDO::FETCH_ASSOC);
            drawTable($rows);                                           // Again
            //TTTTEEEEEESSSSSSTTTTTT
            $rs = $pdo->query("SELECT * FROM Orders;");
            $rows = $rs->fetchAll(PDO::FETCH_ASSOC);
            drawTable($rows);                                           // Again Again

            /* Pretty Source Code */ echo "\n\n";

        ?>

    </body>
</html>
