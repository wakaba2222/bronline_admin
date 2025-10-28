<?php
class Format extends Fuel\Core\Format
{
	/**
	 * CSV出力をSJIS-WINで返す
	 * @param mixed $data
	 * @return string csv(sjis-win)
	 */
	public function to_csv($data = null, $delimiter = null, $enclose_numbers = null, array $headings = array())
	{
		$csv = parent::to_csv($data);
		return $csv = mb_convert_encoding($csv, 'SJIS-win', 'UTF-8');
	}
}
?>