<?php

class Users extends Database{
    private $firstName;
    private $lastName;
    private $email;
    private $password;
    private $username;
    private $cpassword;

    public function __construct(){
        $this->firstName ;
        $this->lastName ;
        $this->email ;
        $this->username ;
        $this->password ;
        $this->cpassword ;
    }

    public function get_all_users(){
         $stmt = $this -> connect()->prepare("SELECT * FROM users");

        $stmt->execute();
         
        				
        if($stmt->rowCount() == 0){
            echo "<p style='background-color: red; color:white; boarder-radius:10px; padding:10px;'>Result not found in the Database </p>";
       
            exit();
        }

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<div class='table-data'>
				<div class='order'>  						 
					<div class='head'>
						<h3>Available users</h3>
						<i class='bx bx-search'></i>
						<i class='bx bx-filter'></i>
					</div>
                    <div>
                        <table>
                            <tr>
                                <td>First Name</td>
                                <td>Last Name</td>
                                <td>Email</td>
                                <td>Username</td>
                            </tr>

                    ";
        foreach($data as $row){
            echo "
                    
                            <tr>
                                <td>".$row['first_name']."</td>
                                <td>".$row['last_name']."</td>
                                <td>".$row['user_email']."</td>
                                <td>".$row['username']."</td>
                            </tr>
                        
                   ";
        }
        echo "</table>
        </div>
         </div>
        </div>"; 
    }

     public function get_number_users(){

        $stmt = $this -> connect()->prepare("SELECT COUNT(*) FROM users");
        if(!$stmt->execute()){
            $stmt = null;
            echo "error in execution";
            exit();
        }
        if($stmt->rowCount() == 0){
            echo "0";
            exit();
        }
        $users = $stmt->fetchColumn();
    
        echo $users;
    
    }
    
     public function get_number_customers(){

        $stmt = $this -> connect()->prepare("SELECT COUNT(*) FROM customers");
        if(!$stmt->execute()){
            $stmt = null;
            echo "error in execution";
            exit();
        }
        if($stmt->rowCount() == 0){
            echo "0";
            exit();
        }
        $customers = $stmt->fetchColumn();
    
        echo $customers;
    
    }

    public function get_merchants(){
        $stmt = $this -> connect()->prepare("SELECT * FROM users INNER JOIN merchants ON users.user_id = merchants.user_id");
        if(!$stmt->execute()){
            $stmt = null;
            echo "error in executing stmt";
            exit();
        }
        if($stmt->rowCount() == 0){
            echo "0";
            exit();
        }
        $merchants = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<div class='table-data'>
				<div class='order'>  						 
					<div class='head'>
						<h3>Current Merchants</h3>
						<i class='bx bx-search'></i>
						<i class='bx bx-filter'></i>
					</div>
                    <div>
                        <table border=1>
                            <tr>
                                <td>First name</td>
                                <td>Last name</td>
                                <td>Email</td>
                                <td>User name</td>
                                <td>Business</td>
                                
                            </tr>

                    ";
        foreach($merchants as $row){
            echo "
                    
                            <tr>
                              
                                <td>".$row['first_name']."</td>
                                <td>".$row['last_name']."</td>
                                <td>".$row['user_email']."</td>
                                <td>".$row['username']."</td>
                                <td>".$row['business_name']." </td>
                                
                            </tr>
      <hr>
                            ";
                          


        }
        echo "  
        </table>
        </div>
        </div>
        </div>";

    }

     public function user_type($reason, $user){
        $stmt = $this -> connect()->prepare("INSERT INTO notifications (user_id, message_created) VALUES(?, ?)");
        

        if(!$stmt -> execute(array(1,$reason))){
            $stmt = null;
            echo "error occurred while updating notifications";
            exit();
        }
        echo "<p style='background-color: green; color:white; border-radius:10px; padding:10px;'>Wait for admin to approve your application</p>";
       
     }

    
}