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
				if(isset($_GET['program_key']) && isset($_GET['secret_key']) && isset($_GET['user_to'])) {
					$secretKey = $_GET['secret_key'];
					$authtoken = $_GET['program_key'];
					$userToBan = $_GET['user_to'];
		            $programExists = mysqli_query($con, "SELECT * FROM `programs` WHERE `authtoken` = '$authtoken' AND `variablekey` = '$secretKey'") or die(mysqli_error($con));
		            if(mysqli_num_rows($programExists) > 0)
		            {
		                // Make sure the user exists
			            $programExists = mysqli_query($con, "SELECT * FROM `users` WHERE `username` = '$userToBan' AND `programtoken` = '$authtoken'") or die(mysqli_error($con));
			            if (mysqli_num_rows($programExists) > 0)
			            {
			            	// User exists under the correct program
			            	// Update the user to ban = 1
			            	$doQuery = mysqli_query($con, "UPDATE `users` SET `banned` = '1' WHERE `username` = '$userToBan' AND `programtoken` = '$authtoken'") or die(mysqli_error($con));
			            	if($doQuery) {
			            		echo json_encode('Success');
			            	} else {
			            		echo json_encode('Failed to update user');
			            	}
			            } else {
			            	echo json_encode('No users exists under this program');
			            }
		            }
				} else {
					echo json_encode('Not all parameters were met');
				}
			break;

			// Unban API
			case 'unban':
				header('Content-Type: application/json');
				if(isset($_GET['program_key']) && isset($_GET['secret_key']) && isset($_GET['user_to'])) {
					$secretKey = $_GET['secret_key'];
					$authtoken = $_GET['program_key'];
					$userToBan = $_GET['user_to'];
		            $programExists = mysqli_query($con, "SELECT * FROM `programs` WHERE `authtoken` = '$authtoken' AND `variablekey` = '$secretKey'") or die(mysqli_error($con));
		            if(mysqli_num_rows($programExists) > 0)
		            {
		                // Make sure the user exists
			            $programExists = mysqli_query($con, "SELECT * FROM `users` WHERE `username` = '$userToBan' AND `programtoken` = '$authtoken'") or die(mysqli_error($con));
			            if (mysqli_num_rows($programExists) > 0)
			            {
			            	// User exists under the correct program
			            	// Update the user to ban = 1
			            	$doQuery = mysqli_query($con, "UPDATE `users` SET `banned` = '0' WHERE `username` = '$userToBan' AND `programtoken` = '$authtoken'") or die(mysqli_error($con));
			            	if($doQuery) {
			            		echo json_encode('Success');
			            	} else {
			            		echo json_encode('Failed to update user');
			            	}
			            } else {
			            	echo json_encode('No users exists under this program');
			            }
		            }
				} else {
					echo json_encode('Not all parameters were met');
				}
			break;

			// Get User Info
			case 'getuserinfo':
				header('Content-Type: application/json');
				if(isset($_GET['program_key']) && isset($_GET['secret_key']) && isset($_GET['user_to'])) {
					$secretKey = $_GET['secret_key'];
					$authtoken = $_GET['program_key'];
					$userToBan = $_GET['user_to'];
		            $programExists = mysqli_query($con, "SELECT * FROM `programs` WHERE `authtoken` = '$authtoken' AND `variablekey` = '$secretKey'") or die(mysqli_error($con));
		            if(mysqli_num_rows($programExists) > 0)
		            {
		                // Make sure the user exists
			            $programExists = mysqli_query($con, "SELECT * FROM `users` WHERE `username` = '$userToBan' AND `programtoken` = '$authtoken'") or die(mysqli_error($con));
			            if (mysqli_num_rows($programExists) > 0)
			            {
			            	// User exists under the correct program
			            	// Get user details
	                        while ($row = mysqli_fetch_array($programExists))
	                        {
	                            $usersName = $row['username']; 
	                            $level = $row['level']; 
	                            $email = $row['email']; 
	                            $expires = $row['expires']; 
	                            $hwid = $row['hwid']; 
	                            $prgramKey = $row['programtoken']; 
	                            $ip = $row['ip']; 
	                            $banned = ($row['username'] == '1' ? $isBanned = 'Yes' : $isBanned = 'No');
	                        }

							$info = array(
							    "Username" => "$usersName",
							    "Email" => "$email",
							    "Expires" => "$expires",
							    "HWID" => "$hwid",
							    "Program Key" => "$prgramKey",
							    "IP Address" => "$ip",
							    "Banned" => "$isBanned",
							    "Level" => $level
							);

							echo json_encode($info);
			            } else {
			            	echo json_encode('No users exists under this program');
			            }
		            }
				} else {
					echo json_encode('Not all parameters were met');
				}
			break;

			// Get HWID Info
			case 'gethwidinfo':
				header('Content-Type: application/json');
				if(isset($_GET['program_key']) && isset($_GET['secret_key']) && isset($_GET['user_to'])) {
					$secretKey = $_GET['secret_key'];
					$authtoken = $_GET['program_key'];
					$userToBan = $_GET['user_to'];
		            $programExists = mysqli_query($con, "SELECT * FROM `programs` WHERE `authtoken` = '$authtoken' AND `variablekey` = '$secretKey'") or die(mysqli_error($con));
		            if(mysqli_num_rows($programExists) > 0)
		            {
		                // Make sure the user exists
			            $programExists = mysqli_query($con, "SELECT * FROM `users` WHERE `username` = '$userToBan' AND `programtoken` = '$authtoken'") or die(mysqli_error($con));
			            if (mysqli_num_rows($programExists) > 0)
			            {
			            	// User exists under the correct program
			            	// Get user details
	                        while ($row = mysqli_fetch_array($programExists))
	                        { 
	                            $hwid = $row['hwid']; 
	                        }

							$info = array(
							    "HWID" => "$hwid"
							);

							echo json_encode($info);
			            } else {
			            	echo json_encode('No users exists under this program');
			            }
		            }
				} else {
					echo json_encode('Not all parameters were met');
				}
			break;

			// Reset HWID
			case 'resethwid':
				header('Content-Type: application/json');
				if(isset($_GET['program_key']) && isset($_GET['secret_key']) && isset($_GET['user_to'])) {
					$secretKey = $_GET['secret_key'];
					$authtoken = $_GET['program_key'];
					$userToBan = $_GET['user_to'];
		            $programExists = mysqli_query($con, "SELECT * FROM `programs` WHERE `authtoken` = '$authtoken' AND `variablekey` = '$secretKey'") or die(mysqli_error($con));
		            if(mysqli_num_rows($programExists) > 0)
		            {
		                // Make sure the user exists
			            $programExists = mysqli_query($con, "SELECT * FROM `users` WHERE `username` = '$userToBan' AND `programtoken` = '$authtoken'") or die(mysqli_error($con));
			            if (mysqli_num_rows($programExists) > 0)
			            {
			            	// User exists under the correct program
			            	$doQuery = mysqli_query($con, "UPDATE `users` SET `hwid` = 'RESET' WHERE `username` = '$userToBan' AND `programtoken` = '$authtoken'") or die(mysqli_error($con));
			            	if($doQuery) {
			            		echo json_encode("Success");
			            	} else {
			            		echo json_encode('Failed to update user');
			            	}
			            } else {
			            	echo json_encode('No users exists under this program');
			            }
		            }
				} else {
					echo json_encode('Not all parameters were met');
				}
			break;

			// Change Password
			case 'changepass':
				header('Content-Type: application/json');
				if(isset($_GET['program_key']) && isset($_GET['secret_key']) && isset($_GET['user_to']) && isset($_GET['new_pass'])) {
					$secretKey = $_GET['secret_key'];
					$authtoken = $_GET['program_key'];
					$userToBan = $_GET['user_to'];
					$newPass = $_GET['new_pass'];
		            $programExists = mysqli_query($con, "SELECT * FROM `programs` WHERE `authtoken` = '$authtoken' AND `variablekey` = '$secretKey'") or die(mysqli_error($con));
		            if(mysqli_num_rows($programExists) > 0)
		            {
		                // Make sure the user exists
			            $programExists = mysqli_query($con, "SELECT * FROM `users` WHERE `username` = '$userToBan' AND `programtoken` = '$authtoken'") or die(mysqli_error($con));
			            if (mysqli_num_rows($programExists) > 0)
			            {
			            	// User exists under the correct program
			            	$pass_encrypted = password_hash($newPass, PASSWORD_BCRYPT);
			            	$doQuery = mysqli_query($con, "UPDATE `users` SET `password` = '$pass_encrypted' WHERE `username` = '$userToBan' AND `programtoken` = '$authtoken'") or die(mysqli_error($con));
			            	if($doQuery) {
			            		echo json_encode("Success");
			            	} else {
			            		echo json_encode('Failed to update user');
			            	}
			            } else {
			            	echo json_encode('No users exists under this program');
			            }
		            }
				} else {
					echo json_encode('Not all parameters were met');
				}
			break;

			// Generate Lisences
			case 'generatelicenses':
				header('Content-Type: application/json');
				if(isset($_GET['program_key']) && isset($_GET['secret_key']) && isset($_GET['amount']) && isset($_GET['days']) && isset($_GET['level'])) {
					$secretKey = $_GET['secret_key'];
					$authtoken = $_GET['program_key'];
					$amount = $_GET['amount'];
					$days = $_GET['days'];
					$level = $_GET['level'];
					if(isset($_GET['prefix'])) {
						$prefix = $_GET['prefix'];
					} else {
						$prefix = 'BLAuth';
					}
		            $programExists = mysqli_query($con, "SELECT * FROM `programs` WHERE `authtoken` = '$authtoken' AND `variablekey` = '$secretKey'") or die(mysqli_error($con));
		            if(mysqli_num_rows($programExists) > 0)
		            {
		            	// Program exists

	                    while ($row = mysqli_fetch_array($programExists))
	                    {
	                        $bruhtoken = $row['authtoken'];
	                        $username = $row['owner'];
	                    }

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

			                $grabinfo = mysqli_query($con, "SELECT * FROM `owners` WHERE `username` = '$username'") or die(mysqli_error($con));
			                while ($row = mysqli_fetch_array($grabinfo))
			                {
			                    $subscription = $row['premium']; 
			                }

			                $epicc21 = mysqli_query($con, "SELECT * FROM `users` WHERE `programtoken` = '$bruhtoken'") or die(mysqli_error($con));
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
			                        if (mysqli_num_rows($epicc2) >= 100 || $amount + mysqli_num_rows($epicc2) > 100) 
			                        {     
			                            $gaycheck = 0;
			                            echo json_encode("You cannot generate more than 100 license! Purchase premium to remove this limit.");
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

			                    if ($subscription == "0" && $prefix != "BLAuth")
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
		                                    VALUES ('$prefix-$tokennn', '$username', '$authtoken', '$days', 0, '', '$level', '$bruhtoken')") or die(mysqli_error($con));
		                                }
		                                else
		                                {
		                                    $insertlol = mysqli_query($con, "INSERT INTO `tokens` (token, owner, program, days, used, used_by, level, programtoken) 
		                                    VALUES ('$tokennn', '$username', '$authtoken', '$days', 0, '', '$level', '$bruhtoken')") or die(mysqli_error($con));
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

		                } else {
		                	echo json_encode("Invalid amount to generate!");
		                }
		            }
				} else {
					echo json_encode('Not all parameters were met');
				}
			break;

			// Return Total Number Of Lisences
			case 'totallicenses':
				header('Content-Type: application/json');
				if(isset($_GET['program_key']) && isset($_GET['secret_key'])) {
					$secretKey = $_GET['secret_key'];
					$authtoken = $_GET['program_key'];
		            $programExists = mysqli_query($con, "SELECT * FROM `programs` WHERE `authtoken` = '$authtoken' AND `variablekey` = '$secretKey'") or die(mysqli_error($con));
		            if(mysqli_num_rows($programExists) > 0)
		            {
						// Program exists with correct validations
						// Now check to see how many lisences there are under this program key
			            $tokenCount = mysqli_query($con, "SELECT * FROM `tokens` WHERE `programtoken` = '$authtoken'") or die(mysqli_error($con));
			            $returnAmount = mysqli_num_rows($tokenCount);        
			            echo json_encode("$returnAmount");    	
		            }
				} else {
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