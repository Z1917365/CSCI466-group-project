<html>
    <head><title>CSCI 466: Group 5</title></head>
    <body>
        <h1>100% Actual Dog Store, For Sure</h1>
        <h2>CSCI 466 Group Project</h2>
        
        <?php
            // Includes
            include ("assignGroup_lib.php");
            include ("secrets.php");

            // Constants
            const SQL = "main.sql";   // For easy change of SQL Script

            // Try to Access MariaDB
            try {
                $dsn = "mysql:host=courses;dbname=z1838505";
                $pdo = new PDO($dsn, $username, $password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);   // Fix crap default errors

                // Setup Database with SQL statment
                $pdo->exec(file_get_contents(SQL));

                //Test: Draw Inventory
                $rs = $pdo->query("SELECT * FROM Inventory;");              // Select 'Inventory' from Maria
                $rows = $rs->fetchAll(PDO::FETCH_ASSOC);
                drawTable($rows);                                           // Draw Table
            }
            // Catch Failed Access
            catch(PDOexception $e) {
                echo "Connection to database failed: " . $e->getMessage();
            }

        ?>

    </body>
</html>
