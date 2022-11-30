<html>
    <head><title>CSCI 466: Group 5 START</title></head>
    <body>
        <h1>RESET SQLS</h1>
        <h2>CSCI 466 Group Project</h2>

        <?php
            // Constants
            const SQL = "main.sql";   // For easy change of SQL Script
            const SQL_RESET = "removeMain.sql"; // To clear space for SQL Script

            // Includes
            include ("secrets.php");

            // Try to Access MariaDB
            try {
                $dsn = "mysql:host=courses;dbname=z1838505";
                $pdo = new PDO($dsn, $username, $password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);   // Fix crap default errors

                //TEST Setup Database
                $pdo->exec(file_get_contents(SQL_RESET));
                $pdo->exec(file_get_contents(SQL));
            }
            // Catch Failed Access
            catch(PDOexception $e) {
                echo "Connection to database failed: " . $e->getMessage();
            }
        ?>

        <form action="https://students.cs.niu.edu/~z1838505/assignGroup.php" method="POST">
            <input type="submit" name="go" value="GO" />
        </form>

    </body>
</html>