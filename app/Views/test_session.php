<?php
// Debug session information
echo "=== DEBUG SESSION INFO ===<br>";
echo "Session Data:<br>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

echo "<br>Session Get Methods:<br>";
echo "user_id: " . (session()->has('user_id') ? session()->get('user_id') : 'NOT SET') . "<br>";
echo "role: " . (session()->has('role') ? session()->get('role') : 'NOT SET') . "<br>";
echo "email: " . (session()->has('email') ? session()->get('email') : 'NOT SET') . "<br>";

echo "<br><a href='/auth/logout'>Logout</a>";
echo "<br><a href='/'>Home</a>";
?>
