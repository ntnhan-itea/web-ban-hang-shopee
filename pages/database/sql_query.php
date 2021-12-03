
<?php

    
require_once("db_name.php");


function sql_query($sql) {

    $sql = check_valid_sql($sql);
    

    $conn = mysqli_connect(servername, username, password, dbname);
    mysqli_set_charset($conn, 'utf8');

    // Check connection
    if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
    }


    $result = mysqli_query($conn, $sql);
    $data = [];

    if (mysqli_num_rows($result) > 0) {
        // $i = 0;
        while($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
        // $i++;
        }
    } 

    mysqli_close($conn);
    // require_once("close_sql.php");

    return $data;
}


function sql_execute($sql) {

    $sql = check_valid_sql($sql);

    // Create connection
    $conn = mysqli_connect(servername, username, password, dbname);
    mysqli_set_charset($conn, 'utf8');

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $check_success = false;

    if (mysqli_query($conn, $sql)) {

        echo "Executed successfully !! <br/>";
        $check_success = true;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        $check_success = false;
    }

    mysqli_close($conn);

    return $check_success;

}

    
function check_valid_sql($sql) {

    // $sql = str_replace("'", "\'", $sql);

    return trim($sql);

}
