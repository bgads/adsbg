<?php
include 'benchmark.php';
ini_set('memory_limit', '256M');

Benchmark::start('page');

define('DB', 'test.db');

$db = new PDO('sqlite:'.dirname(__FILE__).'/'.DB);

// Create index.html

function parse($view, $data)
{
	extract($data);
	ob_start();
	include $view;
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}

function create($name, $content)
{
	$dir = 'static/';

	if ( ! file_exists($dir) OR ! is_dir($dir))
	{
		mkdir($dir);
	}

	file_put_contents($dir.$name.'.html', $content);
}

// Fill the db with test data
function fill_db()
{
	global $db;

	$records = $db->query('SELECT id, title, contents FROM posts LIMIT 0, 3')->fetchAll(PDO::FETCH_OBJ);
	
	$sql = "INSERT INTO posts (category_id, title, contents) VALUES (0, '%s', '%s')";

	for ($i = 0; $i < 5000; $i++)
	{
		$r = mt_rand(0, 2);
		$db->query(sprintf($sql, $records[$r]->title, $records[$r]->contents));
	}
}

if (isset($_SERVER['argv'][1]) AND $_SERVER['argv'][1] == 'fill')
{
	echo 'Generating test data.'.PHP_EOL;
	for ($i = 0; $i < 10; $i++)
	{
		fill_db();
		echo (($i+1) * 5000).' records generated.'.PHP_EOL;
	}
	exit;
}

Benchmark::start('select records');

$records = $db->query('SELECT id, title, contents FROM posts')->fetchAll(PDO::FETCH_OBJ);

Benchmark::stop('select records');
Benchmark::start('index');
$data = array(
	'title' => 'Craiglist ads',
	'records' => $records,
);

$index = parse('index.tpl', $data);
create('index', $index);
Benchmark::stop('index');

Benchmark::start('pages');
foreach ($records as $page)
{
	$data = array(
		'page' => $page
	);
	$content = parse('page.tpl', $data);
	create($page->id, $content);
}
Benchmark::stop('pages');
Benchmark::stop('page');

var_dump(Benchmark::get(TRUE));

