<html>
    <head><title>CSCI 466: Group 5</title></head>
    <body>
        <h1>NEW USER REDIRECT</h1>
        <h2>CSCI 466 Group Project</h2>

        <?php
            // Includes
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
            
            // User Entry Form
            echo "<form method=\"POST\"> <br/><br/>";
            $useType = "00";    // Iscust & Isemp data buffer
            if (isset($_POST["useType"])) {$useType = $_POST["useType"];}
            // New Customer Check
            if (isset($_POST["newCust"])) {
                echo "<h4><u>New Customer Entry:</u></h4>";
                $useType = "10";
            }
            // New Employee Check
            if (isset($_POST["newEmp"])) {
                echo "<h4><u>New Employee Entry:</u></h4>";
                $useType = "01";
            }
            
            /* Pretty Source Code */ echo "\n";
            
            // New User Data Entry
            echo "<br/> Username: <nbsp> <input type=\"text\" name=\"username\"/> <br/>
                  <br/> Password: <nbsp> <input type=\"text\" name=\"password\"/> <br/>
                  <br/> Shipping Address: <nbsp> <input type=\"text\" name=\"address\"/> <br/>
                  <br/> Email: <nbsp> <input type=\"text\" name=\"email\"/> <br/>
                  <br/> CCV: <nbsp> <input type=\"number\" name=\"ccv\" min=\"0\" max=\"999\"/> <br/>
                  <br/> CC Number: <nbsp> <input type=\"text\" name=\"cc_num\" /> <br/>
                  <br/> CC Expiration Date: <nbsp> <input type=\"text\" name=\"cc_exp\"/> <br/>
                  <br/> <br/> <input type=\"submit\" name=\"enter\" value=\"ENTER\" /> <br/>
                  <input type=\"hidden\" name=\"url\" value=\"" . $_POST["url"] . "\" />
                  <input type=\"hidden\" name=\"useType\" value=\"" . $useType . "\" />
                  </form>";

                  /* Pretty Source Code */ echo "\n";

            // Check for All Entries
            if (isset($_POST["enter"])) {   // Once Entered
                // And all of the data is filled in
                if ($_POST["username"] != NULL && $_POST["password"] != NULL && $_POST["address"] != NULL &&
                    $_POST["email"] != NULL && $_POST["ccv"] != 0 && $_POST["cc_num"] != NULL && $_POST["cc_exp"] != NULL) {
                    // And there's no repeat Usernames
                    $userBool = TRUE;
                    foreach ($rowsUse as $rowUse) {
                        if ($rowUse[0] == $_POST["username"]) {$userBool = FALSE;}
                        /* Pretty Source Code */ echo "\n";
                    }
                    if ($userBool) {
                        // And cc_num is 16 digits long
                        if (strlen($_POST["cc_num"]) == 16) {
                            // Display it
                            echo "<p><b>Is This Correct?</b></p>",
                                $_POST["username"], "<br/>", $_POST["password"], "<br/>", $_POST["address"], "<br/>",
                                $_POST["email"], "<br/>", $_POST["ccv"], "<br/>", $_POST["cc_num"], "<br/>", $_POST["cc_exp"], "<br/>";
                    
                            // Send Them Along
                            echo "<form action=\"", $_POST["url"], "\" method=\"POST\"> <br/>",
                                "<input type=\"submit\" name\"checkout\" value=\"CONFIRM\" />",
                            // Pass Along Data
                                "<input type=\"hidden\" name=\"username\" value=\"" . $_POST["username"] . "\" />",
                                "<input type=\"hidden\" name=\"password\" value=\"" . $_POST["password"] . "\" />",
                                "<input type=\"hidden\" name=\"address\" value=\"" . $_POST["address"] . "\" />",
                                "<input type=\"hidden\" name=\"email\" value=\"" . $_POST["email"] . "\" />",
                                "<input type=\"hidden\" name=\"ccv\" value=\"" . $_POST["ccv"] . "\" />",
                                "<input type=\"hidden\" name=\"cc_num\" value=\"" . $_POST["cc_num"] . "\" />",
                                "<input type=\"hidden\" name=\"cc_exp\" value=\"" . $_POST["cc_exp"] . "\" />",
                                "<input type=\"hidden\" name=\"isCust\" value=\"" . $_POST["useType"][0] . "\" />",
                                "<input type=\"hidden\" name=\"isEmp\" value=\"" . $_POST["useType"][1] . "\" />",
                                "<input type=\"hidden\" name=\"checkout\" value=\"idk\" />",   // Submit being weird, gotta help the Shopping Cart Print
                                "</form>";

                                /* Pretty Source Code */ echo "\n";
                                
                        } else {echo "<h4>PLEASE SELECT A 16-DIGIT CC NUMBER</h4>";}
                    } else {echo "<h4>PLEASE SELECT A DIFFERENT USERNAME</h4>";}
                } else {echo "<h4>PLEASE FILL ENTIRE FORM</h4>";}
            }
            
        ?>

    </body>
</html>
