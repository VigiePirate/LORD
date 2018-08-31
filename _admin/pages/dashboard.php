<?php

echo "<h3>Le dashboard reviendra vite ;)</h3>";

echo "<p>Gateway IP : ".$_SERVER['REMOTE_ADDR']."</p>";
if (isset($_SERVER['HTTP_X_REMOTE_IP']))
{
	echo "<p>Client IP : ".$_SERVER['HTTP_X_REMOTE_IP']."</p>";
}

if(isset($_COOKIE['token']))
{
	echo "<p>You have a cookie (＾ｖ＾)<br />".$_COOKIE['token']."</p>";
}
else
{
	echo "<p>You don't have cookie (；一_一)</p>";
}

print_r($User);
