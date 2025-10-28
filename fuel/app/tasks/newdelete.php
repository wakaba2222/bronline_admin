<?php
namespace Fuel\Tasks;
use Fuel\Core\Cli;
use Fuel\Core\DB;
use Fuel\Core\DBUtil;
use Curl\CurlUtil;


class NewDelete{

	public function run() {

		$query = DB::delete('dtb_product_status');
		$query->where('create_date', '<', date('Y-m-d', strtotime(date('Y-m-d').' -21 day')).' 00:00:00');

		//echo $query->compile();

		$query->execute();
	}

}

?>