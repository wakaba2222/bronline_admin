<?php
namespace Fuel\Tasks;
use Fuel\Core\Cli;
use Fuel\Core\DB;
use Fuel\Core\DBUtil;
use Curl\CurlUtil;


class Customer
{
// define('POINT_LOG_ISSUE', '1');		// 仮発行
// define('POINT_LOG_ENABLE', '2');	// 有効昇華
// define('POINT_LOG_USE', '3');		// 利用
// define('POINT_LOG_ADD', '4');		// 加算（管理画面から）
// define('POINT_LOG_SUB', '5');		// 減算（管理画面から）
// define('POINT_LOG_CANCEL', '6');	// キャンセル（仮発行時のみ減算）
// define('POINT_LOG_LOST', '7');		// 失効（購入から1年365日）
// define('POINT_LOG_TEMP_LOST', '8');	// 失効
// define('POINT_LOG_ISSUE_SHOP', '9');	// 仮発行（SHOP用）

    public function run($n = '')
    {
		$this->outLog('check run start...','');
		$this->outLog('check_lastupdate start...','');
//        $this->check_lastupdate();
		$this->outLog('check_temp_point start...','');
        $this->check_temp_point();
		$this->outLog('fast_mail start...','');
        $this->fast_mail();
		$this->outLog('last_mail start...','');
        $this->last_mail();
		$this->outLog('lost start...','');
        $this->lost_point();
		$this->outLog('check_rank start...','');
        $this->check_rank();
		$this->outLog('check run end.','');
    }

    function check_lastupdate()
    {
//		$target = date('Y-m-d', strtotime(" -3 days "));
//       	$this->outLog('target date:',$target);
		
//        $sql = "select customer_id,order_id,create_date from dtb_order where del_flg = 0 and status = 5 and customer_id <> 0 and create_date >= '{$target}' order by order_id ";
        $sql = "select customer_id,MAX(create_date) as create_date from dtb_order where del_flg = 0 and status = 5 and customer_id <> 0 group by customer_id";
//       	$this->outLog('target date:',$sql);

        $query = DB::query($sql);
        $arrRet = $query->execute()->as_array();
        
        foreach($arrRet as $ret)
        {
        	$sql = "update dtb_customer set last_buy_date = '{$ret['create_date']}' where customer_id = '{$ret['customer_id']}'";
	        $query = DB::query($sql);
	        $query->execute();
        }
    }

	function check_rank()
	{
		$now = date('m-d', strtotime(" -30 day"));
//		$now = date('m-d');
        $sql = "select * from dtb_customer where del_flg = 0 and status = 2 and DATE_FORMAT(create_date, '%m-%d') = '{$now}'";
        $query = DB::query($sql);
        $arrRet = $query->execute()->as_array();
        
		$after = date('Y-m-d 00:00:00', strtotime(" -30 day"));
		$before = date('Y-m-d 00:00:00', strtotime(" -1 year -30 day"));

       	$this->outLog('check date:',$after);
       	$this->outLog('check date2:',$before);

		$sql1 = "select SUM(payment_total) as total from (select SUM(payment_total) as payment_total,customer_id from dtb_order ";
		$sql1 .= " where ((status = 5 || status = 9 || status = 17) and del_flg = 0) and (create_date >= '{$before}' and create_date <= '{$after}') ";
		$sql1 .= " group by customer_id ";
		$sql1 .= " union all select SUM(payment_total) as payment_total,customer_id from dtb_history_order ";
		$sql1 .= " where ((status = 5 || status = 9 || status = 17) and del_flg = 0) and (create_date >= '{$before}' and create_date <= '{$after}') ";
		
		$rank_list = array(2000000=>4,1000000=>3,500000=>2);

		foreach($arrRet as $ret)
		{
			$arrRet2 = array();
			$before_rank = $ret['customer_rank'];
			$customer_id = $ret['customer_id'];
			$sql2 = " group by customer_id) as A where customer_id = {$customer_id} ";
//var_dump($sql1.$sql2);	        
	        $query = DB::query($sql1.$sql2);
	        $arrRet2 = $query->execute()->as_array();
	        if (count($arrRet2) > 0)
	        {
	        	$total = 0;
	        	$total = $arrRet2[0]['total'];
	        	
            	$this->outLog('user:',$customer_id);
            	$this->outLog('total:',$total);

	        	$rank = 1;
	        	$point_rate = 1;
	        	foreach($rank_list as $k=>$v)
	        	{
	        		if ($total > $k)
	        		{
	        			$rank = $v;
	        			if ($v == 2)
		        			$point_rate = 2;
		        		else
		        			$point_rate = 5;
		            	$this->outLog('rank:',$rank);
		            	$this->outLog('point_rate:',$point_rate);
	        			break;
	        		}
	        	}
	        	
	        	if ($before_rank != $rank)
	        	{
	            	$this->outLog('rank change:',$before_rank."->".$rank);
		        	$sql = "update dtb_customer set customer_rank = {$rank} where customer_id = {$customer_id}";
		        	$query2 = DB::query($sql);
		        	$query2->execute();

					if ($rank == 4)
					{
		            	$this->outLog('rate:',$point_rate);
		            	$this->outLog('rank diamond add point 10000pt.',$customer_id);
			        	$sql_point = "update dtb_point set point_rate = {$point_rate}, point = point + 10000 where customer_id = {$customer_id}";
			        	$query3 = DB::query($sql_point);
			        	$query3->execute();
	
			        	$sql_point_log = "insert into dtb_point_log (customer_id,point,status,order_id) values({$customer_id},10000,4,0)";
			        	$query4 = DB::query($sql_point_log);
			        	$query4->execute();
					}
					else
					{
		            	$this->outLog('rate:',$point_rate);
			        	$sql_point = "update dtb_point set point_rate = {$point_rate} where customer_id = {$customer_id}";
			        	$query5 = DB::query($sql_point);
			        	$query5->execute();
					}
	        	}
	        }
		}
	}
    function check_temp_point()
    {
        $sql = "select * from dtb_basis";
        $query = DB::query($sql);
        $arrRet = $query->execute()->as_array();
        $CONF = $arrRet[0];
        $this->outLog('check_temp_point', $CONF['pointtopoint'].'days');

        $now = date('Y-m-d H:i:s', strtotime("-".$CONF['pointtopoint']." days"));
        $where = "create_date < '".$now."'";
        $sql = "select * from dtb_temp_point where create_date < '{$now}'";
        $query = DB::query($sql);
        $arrValid = $query->execute()->as_array();
        $this->outLog('check_temp_point', count($arrValid));
        
        if (count($arrValid) > 0)
            $this->move_point($arrValid);
    }
        
