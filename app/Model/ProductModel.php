<?php

namespace App\Console\Model;

use Goodby\CSV\Export\Standard\CsvFileObject;
use Goodby\CSV\Export\Standard\Collection\PdoCollection;

class ProductModel implements IModel
{

	private $database;
	private $exporter;


	public function __construct($database, $exporter)
	{
		$this->database = $database;
		$this->exporter = $exporter;
	}


	private static $baseQuery = '';

	public function toArray()
	{
	}


	public function toCsv($file)
	{
	}

}
