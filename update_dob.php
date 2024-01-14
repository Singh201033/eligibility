<?php

session_start();

require('php_script/DBConnect.php');

$sql = "SELECT entry_id,dob_start,dob_end,date_update_1,date_update_2,month_to_be_incremented FROM tb_entries";
$query = $con->query($sql);
if(mysqli_num_rows($query)>0)
{
    $entries_updated = array();

    while($data = mysqli_fetch_array($query,MYSQLI_ASSOC))
    {
        $entry_id = $data['entry_id'];

        date_default_timezone_set('Asia/Kolkata');
        $date = date('Y-m-d');

        $date_update_1 = strtotime($data['date_update_1']);
        $current_date = strtotime($date);
        $date_update_2 = strtotime($data['date_update_2']);

        $increment_value = $data['month_to_be_incremented']." months";        
       
        if($current_date==$date_update_1)
        {
            // dob_start increment
            $dob =  date_create($data['dob_start']);
            date_add($dob,date_interval_create_from_date_string($increment_value));
            $dob_start = date_format($dob,"Y-m-d");

            // dob_end increment
            $dob =  date_create($data['dob_end']);
            date_add($dob,date_interval_create_from_date_string($increment_value));
            $dob_end = date_format($dob,"Y-m-d");

            // dob_update_1 increment
            $dob =  date_create($data['dob_update_1']);
            date_add($dob,date_interval_create_from_date_string("12 months"));
            $dob_update_1 = date_format($dob,"Y-m-d");

            $sql_update = "UPDATE tb_entries SET dob_start='$dob_start',dob_end='$dob_end',dob_update_1='$dob_update_1' WHERE entry_id='$entry_id'";
            $query_update = $con->query($sql_update);

            
        }
        elseif($current_date==$date_update_2)
        {
            // dob_start increment
            $dob =  date_create($data['dob_start']);
            date_add($dob,date_interval_create_from_date_string($increment_value));
            $dob_start = date_format($dob,"Y-m-d");

            // dob_end increment
            $dob =  date_create($data['dob_end']);
            date_add($dob,date_interval_create_from_date_string($increment_value));
            $dob_end = date_format($dob,"Y-m-d");

            // dob_update_1 increment
            $dob =  date_create($data['date_update_2']);
            date_add($dob,date_interval_create_from_date_string("12 months"));
            $dob_update_2 = date_format($dob,"Y-m-d");

            $sql_update = "UPDATE tb_entries SET dob_start='$dob_start',dob_end='$dob_end',dob_update_2='$dob_update_2' WHERE entry_id='$entry_id'";
            $query_update = $con->query($sql_update);
        }
    }
}





?>