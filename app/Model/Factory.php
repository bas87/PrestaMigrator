<?php

namespace App\Console\Model;

use Goodby\CSV\Export\Standard\Exporter;
use Goodby\CSV\Export\Standard\ExporterConfig;
use Goodby\CSV\Export\Standard\CsvFileObject;

final class Factory
{

	private $database;
	private $exporter;

	public function __construct($host, $database, $user, $pass)
	{
		$this->database = new \PDO("mysql:host=$host;dbname=$database", $user, $pass);
		$config = new ExporterConfig();
$config
    ->setDelimiter(";") // Customize delimiter. Default value is comma(,)
    ->setEnclosure("'")  // Customize enclosure. Default value is double quotation(")
    ->setEscape("\\")    // Customize escape character. Default value is backslash(\)
    ->setToCharset('SJIS-win') // Customize file encoding. Default value is null, no converting.
    ->setFromCharset('UTF-8') // Customize source encoding. Default value is null.
    ->setFileMode(CsvFileObject::FILE_MODE_WRITE) // Customize file mode and choose either write or append. Default value is write ('w'). See fopen() php docs
		;
		$this->exporter = new Exporter($config);
	}


	public function getCategoryModel()
	{
		return new CategoryModel($this->database, $this->exporter);
	}

}