<?php
$user = $_POST['username'];
$pass = $_POST['password'];
$array = array('username' => $user, 'password' => $pass);
$string = http_build_query($array);
$url = "https://web.njit.edu/~fdm8/cs490/ourDB.php";
$ch = curl_init("https://web.njit.edu/~fdm8/cs490/ourDB.php");
//curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
if($response == 1){
    echo 1;
}else{
    echo 0;
}
curl_close($ch);
?>
