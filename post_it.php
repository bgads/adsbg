<?php
function redirect($url) 
{ 
	header('Location:' .$url); 
}

$database = dirname(__FILE__).'/test.db';
// Using PDO driver as there is no other binding for sqlite v3.
// You must activate pdo.so, pdo_sqlite.so and sqlite.so extensions in
// your php.ini
$db = new PDO('sqlite:'.$database);

$ad_title = $_GET["ad_title"];
$ad_text = $_GET["ad_text"];

$sql = sprintf("INSERT INTO posts (category_id, title, contents) VALUES (0, '%s', '%s')", sqlite_escape_string($ad_title), sqlite_escape_string($ad_text));
$result = $db->query($sql);


redirect ("index.html");
