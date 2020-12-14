<?php
include '../../includes/settings.php';

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $code = $con->real_escape_string($_POST['code']);
    $result = mysqli_query($con, "SELECT * FROM `files` WHERE `code` = '$code'") or die(mysqli_error($con));
    
    if (mysqli_num_rows($result) < 1)
    {
        die(json_encode("unfound"));
    }
    
    $file_url = '';
    while ($row = mysqli_fetch_array($result))
    {
        $file_url = '../../panel/app/uploads/' . $row['save_code'] . '_' . $row['filename'];
    }
                        
    header('Content-Type: application/octet-stream');
    header("Content-Transfer-Encoding: Binary"); 
    header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\""); 
    readfile($file_url);  
    
    
    function xss_clean($data)
    {
    	return strip_tags($data);
    }    
}

?>