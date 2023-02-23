<?php
    $conn = mysqli_connect("localhost", "root", "", "test");
    
    $query = "SELECT * FROM tbl_lessons";
    $result = $conn->query($query);
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $duration_str = $row["duration"];
        $arr = explode("hrs ", $duration_str);
        $hour = 0;
        $min = 0;
        if (sizeof($arr) > 1) {
            $hour = $arr[0];
            $min = intval($arr[1]);
        } else {
            $arr = explode("hr", $duration_str);
            $min = intval($arr[0]);
            if ( sizeof($arr) > 1 ) {
                $hour = $arr[0];
                $min = intval($arr[1]);
            }
        }
        $duration_time = $hour . ":" . $min;
        printf("%s (%s)\n", $duration_str, $duration_time);
        $conn->query("UPDATE tbl_lessons SET duration_time='$duration_time' WHERE id={$row['id']}");
    }

    mysqli_close($conn);
?>