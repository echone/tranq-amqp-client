<?php
 
if (isset($_GET['uid'])) {
 
    // Fetch the upload progress data
    $status = uploadprogress_get_info($_GET['uid']);
 
    if ($status) {
 
        // Calculate the current percentage
        echo round($status['bytes_uploaded']/$status['bytes_total']*100);
 
    }
    else {
 
        // If there is no data, assume it's done
        echo 100;
 
    }
}
?>