    function fast_mail()
    {
        $sql = "select * from dtb_basis";
        $query = DB::query($sql);
        $arrRet = $query->execute()->as_array();
        $CONF = $arrRet[0];

        $arrRet = $this->check_customer($CONF['send_mail_fast']);

        foreach($arrRet as $ret)
        {
        	$ret['point_date'] = date('Y-m-d',strtotime($ret['last_buy_date']." +".$CONF['lost_point']."days"));
    //    	print_r("fast mail:".$ret['email']."<br>");
            $this->outLog('fast mail','50');
            $this->outLog('fast mail',$ret['name01'].$ret['name02'].':'.$ret['email']);
    		\Tag_CronMail::send($ret, 50);
        }

    }
    
    function last_mail()
    {
        $sql = "select * from dtb_basis";
        $query = DB::query($sql);
        $arrRet = $query->execute()->as_array();
        $CONF = $arrRet[0];
    
        $arrRet = $this->check_customer($CONF['send_mail_last']);
        
        foreach($arrRet as $ret)
        {
        	$ret['point_date'] = date('Y-m-d',strtotime($ret['last_buy_date']." +".$CONF['lost_point']."days"));
    //    	print_r("last mail:".$ret['email']."<br>");
            $this->outLog('last mail','51');
            $this->outLog('last mail',$ret['name01'].$ret['name02'].':'.$ret['email']);
    		\Tag_CronMail::send($ret, 51);
        }
    }

    function check_customer($day,$y = false)
    {    
       	$now = date('Y-m-d H:i:s', strtotime("-".$day." days"));
       	$now2 = date('Y-m-d H:i:s', strtotime("-".($day+1)." days"));
    //   	$arrRet = getCustomerPoint("point_flg > 0 and point > 0 and (last_buy_date > '".$now2."' and last_buy_date < '".$now."')");
        if (!$y)
	       	$arrRet = $this->getCustomerPoint("point > 0 having (last_buy_date > '".$now2."' and last_buy_date < '".$now."')");
	    else
	       	$arrRet = $this->getCustomerPoint("point > 0 having (last_buy_date < '".$now."')");
    //print_r($now."<br>");
    //print_r($now2."<br>");
       	return $arrRet;
    }

