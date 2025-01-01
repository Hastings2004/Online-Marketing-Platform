<?php

class Notifications extends Database{

public function create_notification($username, $user_email, $message){
    $stmt = $this -> connect()->prepare("SELECT * FROM users WHERE username = ? OR user_email = ?");

    if(!$stmt->execute(array($username, $user_email))){
        $stmt = null;
        echo "error creating notification";
        exit();
    }

    if($stmt->rowCount() == 0){
        echo "<p style='background-color:red; color:white; border-radius:10px; padding:10px;'> User  not found</p>";
        exit();
    }

    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $this -> connect()->prepare("INSERT INTO notifications (user_id, message_created,is_read) VALUES (?, ?,?)");
    if(!$stmt->execute(array($users[0]['user_id'], $message, 0))){
        $stmt = null;
        echo "error in executing insert notification";
        exit();
    }
    echo "<p style='background-color: green; color:white; border-radius:10px; padding:10px;'> Notification successfully created</p>";
    
}

public function update_notification($notification_id, $user_id, $message){
    $stmt = $this -> connect()->prepare("SELECT * FROM notifications WHERE notification_id = ? OR user_id");
    if(!$stmt->execute(array($notification_id, $user_id))){
        $stmt = null;
        echo "error in executing update notification";
        exit();
    }

    if($stmt->rowCount() == 0){
        echo "<p style='background-color: red; color:white; border-radius:10px; padding:10px;'> User ID not found</p>";
        exit();
    }
    $stmt = $this -> connect()->prepare("UPDATE notifications SET message_created = ? WHERE notification_id = ?");
    if(!$stmt->execute(array($message,$notification_id))){
        $stmt = null;
        echo "error in execution";
        exit();
    }
    echo "<p style='background-color: green; color:white; border-radius:10px; padding:10px;'> Notification successfully Updated</p>";
    

}

public function delete_notification($notification_id, $user_id){
    $stmt = $this -> connect()->prepare("SELECT * FROM notifications WHERE notification_id = ? OR user_id = ?");
    if(!$stmt->execute(array($notification_id, $user_id))){
        $stmt = null;
        echo "error in execution";
        exit();
    }

    if($stmt->rowCount() == 0){
        echo "<p style='background-color: red; color:white; border-radius:10px; padding:10px;'> Notification not found</p>";
        exit();
    }

    $stmt = $this -> connect()->prepare("DELETE FROM notifications WHERE notification_id = ? OR user_id = ?");
    if(!$stmt->execute(array($notification_id, $user_id))){
        $stmt = null;
        echo "error in execution";
        exit();
    }
    echo "<p style='background-color: green; color:white; border-radius:10px; padding:10px;'> Notification successfully deleted</p>";
    exit();

}

public function user_notification( $user_id){
    $stmt = $this -> connect()->prepare("SELECT * FROM notifications WHERE user_id = ? ORDER BY created_time DESC");

    if(!$stmt->execute(array($user_id))){
        $stmt = null;
        echo "error in execution";
        exit();
    }

    if($stmt->rowCount() == 0){
        echo "<p style='background-color: green; color:white; border-radius:10px; padding:10px;'> You dont have any Notification</p>";
        exit();
    }

    $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
     foreach($notifications as $notification){

        if($notification["is_read"] == 0){
            echo"<p style='background-color: green; color:white; border-radius:10px; padding:10px;'> 
            ".$notification['message_created']."  created at ".$notification['created_time']."
            </p>";

        }
       
     
        $stmt = $this-> connect() -> prepare("UPDATE notifications SET is_read=1 WHERE user_id = ?");
        if(!$stmt->execute(array($user_id))){
            $stmt = null;
            echo "error in execution";
            exit();
        }
    

    
     }
}

public function get_Uread_notification(){

    $stmt = $this -> connect()->prepare("SELECT COUNT(*) FROM notifications WHERE user_id = ? AND is_read = ?");
    if(!$stmt->execute(array($_SESSION['user_id'], 0))){
        $stmt = null;
        echo "error in execution";
        exit();
    }
    if($stmt->rowCount() == 0){
        echo "0";
        exit();
    }
    $unread = $stmt->fetchColumn();

    echo $unread;

}

}

