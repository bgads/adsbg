<?php
function redirect ($url) { header('Location:' .$url); }
$db = sqlite3_open('test.db');

$ad_title = $_GET["ad_title"];
$ad_text = $_GET["ad_text"];

$result = sqlite3_exec($db, "insert into posts (category_id, title, contents) VALUES (0, '$ad_title', '$ad_text')");

sqlite3_close($db);

redirect ("index.html");
?>
