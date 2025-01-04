<?php

class Roles extends Database{

    public function assign_roles($user_id,$role_id, $role_name, $username) {
        $stmt = $this -> connect() -> prepare("SELECT * FROM users WHERE user_id = ? OR username = ?");
        if(!$stmt -> execute(array($user_id, $username))) {
            $stmt = null;
            echo "Error executing statement";
            exit();
        }

        if($stmt -> rowCount() == 0) {
            echo "<p style='background-color: red; color:white; boarder-radius:10px; padding:10px;'>Username not found </p>";
       
            exit();
        }

        $users = $stmt ->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $this -> connect() -> prepare("SELECT * FROM roles WHERE role_id = ? OR role_name = ?");
        if(!$stmt -> execute(array($role_id, $role_name))) {
            $stmt = null;
            echo "Error executing statement";
            exit();
        }

        if($stmt -> rowCount() == 0) {
            echo "<p style='background-color: red; color:white; boarder-radius:10px; padding:10px;'>Role name not found </p>";
       
            exit();
        }

        $roles = $stmt -> fetchAll(PDO::FETCH_ASSOC);

        $stmt = $this -> connect() -> prepare("INSERT INTO user_roles (user_id, role_id) VALUES (?,?)");

        if(!$stmt -> execute(array($users[0]['user_id'], $roles[0]['role_id']))) {
            $stmt = null;
            echo "Error executing statement";
            exit();
        }
        echo "<p style='background-color: green; color:white; boarder-radius:10px; padding:10px;'>Role successfully assigned </p>";
       

    }

    //this function is used to update role
    public function update_roles($user_id,$role_id, $role_name, $username) {
        $stmt = $this -> connect() -> prepare("SELECT * FROM users WHERE user_id = ? OR username = ?");

        if(!$stmt -> execute(array($user_id, $username))) {
            $stmt = null;
            echo "Error executing statement";
            exit();
        }

        if($stmt -> rowCount() == 0) {
            echo "<p style='background-color: red; color:white; boarder-radius:10px; padding:10px;'>Username not found </p>";
       
            exit();
        }

        $users = $stmt ->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $this -> connect() -> prepare("SELECT * FROM roles WHERE role_id = ? OR role_name = ?");
        if(!$stmt -> execute(array($role_id, $role_name))) {
            $stmt = null;
            echo "Error executing statement";
            exit();
        }

        if($stmt -> rowCount() == 0) {
            echo "<p style='background-color: red; color:white; boarder-radius:10px; padding:10px;'>Role name not found </p>";
       
            exit();
        }

        $roles = $stmt -> fetchAll(PDO::FETCH_ASSOC);

        $stmt = $this -> connect() -> prepare("SELECT * FROM user_roles WHERE user_id = ?)");

        if(!$stmt -> execute(array($users[0]['user_id']))) {
            $stmt = null;
            echo "Error executing statement";
            exit();
        }
        if($stmt -> rowCount() == 0) {
            echo "<p style='background-color: red; color:white; boarder-radius:10px; padding:10px;'>Role name not found </p>";
       
            exit();
        }
        $stmt = $this -> connect() -> prepare("UPDATE user_roles SET role_id = ? WHERE user_id = ?)");

        if(!$stmt -> execute(array($roles[0]['role_id'],$users[0]['user_id']))) {
            $stmt = null;
            echo "Error executing statement";
            exit();
        }

        echo "<p style='background-color: green; color:white; boarder-radius:10px; padding:10px;'>Role successfully Updated </p>";
       

    }

    public function view_roles() {
        $stmt = $this -> connect() -> prepare("SELECT * FROM user_roles INNER JOIN users ON user_roles.user_id = users.user_id INNER JOIN roles ON user_roles.role_id = roles.role_id");
        if(!$stmt -> execute()) {
            $stmt = null;
            echo "error executing statement";
            exit();
        }
        $data = $stmt ->fetchAll(PDO::FETCH_ASSOC);

        echo "<div class='table-data'>
				<div class='order'>  						 
					<div class='head'>
						<h3>Roles</h3>
						<i class='bx bx-search'></i>
						<i class='bx bx-filter'></i>
					</div>
                    <div>
                        <table>
                            <tr>
                                <td>First name</td>
                                <td>Last Name</td>
                                <td>Email</td>
                                <td>Username</td>
                                <td>Role name</td>
                                
                            </tr>

                    ";
        foreach($data as $row){
            echo "
                    
                            <tr>
                                <td>".$row['first_name']."</td>
                                <td>".$row['last_name']."</td>
                                <td>".$row['user_email']."</td>
                                <td>".$row['username']."</td>
                                <td>".$row['role_name']."</td>
                                
                            </tr>
                        
                            ";
       }



    }
}