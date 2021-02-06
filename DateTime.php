<?php
date_default_timezone_set('America/New_York');
$CurrentTime=time();
// $DateTime=strftime("%Y-%m-%d %H:%M:%S" , $CurrentTime);
$DateTime=strftime("%B-%d-%Y %H:%M:%S" , $CurrentTime);
echo $DateTime;
?>