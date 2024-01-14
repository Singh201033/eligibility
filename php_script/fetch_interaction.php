<?php

session_start();

require('DBConnect.php');

if (isset($_POST['highest_qualification'])) {
    $stream = array();
    $highest_qualification = $_POST['highest_qualification'];
    if ($highest_qualification == 'Graduation' || $highest_qualification == 'Graduation (Appearing)') {
        $sql = "SELECT stream FROM tb_qualification WHERE qualification='graduation' ORDER BY stream ASC";
        $query = $con->query($sql);
        if (mysqli_num_rows($query) > 0) {
            while ($data = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
                array_push($stream, $data['stream']);
            }

            $response = array(
                'error' => false,
                'stream_option' => true,
                'streams' => $stream
            );
        } else {
            $response = array(
                'error' => true,
                'message' => 'Something went wrong! Please refresh and try again'
            );
        }
    } elseif ($highest_qualification == '12th' || $highest_qualification == '12th (Appearing)') {
        $sql = "SELECT stream FROM tb_qualification WHERE qualification='12th' ORDER BY stream ASC";
        $query = $con->query($sql);
        if (mysqli_num_rows($query) > 0) {
            while ($data = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
                array_push($stream, $data['stream']);
            }

            $response = array(
                'error' => false,
                'stream_option' => true,
                'streams' => $stream
            );
        } else {
            $response = array(
                'error' => true,
                'message' => 'Something went wrong! Please refresh and try again'
            );
        }
    } else {
        $response = array(
            'error' => false,
            'stream_option' => false
        );
    }
} else {
    $response = array(
        'error' => true,
        'message' => 'Something went wrong!'
    );
}



echo json_encode($response);
