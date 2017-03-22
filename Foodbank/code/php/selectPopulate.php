<?php
    function popSelect() {
        include $_SERVER['DOCUMENT_ROOT'] . "/Foodbank/code/php/databasePHPFunctions.php";
        $connection = db_connect();
        $date = date("Y-m-d");

        $rows = db_select("SELECT calendar_entry.volunteer_id as id, volunteer_fname as firstName, volunteer_lname as lastName FROM calendar_entry JOIN volunteer ON calendar_entry.volunteer_id=volunteer.volunteer_id WHERE calendar_date='$date' AND crossed_out='0'");

        foreach($rows as $row) {
            $inner = $row['id'] . ":" . $row['firstName'] . " " . $row['lastName'];
            echo "<option value='".$row['id']."'>$inner</option>";
        }
    }
?>