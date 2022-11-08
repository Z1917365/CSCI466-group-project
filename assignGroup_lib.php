<?php
    // drawTable Function
    function drawTable($rows) {
        echo "<table border=3 cellspacing=1> <tr>";
        
        // Print Table Header
        foreach($rows[0] as $key => $item) {
            echo "<th>$key</th>";
        }
        echo "</tr>";

        // Print Table Contents
        foreach($rows as $row) {
            echo "<tr>";
            foreach($row as $key => $item) {
                echo "<td>$item</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    }

?>