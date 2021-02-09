<?php
require_once( './Includes/DB.php' );

// takes in webaddress as on argument and redirect to that address
function Redirect_to($New_Location){
    header('Location:'.$New_Location);
    exit;
}

// Check if a username already exists or not 
function CheckUserNameExistsOrNot($UserName) {
    global $ConnectingDB;
    $sql = "SELECT username FROM admins WHERE username=:userName";
    $stmt = $ConnectingDB->prepare($sql);
    $stmt->bindValue(':userName', $UserName);
    $stmt->execute();
    $Result = $stmt->rowcount();
    if($Result ==1){
        return true;
    } else {
        return false;
    }
}

function Login_Attempt($UserName, $Password){
    global $ConnectingDB;
    $sql = "SELECT * FROM admins WHERE username=:userName AND password=:passWord LIMIT 1";
    $stmt = $ConnectingDB->prepare($sql);
    $stmt->bindValue(':userName',$UserName);
    $stmt->bindValue(':passWord',$Password);
    $stmt->execute();
    $Result = $stmt->rowcount();
    if($Result==1){
        return $Found_Account=$stmt->fetch();
    } else {
        return null;
    }
}

?>