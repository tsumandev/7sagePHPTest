<?php
    $conn = mysqli_connect("localhost", "root", "", "test");
    $params = array();
    $results = array();

    $init = isset($_POST['init']) ? $_POST['init'] : 0;
    if ( $init ) {
        $results = array();
        for ($i = 1; $i <= 4; $i ++) {
            $query = "SELECT SUM(LEFT(duration_time,2))*3600 + SUM(MID(duration_time,4,2))*60 + SUM(RIGHT(duration_time,2)) AS sum_seconds FROM tbl_lessons WHERE type=$i";
            $result = $conn->query($query);
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $sum_seconds = $row["sum_seconds"];
            $hours = ceil($sum_seconds / 3600);
            $results[$i-1] = $hours;
            // $hours = floor($sum_seconds / 3600);
            // $mins = floor(($sum_seconds - $hours * 3600) / 60);
            // $seconds = $sum_seconds - $hours * 3600 - $mins * 60;
            // $results[$i-1] = sprintf("%02d:%02d:%02d", $hours, $mins, $seconds);
        }

        mysqli_close($conn);    
        echo json_encode($results);
        exit;
    }
    
    for ($i = 0; $i < 4; $i ++) {
        $key = "param_" . ($i+1);
        $limit = isset($_POST[$key]) ? $_POST[$key] : 0;
        $ts_limit = $limit * 60 * 60;
        $ts_sum = 0;
        $arr_id_chain = "0";
        $arr_lessons_chain = "";
        // echo "TYPE : $i\n";
        while ( $ts_sum < $ts_limit ) {
            $ts_diff = $ts_limit - $ts_sum;
            $query = "SELECT * FROM tbl_lessons WHERE type=".($i+1)." AND LEFT(duration_time,2)*3600+MID(duration_time,4,2)*60+RIGHT(duration_time,2) < $ts_diff AND id NOT IN ($arr_id_chain) ORDER BY duration_time DESC";
            // echo ($query."\n");
            $result = $conn->query($query);
            $row = $result->fetch_array(MYSQLI_ASSOC);
            if ( $row ) {
                if ( sizeof($row) > 0 ) {
                    // var_dump($row); echo "\n";
                    $arr_id_chain .= "," . $row['id'];
                    $arr_lessons_chain .= $row['lesson_name'] . "<br>";
    
                    $duration_time = $row['duration_time'];
                    $arr_time = explode(":", $duration_time);
                    $ts = $arr_time[0] * 3600 + $arr_time[1] * 60 + $arr_time[2];
                    $ts_sum += $ts;
                }
            } else {
                break;
            }
        }
        $results[$i] = $arr_lessons_chain;
    }
    mysqli_close($conn);

    echo json_encode($results);
?>