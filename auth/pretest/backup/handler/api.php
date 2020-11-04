<?php 
include '../includes/settings.php';

	$resultTokens = array();

	function GenerateToken() {
	    for($i = 0; $i < 1; $i++) {
	      $randomString = "";
	      $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	      $charactersLength = strlen($characters);
	      for ($i = 0; $i < 10; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	      }
	      return $randomString;
	    }
	} 

	// Make sure all parameters are met
	if(isset($_GET['action'])) {
		$action = $_GET['action'];
		switch ($action) {

			// Ban API
			case 'ban':
				header('Content-Type: application/json');
				if(isset($_GET['program_key']) && isset($_GET['api_key']) && isset($_GET['user_to'])) {
				    
				    $api_key = $_GET['api_key'];
					$authtoken = $_GET['program_key'];
					$userToBan = $_GET['user_to'];
					
					
					$api_exist = mysqli_query($con, "SELECT * FROM `owners` WHERE `api_key` = '$api_key'") or die(mysqli_error($con));
					
					if (mysqli_num_rows($api_exist) > 0)
					{
					    while ($row = mysqli_fetch_array($api_exist))
					    {
					        $user_api_key =  strtolower($row['username']);
					    }
					    
					    // make sure the apikey is of the user
					    $program_exist = mysqli_query($con, "SELECT * FROM `programs` WHERE `authtoken` = '$authtoken'") or die(mysqli_error($con));
					    if (mysqli_num_rows($program_exist) > 0)
					    {
					        while ($row = mysqli_fetch_array($program_exist))
					        {
					            $owner_program =  strtolower($row['owner']);
					        }
					        
					        if ($owner_program != $user_api_key)
					        {
					            echo json_encode('The entered API key does not belong to the application owner\'s account.');
					        }
					        else
					        {
					            $user_exist = mysqli_query($con, "SELECT * FROM `users` WHERE `username` = '$userToBan' AND `programtoken` = '$authtoken'") or die(mysqli_error($con));
					            
					            if (mysqli_num_rows($user_exist) > 0)
					            {
					                while ($row = mysqli_fetch_array($user_exist))
					                {
					                    $confirm_banned = $row['banned'];
					                }
					                
					                if ($confirm_banned == 1)
					                {
					                    echo json_encode('User already banned!');
					                }
					                else
					                {
        					            $banning_user = mysqli_query($con, "UPDATE `users` SET `banned` = '1' WHERE `username` = '$userToBan' AND `programtoken` = '$authtoken'") or die(mysqli_error($con));
        					            if ($banning_user)
        					            {
        					                echo json_encode('Successfully banned user!');
        					            }
        					            else
        					            {
        					                echo json_encode('Failed to ban user!');
        					            }						                    
					                }
					            }
					            else
					            {
			            	        echo json_encode('No users exists under this program');
					            }
					        }
					    }
					    else
					    {
					        echo json_encode('Program not found!');
					    }
					}
					else
					{
					    echo json_encode('The entered api key does not exist in our database!');
					}
				} 
				else 
				{
					echo json_encode('Not all parameters were met');
				}
			    break;






			// Unban API
			case 'unban':
				header('Content-Type: application/json');
				if(isset($_GET['program_key']) && isset($_GET['api_key']) && isset($_GET['user_to'])) {
				    
				    $api_key = $_GET['api_key'];
					$authtoken = $_GET['program_key'];
					$userToUnBan = $_GET['user_to'];
					
					$api_exist = mysqli_query($con, "SELECT * FROM `owners` WHERE `api_key` = '$api_key'") or die(mysqli_error($con));
					
					if (mysqli_num_rows($api_exist) > 0)
					{
					    while ($row = mysqli_fetch_array($api_exist))
					    {
					        $user_api_key =  strtolower($row['username']);
					    }
					    
					    $program_exist = mysqli_query($con, "SELECT * FROM `programs` WHERE `authtoken` = '$authtoken'") or die(mysqli_error($con));
					    
					    if (mysqli_num_rows($program_exist) > 0)
					    {
					        while ($row = mysqli_fetch_array($program_exist))
					        {
					            $owner_program =  strtolower($row['owner']);
					        }
					        
					        if ($owner_program != $user_api_key)
					        {
					            echo json_encode('The entered API key does not belong to the application owner\'s account.');
					        }
					        else
					        {
					            $user_exist = mysqli_query($con, "SELECT * FROM `users` WHERE `username` = '$userToUnBan' AND `programtoken` = '$authtoken'") or die(mysqli_error($con));
					            
					            if (mysqli_num_rows($user_exist) > 0)
					            {
					                while ($row = mysqli_fetch_array($user_exist))
					                {
					                    $check_banned = $row['banned'];
					                }
					            }
					            else
					            {
					                echo json_encode('No users exists under this program');
					            }


                                if ($check_banned == 0)
                                {
                                    echo json_encode('User already unbanned!');
                                }
                                else
                                {
    					            $unban_query = mysqli_query($con, "UPDATE `users` SET `banned` = '0' WHERE `username` = '$userToUnBan' AND `programtoken` = '$authtoken'") or die(mysqli_error($con));
    					            
    					            if ($unban_query)
    					            {
    					                echo json_encode('Successfully unbanned user!');
    					            }             
    					            else
    					            {
    					                echo json_encode('Failed to unban user!');
    					            }
                                }
					        }
					    }
					    else
					    {
					        echo json_encode('Program not found!');
					    }
					}
					else
					{
					    echo json_encode('The entered api key does not exist in our database!');
					}
				} 
				else 
				{
					echo json_encode('Not all parameters were met');
				}
			    break;





			// Get User Info
			case 'getuserinfo':
				header('Content-Type: application/json');
				if(isset($_GET['program_key']) && isset($_GET['api_key']) && isset($_GET['user_to'])) {
				    
				    $api_key = $_GET['api_key'];
					$authtoken = $_GET['program_key'];
					$user_To = $_GET['user_to'];
					
					$api_exist = mysqli_query($con, "SELECT * FROM `owners` WHERE `api_key` = '$api_key'") or die(mysqli_error($con));
					
					if (mysqli_num_rows($api_exist) > 0)
                    {
					    while ($row = mysqli_fetch_array($api_exist))
					    {
					        $user_api_key = strtolower($row['username']);
					    }
					   
					    $program_exist = mysqli_query($con, "SELECT * FROM `programs` WHERE `authtoken` = '$authtoken'") or die(mysqli_error($con));
					    
					    if (mysqli_num_rows($program_exist) > 0)
					    {
					        while ($row = mysqli_fetch_array($program_exist))
					        {
					            $owner_app = strtolower($row['owner']);
					        }
					        
					        if ($owner_app != $user_api_key)
					        {
					            echo json_encode('The entered API key does not belong to the application owner\'s account.');
					        }
					        else
					        {
					            $user_exist = mysqli_query($con, "SELECT * FROM `users` WHERE `username` = '$user_To' AND `programtoken` = '$authtoken'") or die(mysqli_error($con));
					            if (mysqli_num_rows($user_exist) > 0)
					            {
					                while ($row = mysqli_fetch_array($user_exist))
					                {
        	                            $usersName = $row['username']; 
        	                            $level = $row['level']; 
        	                            $email = $row['email']; 
        	                            $expires = $row['expires']; 
        	                            $hwid = ($row['hwid'] == "RESET" ? "HWID Undefined" : $row['hwid']); 
        	                            $ip = $row['ip']; 
        	                            $banned = ($row['banned'] == '1' ? $isBanned = 'Yes' : $isBanned = 'No');					                    
					                }
					                
    					            $info = array(
    					                "Username" => "$usersName",
        							    "License" => "$email",
        							    "Expires" => "$expires",
        							    "HWID" => "$hwid",
        							    "IP" => "$ip",
        							    "Banned" => "$isBanned",
        							    "Level" => $level
        							);
        							
        							echo json_encode($info);
					            }
					            else
					            {
					                echo json_encode('No users exists under this program');
					            }
					        }
					    }
					    else
					    {
					        echo json_encode('Program not found!');
					    }
                    }
                    else
                    {
                        echo json_encode('The entered api key does not exist in our database!');
                    }
				} 
				else 
				{
					echo json_encode('Not all parameters were met');
				}
			    break;





			// Get HWID Info
			case 'gethwidinfo':
				header('Content-Type: application/json');
				if(isset($_GET['program_key']) && isset($_GET['api_key']) && isset($_GET['user_to'])) {
				    
				    
					$api_key = $_GET['api_key'];
					$authtoken = $_GET['program_key'];
					$user_To = $_GET['user_to'];
					
					$api_exist = mysqli_query($con, "SELECT * FROM `owners` WHERE `api_key` = '$api_key'") or die(mysqli_error($con));
					
					if (mysqli_num_rows($api_exist) > 0)
					{
					    while ($row = mysqli_fetch_array($api_exist))
					    {
					        $user_api_key =  strtolower($row['username']);
					    }
					    
					    $program_exist = mysqli_query($con, "SELECT * FROM `programs` WHERE `authtoken` = '$authtoken'") or die(mysqli_error($con));
					    if (mysqli_num_rows($program_exist) > 0)
					    {
					        while ($row = mysqli_fetch_array($program_exist))
					        {
					            $owner_program =  strtolower($row['owner']);
					        }
					        
					        if ($owner_program != $user_api_key)
					        {
					            echo json_encode('The entered API key does not belong to the application owner\'s account.');
					        }
					        else
					        {
					            $user_exist = mysqli_query($con, "SELECT * FROM `users` WHERE `username` = '$user_To' AND `programtoken` = '$authtoken'") or die(mysqli_error($con));
					            
					            if (mysqli_num_rows($user_exist) > 0)
					            {
					                while ($row = mysqli_fetch_array($user_exist))
					                {
					                    $hwid = ($row['hwid'] == "RESET" ? "HWID Undefined" : $row['hwid']);
					                }
					                
					                $info = array(
					                        "HWID" => "$hwid"
					                    );
					                    
					                echo json_encode($info);
					            }
					            else
					            {
					                echo json_encode('No users exists under this program');
					            }
					        }
					        
					    }
					    else
					    {
					        echo json_encode('Program not found!');
					    }
					    
					}
					else
					{
					    echo json_encode('The entered api key does not exist in our database!');
					}
				} else {
					echo json_encode('Not all parameters were met');
				}
			    break;





			// Reset HWID
			case 'resethwid':
				header('Content-Type: application/json');
				if(isset($_GET['program_key']) && isset($_GET['api_key']) && isset($_GET['user_to'])) {
				    
				    
					$api_key = $_GET['api_key'];
					$authtoken = $_GET['program_key'];
					$user_To = $_GET['user_to'];
					
					$api_exist = mysqli_query($con, "SELECT * FROM `owners` WHERE `api_key` = '$api_key'") or die(mysqli_error($con));
					
					if (mysqli_num_rows($api_exist) > 0)
					{
					    while ($row = mysqli_fetch_array($api_exist))
					    {
					        $user_api_key =  strtolower($row['username']);
					    }
					    
					    $program_exist = mysqli_query($con, "SELECT * FROM `programs` WHERE `authtoken` = '$authtoken'") or die(mysqli_error($con));
					    if (mysqli_num_rows($program_exist) > 0)
					    {
					        while ($row = mysqli_fetch_array($program_exist))
					        {
					            $owner_program =  strtolower($row['owner']);
					        }
					        
					        if ($owner_program != $user_api_key)
					        {
					            echo json_encode('The entered API key does not belong to the application owner\'s account.');
					        }
					        else
					        {
					            $user_exist = mysqli_query($con, "SELECT * FROM `users` WHERE `username` = '$user_To' AND `programtoken` = '$authtoken'") or die(mysqli_error($con));
					            
					            if (mysqli_num_rows($user_exist) > 0)
					            {
        			            	$reset_query = mysqli_query($con, "UPDATE `users` SET `hwid` = 'RESET' WHERE `username` = '$user_To' AND `programtoken` = '$authtoken'") or die(mysqli_error($con));
        			            	
        			            	if ($reset_query)
        			            	{
        			            	    echo json_encode('Successfully reseted HWID!');
        			            	}
        			            	else
        			            	{
			            		        echo json_encode('Failed to update user');
        			            	}
					            }
					            else
					            {
					                echo json_encode('No users exists under this program');
					            }
					        }
					        
					    }
					    else
					    {
					        echo json_encode('Program not found!');
					    }
					    
					}
					else
					{
					    echo json_encode('The entered api key does not exist in our database!');
					}
				} 
				else 
				{
					echo json_encode('Not all parameters were met');
				}		            
			    break;




			// Change Password
			case 'changepass':
				header('Content-Type: application/json');
					
					if(isset($_GET['program_key']) && isset($_GET['api_key']) && isset($_GET['user_to']) && isset($_GET['new_pass'])) {
				    
				    $api_key = $_GET['api_key'];
					$authtoken = $_GET['program_key'];
					$user_To = $_GET['user_to'];
					$newPass = $_GET['new_pass'];
					
					
					
					$api_exist = mysqli_query($con, "SELECT * FROM `owners` WHERE `api_key` = '$api_key'") or die(mysqli_error($con));
					
					if (mysqli_num_rows($api_exist) > 0)
					{
					    while ($row = mysqli_fetch_array($api_exist))
					    {
					        $user_api_key =  strtolower($row['username']);
					    }
					    
					    $program_exist = mysqli_query($con, "SELECT * FROM `programs` WHERE `authtoken` = '$authtoken'") or die(mysqli_error($con));
					    
					    if (mysqli_num_rows($program_exist) > 0)
					    {
					        while ($row = mysqli_fetch_array($program_exist))
					        {
					            $owner_program =  strtolower($row['owner']);
					        }
					        
					        if ($owner_program != $user_api_key)
					        {
					            echo json_encode('The entered API key does not belong to the application owner\'s account.');
					        }
					        else
					        {
					            $user_exist = mysqli_query($con, "SELECT * FROM `users` WHERE `username` = '$user_To' AND `programtoken` = '$authtoken'") or die(mysqli_error($con));
					            
					            if (mysqli_num_rows($user_exist) > 0)
					            {
    			            	    $pass_encrypted = password_hash($newPass, PASSWORD_BCRYPT);
    			            	    $changepass_query = mysqli_query($con, "UPDATE `users` SET `password` = '$pass_encrypted' WHERE `username` = '$user_To' AND `programtoken` = '$authtoken'") or die(mysqli_error($con));
    			            	    
    			            	    if ($changepass_query)
    			            	    {
    			            	        echo json_encode('Password successfully changed!');
    			            	    }
    			            	    else
    			            	    {
    			            	        echo json_encode('Failed to update user');
    			            	    }
					            }
					            else
					            {
					                echo json_encode('No users exists under this program');
					            }
					        }
					    }
					    else
					    {
					        echo json_encode('Program not found!');
					    }
					}
					else
					{
					    echo json_encode('The entered api key does not exist in our database!');
					}
				} 
				else 
				{
					echo json_encode('Not all parameters were met');
				}
			break;




			// Generate Lisences
			case 'generatelicenses':
				header('Content-Type: application/json');
				if(isset($_GET['program_key']) && isset($_GET['api_key']) && isset($_GET['amount']) && isset($_GET['days']) && isset($_GET['level'])) {
					$api_key = $_GET['api_key'];
					$authtoken = $_GET['program_key'];
					$amount = $_GET['amount'];
					$days = $_GET['days'];
					$level = $_GET['level'];
					if(isset($_GET['prefix'])) {
						$prefix = $_GET['prefix'];
					} else {
						$prefix = 'AkizaIO';
					}
					
					$api_exist = mysqli_query($con, "SELECT * FROM `owners` WHERE `api_key` = '$api_key'") or die(mysqli_error($con));
					
					if (mysqli_num_rows($api_exist) > 0)
					{
                        while ($row = mysqli_fetch_array($api_exist))
                        {
                            $user_api_key =  strtolower($row['username']);
                        }					    
                        
                        $program_exist = mysqli_query($con, "SELECT * FROM `programs` WHERE `authtoken` = '$authtoken'") or die(mysqli_error($con));
                        if (mysqli_num_rows($program_exist) > 0)
                        {
                            while ($row = mysqli_fetch_array($program_exist))
                            {
                                $owner_program =  strtolower($row['owner']);
                                $id = $row['id'];
                            }
                            
                            if ($owner_program != $user_api_key)
                            {
                                echo json_encode('The entered API key does not belong to the application owner\'s account.');
                            }
                            else
                            {
                                
                                
        		                if (strlen($prefix) > 20)
        		                {
        		                    echo json_encode("Your license prefix must be 20 characters or less!");
        		                    die();
        		                }
        		                else if (count(explode(' ', $prefix)) > 1) 
        		                {
        		                    echo json_encode("Your license prefix must not contain any spaces!");
        		                    die();
        		                }
        
        		                if ($amount > 0 && $amount <= 50)
        		                {
        
        			                $grabinfo = mysqli_query($con, "SELECT * FROM `owners` WHERE `username` = '$owner_program'") or die(mysqli_error($con));
        			                while ($row = mysqli_fetch_array($grabinfo))
        			                {
        			                    $subscription = $row['premium']; 
        			                }
        
        			                $epicc21 = mysqli_query($con, "SELECT * FROM `users` WHERE `programtoken` = '$authtoken'") or die(mysqli_error($con));
        			                $boolcheck1 = 1;
        			                if ($subscription == "0") 
        			                {
        			                    if (mysqli_num_rows($epicc21) > 50) 
        			                    {     
        			                        $boolcheck1 = 0;
        			                        echo json_encode("You cannot have more than 50 users! Purchase premium to remove this limit.");
        			                        die();
        			                    }
        			                }
        
        			                if ($subscription == "1") 
        			                {
        			                    if (mysqli_num_rows($epicc21) > 5000) 
        			                    {     
        			                        $boolcheck1 = 0;
        			                        echo json_encode("You cannot have more than 5000 users!");
        			                        die();
        			                    }   
        			                }
        
        			                if ($boolcheck1 == 1) 
        			                {
        			                    $type = $days;
        
        			                    if ($level > 10 || $level <= 0)
        			                    {
        			                    	echo json_encode("Invalid license level!");
        			                        die();
        			                    }
        
        			                    $gaycheck = 1;
        			                    $epicc2 = mysqli_query($con, "SELECT * FROM `tokens` WHERE `program` = '$id'") or die(mysqli_error($con));
        			                    if ($subscription == "0") 
        			                    {
        			                        if (mysqli_num_rows($epicc2) >= 75 || $amount + mysqli_num_rows($epicc2) > 75) 
        			                        {     
        			                            $gaycheck = 0;
        			                            echo json_encode("You cannot generate more than 75 license! Purchase premium to remove this limit.");
        			                            die();
        			                        }
        			                    }
        
        			                    if ($subscription == "1") 
        			                    {
        			                        if (mysqli_num_rows($epicc2) >= 10000) 
        			                        {     
        			                            $gaycheck = 0;
        			                            json_encode("You cannot generate more than 10,000 license!");
        			                            die();
        			                        }
        			                    }
        
        			                    if ($subscription == "0" && $prefix != "AkizaIO")
        			                    {
        			                    	echo json_encode("You can't change the prefix!, buy the premium subscription to have this feature");
        			                        die();
        			                    }
        
        			                    if ($gaycheck == 1) 
        			                    {
        			    
        		                            for ($i = 0; $i < $amount; $i++)
        		                            {
        		                                $tokennn = GenerateToken();
        		                                $resultTokens[] = $tokennn;
        		                            
        		                                if (!empty($prefix)) 
        		                                {
        		                                    $insertlol = mysqli_query($con, "INSERT INTO `tokens` (token, owner, program, days, used, used_by, level, programtoken) 
        		                                    VALUES ('$prefix-$tokennn', '$owner_program', '$id', '$days', 0, '', '$level', '$authtoken')") or die(mysqli_error($con));
        		                                }
        		                                else
        		                                {
        		                                    $insertlol = mysqli_query($con, "INSERT INTO `tokens` (token, owner, program, days, used, used_by, level, programtoken) 
        		                                    VALUES ('$tokennn', '$owner_program', '$id', '$days', 0, '', '$level', '$authtoken')") or die(mysqli_error($con));
        		                                }
        		                            }
        	                        
        			                        if($insertlol)
        			                        {
        			                        	echo json_encode($resultTokens);
        			                        }
        			                        else
        			                        {
        			                        	echo json_encode("An error has occurred!");
        			                        }
        
        					            }                                
        			                }
        		                }
        		                else
        		                {
        		                    echo json_encode('Invalid amount to generate!');
        		                }
                                
                            }
                        }
                        else
                        {
                            echo json_encode('Program not found!');
                        }
                          
					}
					else
					{
					    echo json_encode('The entered api key does not exist in our database!');
					}
					
					
					
					
			
				} else {
					echo json_encode('Not all parameters were met');
				}
			break;


			// Return Total Number Of Lisences
			case 'totallicenses':
				header('Content-Type: application/json');
					if(isset($_GET['program_key']) && isset($_GET['api_key'])) {
				    
				    
					$api_key = $_GET['api_key'];
					$authtoken = $_GET['program_key'];

					$api_exist = mysqli_query($con, "SELECT * FROM `owners` WHERE `api_key` = '$api_key'") or die(mysqli_error($con));
					
					if (mysqli_num_rows($api_exist) > 0)
					{
					    while ($row = mysqli_fetch_array($api_exist))
					    {
					        $user_api_key =  strtolower($row['username']);
					    }
					    
					    $program_exist = mysqli_query($con, "SELECT * FROM `programs` WHERE `authtoken` = '$authtoken'") or die(mysqli_error($con));
					    if (mysqli_num_rows($program_exist) > 0)
					    {
					        while ($row = mysqli_fetch_array($program_exist))
					        {
					            $owner_program =  strtolower($row['owner']);
					        }
					        
					        if ($owner_program != $user_api_key)
					        {
					            echo json_encode('The entered API key does not belong to the application owner\'s account.');
					        }
					        else
					        {
        			            $tokenCount = mysqli_query($con, "SELECT * FROM `tokens` WHERE `programtoken` = '$authtoken'") or die(mysqli_error($con));
        			            $returnAmount = mysqli_num_rows($tokenCount);        
        			            echo json_encode("$returnAmount");    	
					        }
					        
					    }
					    else
					    {
					        echo json_encode('Program not found!');
					    }
					    
					}
					else
					{
					    echo json_encode('The entered api key does not exist in our database!');
					}
				} 
				else 
				{
					echo json_encode('Not all parameters were met');
				}		 
			    break;
			
			
			case 'totalusers':
				header('Content-Type: application/json');
					if(isset($_GET['program_key']) && isset($_GET['api_key'])) {
				    
				    
					$api_key = $_GET['api_key'];
					$authtoken = $_GET['program_key'];

					$api_exist = mysqli_query($con, "SELECT * FROM `owners` WHERE `api_key` = '$api_key'") or die(mysqli_error($con));
					
					if (mysqli_num_rows($api_exist) > 0)
					{
					    while ($row = mysqli_fetch_array($api_exist))
					    {
					        $user_api_key =  strtolower($row['username']);
					    }
					    
					    $program_exist = mysqli_query($con, "SELECT * FROM `programs` WHERE `authtoken` = '$authtoken'") or die(mysqli_error($con));
					    if (mysqli_num_rows($program_exist) > 0)
					    {
					        while ($row = mysqli_fetch_array($program_exist))
					        {
					            $owner_program =  strtolower($row['owner']);
					        }
					        
					        if ($owner_program != $user_api_key)
					        {
					            echo json_encode('The entered API key does not belong to the application owner\'s account.');
					        }
					        else
					        {
        			            $tokenCount = mysqli_query($con, "SELECT * FROM `users` WHERE `programtoken` = '$authtoken'") or die(mysqli_error($con));
        			            $returnAmount = mysqli_num_rows($tokenCount);        
        			            echo json_encode("$returnAmount");    	
					        }
					        
					    }
					    else
					    {
					        echo json_encode('Program not found!');
					    }
					    
					}
					else
					{
					    echo json_encode('The entered api key does not exist in our database!');
					}
				} 
				else 
				{
					echo json_encode('Not all parameters were met');
				}		 
			    break;			
			
			
			
    			default:
    				echo json_encode('Invalid Action');
    			    break;

		}

	} else {
		echo json_encode('Parameters required');
	}
?>