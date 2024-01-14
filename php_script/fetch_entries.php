<?php

session_start();

require('DBConnect.php');

if(isset($_POST['dob'])&&isset($_POST['gender'])&&isset($_POST['caste'])&&isset($_POST['qualification']))
{

    $entries = array();
    $upcoming = array();
    $category =array();

    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $qualification = $_POST['qualification'];
    $caste = $_POST['caste'];

    $stream = '';

    

    if(isset($_POST['stream']))
    {
        $stream = $_POST['stream'];
    }
    
    $caste_array = array("SC/ST","OBC");

    $rank_array = array("4","5","6"); //4 = Para Military, 5 = Coast Guard, 6 = Police

    if(!empty($dob)&&!empty($gender)&&!empty($caste)&&!empty($qualification))
    {
        if($qualification=='Graduation'||$qualification=='Graduation (Appearing)')
        {
            if($stream!='')
            {
                if($stream=='Others'||$stream=='BA'||$stream=='BCom')
                {
                    $sql = "SELECT * FROM entries WHERE gender like '%$gender%' AND qualification IN ('10th','12th','Graduation') AND qualification!='Diploma' AND stream NOT LIKE '%BE%' AND stream NOT LIKE '%BTECH%' AND stream NOT LIKE '%BSC%' AND stream NOT LIKE '%BSCIT%' AND stream NOT LIKE '%Science (PCB)%' AND stream NOT LIKE '%Science (PCM)%' AND stream NOT LIKE '%Science (PCMB)%' ORDER BY rank_sequence ASC";
                }   
                elseif($stream=='BE'||$stream=='BTECH')
                {
                    
                    $sql = "SELECT * FROM entries WHERE gender like '%$gender%' AND qualification IN ('10th','12th','Graduation') AND qualification!='Diploma' OR stream LIKE '%BE%' OR stream LIKE '%BTECH%' ORDER BY rank_sequence ASC";
                }
                elseif($stream=='BSC'||$stream=='BSCIT')
                {
                    $sql = "SELECT * FROM entries WHERE gender like '%$gender%' AND qualification IN ('10th','12th','Graduation') AND qualification!='Diploma' AND stream !='BE, BTECH' ORDER BY rank_sequence ASC";
                 
                }
            }            
        }
        elseif($qualification=='Diploma'||$qualification=='Diploma (Appearing)')
        {
            $sql = "SELECT * FROM entries WHERE gender like '%$gender%' AND qualification IN ('10th','Diploma') ORDER BY rank_sequence ASC";
        }
        elseif($qualification=='12th'||$qualification=='12th (Appearing)')
        {
            if($stream!='')
            {
                if($stream=="Science (PCB)"||$stream=="Science (PCMB)")
                {
                    
                    $sql = "SELECT * FROM entries WHERE gender like '%$gender%' AND qualification IN ('10th','12th') ORDER BY rank_sequence ASC";

                }
                elseif($stream=="Science (PCM)")
                {
                    
                    $sql = "SELECT * FROM entries WHERE gender like '%$gender%' AND qualification IN ('10th','12th') OR stream!='Science (PCB)' ORDER BY rank_sequence ASC";
                    
                }
                elseif($stream=="Commerce" || $stream=="Arts")
                {
                    
                    $sql = "SELECT * FROM entries WHERE gender like '%$gender%' AND qualification IN ('10th','12th') OR (stream NOT LIKE '%Science (PCB)%' AND stream NOT LIKE '%Science (PCM)%' AND stream NOT LIKE '%Science (PCMB)%') ORDER BY rank_sequence ASC";

                }
                
            }
            else
            {
                $sql = "SELECT * FROM entries WHERE gender like '%$gender%' AND qualification IN ('10th','12th') ORDER BY rank_sequence ASC";
            }
        }
        elseif($qualification=='10th'||$qualification=='10th (Appearing)')
        {

            $sql = "SELECT * FROM entries WHERE gender like '%$gender%' AND qualification='10th' ORDER BY rank_sequence ASC";
            
        }

        $query = $con_new->query($sql);
        if(mysqli_num_rows($query)>0)
        {
            while($data = mysqli_fetch_array($query,MYSQLI_ASSOC))
            {
                $date_start = strtotime($data['dob_start']);
                $date_dob = strtotime($dob);
                $date_end = strtotime($data['dob_end']);

                if($date_start<$date_dob)
                {

                    if($caste=='Open'&&$data['caste']=='Open')
                    {
                        if(in_array($data['category'],$category)==false)
                        {
                            array_push($category, $data['category']);
                        }

                        array_push($entries, array(
                            'entry_id'=>$data['id'],
                            'category'=>$data['category'],
                            'entries'=>$data['entries'],
                            'qualification'=>$data['qualification'],
                            'stream'=>$data['stream'],
                            'type'=>$data['type'],
                            'percentage'=>$data['percentage'],
                            'gender'=>$data['gender'],
                            'height_male'=>$data['height_male'],
                            'height_female'=>$data['height_female'],
                            'apply_month'=>$data['apply_month'],
                            'caste'=>$data['caste'],
                            'age'=>$data['age'],
                        ));
                        
                    }
                    elseif(in_array($caste,$caste_array)==true)
                    {
                        
                        if($caste==$data['caste']&&in_array($data['rank_sequence'],$rank_array)==true)
                        {
                            if(in_array($data['category'],$category)==false)
                            {
                                array_push($category, $data['category']);
                            }

                            array_push($entries, array(
                                'entry_id'=>$data['id'],
                                'category'=>$data['category'],
                                'entries'=>$data['entries'],
                                'qualification'=>$data['qualification'],
                                'stream'=>$data['stream'],
                                'type'=>$data['type'],
                                'percentage'=>$data['percentage'],
                                'gender'=>$data['gender'],
                                'height_male'=>$data['height_male'],
                                'height_female'=>$data['height_female'],
                                'apply_month'=>$data['apply_month'],
                                'caste'=>$data['caste'],
                                'age'=>$data['age'],
                                'echo'=>$echo
                            ));
                        }
                        elseif($data['caste']=='Open'&&in_array($data['rank_sequence'],$rank_array)==false)
                        {
                            if(in_array($data['category'],$category)==false)
                            {
                                array_push($category, $data['category']);
                            }

                            array_push($entries, array(
                                'entry_id'=>$data['id'],
                                'category'=>$data['category'],
                                'entries'=>$data['entries'],
                                'qualification'=>$data['qualification'],
                                'stream'=>$data['stream'],
                                'type'=>$data['type'],
                                'percentage'=>$data['percentage'],
                                'gender'=>$data['gender'],
                                'height_male'=>$data['height_male'],
                                'height_female'=>$data['height_female'],
                                'apply_month'=>$data['apply_month'],
                                'caste'=>$data['caste'],
                                'age'=>$data['age'],
                                'echo'=>$echo
                            ));
                        }                        
                    }                                      
                }

            }
        
            $response = array(
                'error'=>false,
                'entries'=>$entries,
                'userData'=>$_POST,
                'category'=>$category,
                'upcoming'=>$upcoming
            );
        }
        else
        {
            $response = array(
                'error'=>true,
                'message'=>'No Entries Found'
            );
        }     
    }
    else
    {
        $response = array(
            'error'=>true,
            'message'=>'Fill in all fields'
        );
    }
}
else
{
    $response = array(
        'error'=>true,
        'message'=>'Fill in all fields'
    );
}

echo json_encode($response);

?>