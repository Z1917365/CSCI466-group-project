<html>
    <head><title>CSCI 466: Group 5</title></head>
    <body><h1>Employee Portal ~In Progress~</h1><body>
        <?php
            // Constants
            //

            // Incudes
            include ("assignGroup_lib.php");
            include ("secrets.php");

            // Try to Access MariaDB
            try {
                $dsn = "mysql:host=courses;dbname=z1838505";
                $pdo = new PDO($dsn, $username, $password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);   // Fix crap default errors
                
                //

                // List all Employees
                $rsUser = $pdo->query("SELECT * FROM User;");                      // Select 'Emp' from Maria
                $rows = $rsUser->fetchAll(PDO::FETCH_ASSOC);
                echo "<table border=3 cellspacing=1> <tr>";
                // Print User Table Header
                foreach($rows[0] as $key => $item) {
                    echo "<th>$key</th>";
                }
                echo "</tr>";
                // Print User Table Contents IF Employee
                foreach($rows as $row) {
                    echo "<tr>";

                    if ($row[array_key_last($row)] == 1) {   // Isemp is final key ~= Bool
                        foreach($row as $key => $item) {
                            echo "<td>$item</td>";
                        }
                    }
                    
                    echo "</tr>";
                }
                echo "</table>";

            }
            // Catch Failed Access
            catch(PDOexception $e) {
                echo "Connection to database failed: " . $e->getMessage();
            }
            
        ?>
</html>