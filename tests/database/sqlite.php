<?php
/**
 * @file
 * Test sqlite availability.
 */

function error($message)
{
	global $db;
	sqlite_close($db);
	unlink('test.db');
	die($message);
}

echo "Start testing\n";
$db = sqlite_open('test.db');
if ($db == FALSE)
	error('Could not open the test database');

$result = sqlite_query($db, 'CREATE TABLE pages (
				id INTEGER,
				title TEXT,
				content BLOB
			)');

if ($result == FALSE)
	error('Could not create table');

$result = sqlite_query($db, 'INSERT INTO pages VALUES (
				1, "Hello", "World"
			)');

if ($result == FALSE)
	error('Could not perform insert');

$result = sqlite_query($db, 'SELECT id, title FROM pages');

if ($result == FALSE)
	error('Could not perform select');

$row = sqlite_fetch_array($result);

if ($row['id'] != '1' OR $row['title'] != 'Hello')
	error('Retrieved values are wrong');

error('Test finished successfully');
