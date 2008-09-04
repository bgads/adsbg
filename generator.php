<?php
/**
 * Simple static html generator
 */
class Generator {
	protected $data;
	protected $templates;

	public function __construct($data, $templates)
	{
		$this->data = $data;
		$this->templates = $templates;
	}

	public function generate()
	{
		$generated = '';

		foreach ($this->data as $row)
		{
			$generated .= '<br />'.PHP_EOL;
			$generated .= $this->parse($row, $this->templates['inner']).PHP_EOL;
		}

		$content = array('content' => $generated);

		return $this->parse($content, $this->templates['main']);
	}

	public function parse($data, $template)
	{
		foreach ($data as $key => $value)
		{
			$template = str_replace($this->key($key), $value, $template);
		}

		return $template;
	}

	public function key($key)
	{
		return '%%'.$key.'%%';
	}
}

class Test_Generator extends Generator {
	public function __construct()
	{
		$database = dirname(__FILE__).'/test.db';

		$db = new PDO('sqlite:'.$database);

		$result = $db->query('SELECT id, title, contents FROM posts')->fetchAll(PDO::FETCH_ASSOC);

		$this->data = $result;

		$this->templates['main'] = file_get_contents('main.tpl');
		$this->templates['inner'] = file_get_contents('inner.tpl');
	}
}

$test = new Test_Generator;
echo $test->generate();