    function lost_point()
    {
        $sql = "select * from dtb_basis";
        $query = DB::query($sql);
        $arrRet = $query->execute()->as_array();
        $CONF = $arrRet[0];
        
        $arrRet = $this->check_customer($CONF['lost_point'], true);
    
        foreach($arrRet as $ret)
        {
        	$customer_id = $ret['customer_id'];
        	$where = "customer_id = {$customer_id}";
        	$sql = array();
        	$sql['point'] = '0';
//    		$sql['update_date'] = 'CURRENT_TIMESTAMP';

    		DB::update('dtb_point')->set($sql)->where('customer_id','=',$customer_id)->execute();
//            $query = DB::update('dtb_point');
//            $query->where('customer_id','=',$customer_id);
//            $query->execute();
            $this->set_point($ret['customer_id'], $ret['point'],POINT_LOG_LOST);
            $this->outLog('lost',$ret['customer_id']);
        }
    }

    function set_point($customer_id, $point, $status, $order_id = 0)
    {
		$table_name = 'dtb_point_log';
		$column['customer_id'] = $customer_id;
		$column['order_id'] = $order_id;
		$column['point'] = $point;
		$column['status'] = $status;
		
		$query = DB::insert($table_name);
		$query->set($column);
		$query->execute();
    }

    function getCustomerPoint($where = "")
    {
//         $where_org = $where;
        $sql = "select dtb_customer.customer_id,point,email,name01,name02,";
        $sql .= " case when last_buy_date is NULL  ";
        $sql .= " then (select create_date from dtb_order where ((status = 5 || status = 9 || status = 17) and del_flg = 0) and dtb_customer.customer_id = customer_id order by create_date desc limit 1)  ";
        $sql .= " when (select create_date from dtb_order where ((status = 5 || status = 9 || status = 17) and del_flg = 0) and dtb_customer.customer_id = customer_id order by create_date desc limit 1) > last_buy_date  ";
        $sql .= " then (select create_date from dtb_order where ((status = 5 || status = 9 || status = 17) and del_flg = 0) and dtb_customer.customer_id = customer_id order by create_date desc limit 1) ";
        $sql .= " else last_buy_date end as last_buy_date from dtb_customer join dtb_point on dtb_point.customer_id = dtb_customer.customer_id ";
//        $sql .= "create_date desc limit 1) end as last_buy_date from dtb_customer join dtb_point on dtb_point.customer_id = dtb_customer.customer_id";
//         $sql = "select * from dtb_customer join dtb_point on dtb_point.customer_id = dtb_customer.customer_id join dtb_order on dtb_customer.customer_id = dtb_order.customer_id and dtb_order.del_flg = 0 ";
//         $where = str_replace('last_buy_date', 'dtb_order.create_date', $where);
        $query = DB::query($sql.' where '.$where);
//var_dump($sql.' where '.$where);
        $arrRet = $query->execute()->as_array();
        $this->outLog("getCustomerPoint",$where);
//         
//         if (count($arrRet) > 0)
//         {
//             $sql = "select * from dtb_customer join dtb_point on dtb_point.customer_id = dtb_customer.customer_id join dtb_order on dtb_customer.customer_id = dtb_order.customer_id and dtb_order.del_flg = 0 ";
//             $where = $where_org;
//             $query = DB::query($sql.' where '.$where);
//             $arrRet = $query->execute()->as_array();
//         }
    
    	return $arrRet;
    }

    function move_point($arrValid)
    {
    	foreach($arrValid as $point)
    	{
    		$customer_id = $point['customer_id'];
    		$order_id = $point['order_id'];
    		$p = $point['point'];
    		$d = $point['create_date'];
    		
    		$arrRet = DB::select("point")->from('dtb_point')->where('customer_id','=',$customer_id)->execute()->as_array();
    		$this->outLog('move_point',count($arrRet));
    		
        	$sql = array();
    		$sql['point'] = intVal($arrRet[0]['point']) + intVal($p);
//    		$sql['update_date'] = 'CURRENT_TIMESTAMP';
  //  		$where = "customer_id = ?";
    		$this->outLog('move_point',$customer_id.":".$sql['point']);
    		
    		DB::update('dtb_point')->set($sql)->where('customer_id','=',$customer_id)->execute();
            DB::delete('dtb_temp_point')->where('customer_id','=',$customer_id)->and_where('order_id','=',$order_id)->execute();
            $this->set_point($customer_id, $p, POINT_LOG_ENABLE, $order_id);
    	}
    }

    
    function outLog($name, $data)
    {
    	print(date('[Y-m-d H:i:s]:').$name.":".$data.PHP_EOL);
//    	fwrite($fp,date("Ymd H:i:s")."   ".$name.":".$data.PHP_EOL);
    }

// 	public function send($ret, $template_id)
// 	{
// 		$customer = $ret;
// 		//メール送信
// 		echo $customer['name01'].$customer['name02'];
// 	}
}
?>