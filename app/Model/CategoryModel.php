<?php

namespace App\Console\Model;

use Goodby\CSV\Export\Standard\CsvFileObject;
use Goodby\CSV\Export\Standard\Collection\PdoCollection;

class CategoryModel
{

	private $database;
	private $exporter;


	public function __construct($database, $exporter)
	{
		$this->database = $database;
		$this->exporter = $exporter;
	}


	private static $baseQuery = '
		select
			c.id_category AS ID,
			c.active AS "Active (0/1)",
			cl.name AS "Name *",
			crl.name AS "Parent category",
			IF(c.level_depth = 0, 1, 0) AS "Root category (0/1)",
			cl.description AS Description,
			cl.meta_title AS "Meta title",
			cl.meta_keywords AS "Meta keywords",
			cl.meta_description AS "Meta description",
			cl.link_rewrite AS "URL rewrite",
			NULL AS "Image URL"
		from ps_category c
		join ps_category cr on cr.id_category = c.id_parent
		join ps_category_lang cl on cl.id_category=c.id_category
		join ps_category_lang crl on crl.id_category=cr.id_category
		';

	public function toArray()
	{
		$stmt = $this->database->prepare(sprintf('SELECT tmp.* FROM (%s) tmp LIMIT 1', self::$baseQuery));
		$stmt->execute();
		
		if ($row = $stmt->fetchAll(\PDO::FETCH_ASSOC)) {
			return [
				'header' => array_keys($row[0]),
				'rows' => [$row[0]]
			];
		} else {
			throw new EmptyTableException('No row was found for FETCH or the result of a query is an empty table.');
		}
	}


	public function toCsv($file)
	{
		$stmt = $this->database->prepare(self::$baseQuery);
		$stmt->execute();
		$this->exporter->export($file, new PdoCollection($stmt));
	}

}

class EmptyTableException extends \Exception {}
