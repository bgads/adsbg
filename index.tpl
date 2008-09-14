<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Index page</title>
	</head>
	<body>
		<h1>Craiglist ads</h1>
		<?php foreach ($records as $page): ?>
			<h2><a href="<?= $page->id ?>.html"><?= $page->title ?></a></h2>
			<p><?= $page->contents ?></p>
		<?php endforeach; ?>
	</body>
</html>
