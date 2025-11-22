<?php
$password_untuk_admin = 'sadmin123';

$hash = password_hash($password_untuk_admin, PASSWORD_DEFAULT);

echo "Password Anda: " . $password_untuk_admin;
echo "<br>";
echo "Hash (Salin ini): <br>";
echo $hash;
?>