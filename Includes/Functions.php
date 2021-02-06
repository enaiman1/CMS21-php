<?php

// takes in webaddress as on argument and redirect to that address
function Redirect_to($New_Location){
    header('Location:'.$New_Location);
    exit;
}

?>