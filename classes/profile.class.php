<?php

class Profile extends Database{

    public function update_profile($user_id, $initials, $gender, $nationality, $district, $village, $marita_status, $title, $phone, $national_id, $passport){
        if($this -> validation($initials, $gender, $nationality, $marita_status, $title) == false){
            echo "<p style='background-color: red; color:white; border-radius:10px; padding:10px;'>
            Please use letters from initials to title</p>";
       
            exit();
        }
        /*if($this -> validaPhone($phone) == false){
            echo "<p style='background-color: red; color:white; border-radius:10px; padding:10px;'>
            Phone number should be numbers greater than 10 </p>";
            exit();
        }*/
        $stmt = $this -> connect() -> prepare("SELECT * FROM user_profile WHERE user_id = ?");
        if(!$stmt -> execute(array($user_id)) ){
            $stmt = null;
            echo"error in execute statement";
            exit();
        }

        if($stmt -> rowCount() == 0){
            $stmt = $this -> connect() -> prepare("INSERT INTO user_profile (user_id, initial, gender, nationality, district, village ,marital_status, title, phone_number, national_id, passport)
             VALUES (?,?,?,?,?,?,?,?,?,?,?)"); //

             if(!$stmt-> execute(array($user_id, $initials, $gender, $nationality,$district, $village, $marita_status, $title, $phone, $national_id, $passport))){
                $stmt = null;
                echo "error in executing statement";
                exit();
             }
             echo "<p style='background-color: green; color:white; border-radius:10px; padding:10px;'>
             You have successfully added your profile </p>";
       

            exit();

        }


       $user_details = $stmt -> fetchAll(PDO::FETCH_ASSOC);
       $stmt = $this -> connect() -> prepare("UPDATE user_profile SET initial=?, gender=?, nationality=?, district=?, village=?, marital_status = ?, title = ?, phone_number = ?, national_id = ?, passport = ?  WHERE user_id = ?");
       if(!$stmt -> execute(array($initials, $gender, $nationality,$district, $village,  $marita_status, $title, $phone, $national_id, $passport,$user_details[0]['user_id']))){
            $stmt = null;
            echo 'error occurred while updating user profile';
            exit();

       }
         echo "<p style='background-color: green; color:white; border-radius:10px; padding:10px;'>
             You have successfully profile updated </p>";
    
       
    }
    public function add_profile($user_id){
        $stmt = $this -> connect() -> prepare("SELECT * FROM users WHERE user_id = ?");
        if(!$stmt -> execute(array($user_id)) ){
            $stmt = null;
            echo"error in execute statement";
            exit();
        }

        

       $user_details = $stmt -> fetchAll(PDO::FETCH_ASSOC);
       $stmt = $this -> connect() -> prepare("SELECT * FROM user_profile WHERE user_id = ?");
        if(!$stmt -> execute(array($user_details[0]['user_id'])) ){
            $stmt = null;
            echo"error in execute statement";
            exit();
        }
        if($stmt -> rowCount() == 0){
            
       echo "
            <div class='table-data'>
                <div class='order'>
					<div class='head'>
						<h3>Build your Profile</h3>
						<i class='bx bx-search' ></i>
						<i class='bx bx-filter' ></i>
					</div>
                    
                    <form action='profile.php' method='post'>
                        <table>
                            <tr>  
                                <td>First name</td>
                                <td> ".$user_details[0]['first_name']." </td>
                            </tr>
                            <tr>  
                                <td>Last name</td>
                                <td> ".$user_details[0]['last_name']."</td>
                            </tr>
                            <tr>  
                                <td>Email</td>
                                <td> ".$user_details[0]['user_email']." </td>
                            </tr>
                            <tr>  
                                <td>Username</td>
                                <td> ".$user_details[0]['username']." </td>
                            </tr>
                            <tr>  
                                <td>Initials</td>
                                <td> <input type='text' name='initial' value=''style='border:none; border-bottom: 3px solid green; padding: 5px;' required></td>
                            </tr>
                            <tr>  
                                <td>Gender</td>
                                <td> <input type='text' name='gender' value=''style='border:none; border-bottom: 3px solid green; padding: 5px;'required> </td>
                            </tr>
                            <tr>  
                                <td>Nationality</td>
                                <td> <input type='text' name='nationality' value=''style='border:none; border-bottom: 3px solid green; padding: 5px;'required> </td>
                            </tr>
                            <tr>  
                                <td>District</td>
                                <td> <input type='text' name='district' value=''style='border:none; border-bottom: 3px solid green; padding: 5px;'required> </td>
                            </tr>
                            <tr>  
                                <td>Village</td>
                                <td> <input type='text' name='village' value=''style='border:none; border-bottom: 3px solid green; padding: 5px;'required> </td>
                            </tr>
                            <tr>  
                                <td>Marital Status</td>
                                <td> <input type='text' name='marital-status' value=''style='border:none; border-bottom: 3px solid green; padding: 5px;'required></td>
                            </tr>
                            <tr>  
                                <td>Title</td>
                                <td> <input type='text' name='title' value=''style='border:none; border-bottom: 3px solid green; padding: 5px;'required> </td>
                            </tr>
                            <tr>  
                                <td>Phone number</td>
                                <td> <input type='text' name='phone' value=''style='border:none; border-bottom: 3px solid green; padding: 5px;' required> </td>
                            </tr>
                            <tr>  
                                <td>National ID</td>
                                <td> <input type='text' name='national-id' value=''style='border:none; border-bottom: 3px solid green; padding: 5px;' required> </td>
                            </tr>
                            <tr>  
                                <td>Passport</td>
                                <td> <input type='text' name='passport' value=''style='border:none; border-bottom: 3px solid green; padding: 5px;'required> </td>
                            </tr>
                            <tr>  
                                <td></td>
                                <td> <button type='submit' name='save'>Add profile</button> </td>
                            </tr>
                        </table>   
                    </form>     
                </div>
                 <div class='table-data'>
                <div class='order'>  
                <div class='head'>
                            <h3>Security</h3>
                        </div>
                        <div>
                            <form action='profile.php' method='post'>
                                <table>
                                    <tr>
                                        <td><span>Old password</span></td>
                                        <td><input type='password' name='old-password' id='old-password' requred></td>
                                    </tr>
                                    <tr>
                                        <td><span>New password</span></td>
                                        <td><input type='password' name='new-password' id='new-password' required></td>
                                    </tr>
                                    <tr>
                                        <td><span>Confirm password</span></td>
                                        <td><input type='password' name='cpassword' id='cpassword' requred></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><button type='submit' name='change' id=''>Update password</button></td>
                                    </tr>
                                </table>
                            </form>
                     
                        </div>
                       
                                                  
                    
                    
            
				</div>
			</div> ";
            exit();

        }

       
        $user_profile = $stmt -> fetchAll(PDO::FETCH_ASSOC);
       
       echo "
            <div class='table-data'>
                <div class='order'>
					<div class='head'>
						<h3>Build your Profile</h3>
						<i class='bx bx-search' ></i>
						<i class='bx bx-filter' ></i>
					</div>
                    
                    <form action='profile.php' method='post'>
                        <table>
                            <tr>  
                                <td>First name</td>
                                <td> ".$user_details[0]['first_name']." </td>
                            </tr>
                            <tr>  
                                <td>Last name</td>
                                <td> ".$user_details[0]['last_name']."</td>
                            </tr>
                            <tr>  
                                <td>Email</td>
                                <td> ".$user_details[0]['user_email']." </td>
                            </tr>
                            <tr>  
                                <td>Username</td>
                                <td> ".$user_details[0]['username']." </td>
                            </tr>
                            <tr>  
                                <td>Initials</td>
                                <td> <input type='text' name='initial' value='".$user_profile[0]['initial']."'style='border:none; border-bottom: 3px solid green; padding: 5px;'></td>
                            </tr>
                            <tr>  
                                <td>Gender</td>
                                <td> <input type='text' name='gender' value='".$user_profile[0]['gender']."'style='border:none; border-bottom: 3px solid green; padding: 5px;'> </td>
                            </tr>
                            <tr>  
                                <td>Nationality</td>
                                <td> <input type='text' name='nationality' value='".$user_profile[0]['nationality']."'style='border:none; border-bottom: 3px solid green; padding: 5px;'> </td>
                            </tr>
                            <tr>  
                                <td>District</td>
                                <td> <input type='text' name='district' value='".$user_profile[0]['district']."'style='border:none; border-bottom: 3px solid green; padding: 5px;'> </td>
                            </tr>
                            <tr>  
                                <td>Village</td>
                                <td> <input type='text' name='village' value='".$user_profile[0]['village']."'style='border:none; border-bottom: 3px solid green; padding: 5px;'> </td>
                            </tr>
                            <tr>  
                                <td>Marital Status</td>
                                <td> <input type='text' name='marital-status' value='".$user_profile[0]['marital_status']."'style='border:none; border-bottom: 3px solid green; padding: 5px;'></td>
                            </tr>
                            <tr>  
                                <td>Title</td>
                                <td> <input type='text' name='title' value='".$user_profile[0]['title']."'style='border:none; border-bottom: 3px solid green; padding: 5px;'> </td>
                            </tr>
                            <tr>  
                                <td>Phone number</td>
                                <td> <input type='text' name='phone' value='".$user_profile[0]['phone_number']."'style='border:none; border-bottom: 3px solid green; padding: 5px;'> </td>
                            </tr>
                            <tr>  
                                <td>National ID</td>
                                <td> <input type='text' name='national-id' value='".$user_profile[0]['national_id']."'style='border:none; border-bottom: 3px solid green; padding: 5px;'> </td>
                            </tr>
                            <tr>  
                                <td>Passport</td>
                                <td> <input type='text' name='passport' value='".$user_profile[0]['passport']."'style='border:none; border-bottom: 3px solid green; padding: 5px;'> </td>
                            </tr>
                            <tr>  
                                <td></td>
                                <td> <button type='submit' name='save'>Save</button> </td>
                            </tr>
                        </table> 
                     </form>      
                </div>
                
			</div> 
             <div class='table-data'>
                <div class='order'>  
                <div class='head'>
                            <h3>Security</h3>
                        </div>
                        <div>
                            <form action='profile.php' method='post'>
                                <table>
                                    <tr>
                                        <td><span>Old password</span></td>
                                        <td><input type='password' name='old-password' id='old-password' requred></td>
                                    </tr>
                                    <tr>
                                        <td><span>New password</span></td>
                                        <td><input type='password' name='new-password' id='new-password' required></td>
                                    </tr>
                                    <tr>
                                        <td><span>Confirm password</span></td>
                                        <td><input type='password' name='cpassword' id='cpassword' requred></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><button type='submit' name='change' id=''>Update password</button></td>
                                    </tr>
                                </table>
                            </form>
                     
                        </div>
                       
                                                  
                    
                    
                    ";
    
    }
    private function validation($initials, $gender, $nationality, $marita_status, $title){
        $result = false;

        if(!preg_match("/^(?=.*[a-zA-Z])/", $initials) 
        || !preg_match("/^(?=.*[a-zA-Z])/", $gender) 
        || !preg_match("/^(?=.*[a-zA-Z])/", $nationality) 
        || !preg_match("/^(?=.*[a-zA-Z])/", $marita_status) 
        || !preg_match("/^(?=.*[a-zA-Z])/", $title)){
            $result = false;
        }
        else{
            $result = true;
        }
        return $result;

    }

    // chcking if first name and last name has letters only
    private function validateName($phone, $national_id, $passport){
        $result = false;
        if(!preg_match("/^[A-Za-z](?=.*[0-9])$/", $national_id)){
            $result = false;
        }
        else{
            $result = true;
        }
        return $result;
    }
     private function validaPhone($phone){
        $result = false;
        if(!preg_match("/^(?=.*[0-9])$/", $phone) || strlen($phone) < 9){
            $result = false;
        }
        else{
            $result = true;
        }
        return $result;
     }
}
