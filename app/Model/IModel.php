<?php

namespace App\Console\Model;

interface IModel
{
	public function toArray();
	public function toCsv($file);
}