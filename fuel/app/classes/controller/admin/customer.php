<?php
use Oil\Exception;

/**
 * Fuel is a fast, lightweight, community driven PHP 5.4+ framework.
 *
 * @package    Fuel
 * @version    1.8.1
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2018 Fuel Development Team
 * @link       http://fuelphp.com
 */

/**
 * The Welcome Controller.
 *
 * A basic controller example.  Has examples of how to set the
 * response body and status.
 *
 * @package  app
 * @extends  Controller
 */
class Controller_Admin_Customer extends ControllerAdmin
{

	public function before() {
		parent::before();

		// マスタデータ取得
		$this->arrResult["arrPref"] = DB::select()->from('mtb_pref')->order_by('rank', 'asc')->execute()->as_array();
		$this->arrResult["arrSex"] = DB::select()->from('mtb_sex')->order_by('rank', 'asc')->execute()->as_array();
		$this->arrResult["arrMagazineType"] = DB::select()->from('mtb_mail_magazine_type')->order_by('rank', 'asc')->execute()->as_array();
		$this->arrResult["arrCustomerRank"] = DB::select()->from('mtb_customer_rank')->order_by('rank', 'asc')->execute()->as_array();
		$this->arrResult["arrCustomerStatus"] = DB::select()->from('mtb_customer_status')->order_by('rank', 'asc')->execute()->as_array();
		$this->arrResult["arrCustomerView"] = DB::select()->from('mtb_customer_view')->order_by('rank', 'asc')->execute()->as_array();
		$this->arrResult["arrCategory"] = Tag_Item::get_category();
		$this->arrResult["arrReminder"] = DB::select()->from('mtb_reminder')->order_by('rank', 'asc')->execute()->as_array();

		$this->arrResult["arrError"] = array();

		$this->keys = array(
			'customer_id'=>'会員ID',
//			'group_code'=>'グループコード',
//			'sale_status'=>'セール区分（0:通常 1:シークレット 2:VIPシークレット -1:除外）',
			'sale_status'=>'セール区分（0:通常 1:セール -1:除外）',
		);
		$this->arrResult['csv_no'] = $this->keys;

		$arrSALESTATUS = array();
		$arrSALESTATUS[0] = array('id'=>'0', 'name'=>"通常会員");
		$arrSALESTATUS[1] = array('id'=>'1', 'name'=>"セール");
//		$arrSALESTATUS[2] = array('id'=>'2', 'name'=>"VIPシークレット対象");
		$arrSALESTATUS[3] = array('id'=>'-1', 'name'=>"セール除外");
		$this->arrResult['arrSALESTATUS'] = $arrSALESTATUS;

		$arrTemp = Tag_Master::get_master('mtb_order_status');
		$arrORDERSTATUS = array();
		foreach($arrTemp as $t)
		{
			$arrORDERSTATUS[$t['id']] = $t['name'];
		}
		$this->arrResult['arrORDERSTATUS'] = $arrORDERSTATUS;

		$arrTemp = Tag_Master::get_master('mtb_order_status_color');
		$arrORDERSTATUS_COLOR = array();
		foreach($arrTemp as $t)
		{
			$arrORDERSTATUS_COLOR[$t['id']] = $t['name'];
		}
		$this->arrResult['arrORDERSTATUS_COLOR'] = $arrORDERSTATUS_COLOR;

//var_dump($this->arrResult["arrCustomerRank"]);
	}


	/**
	 * 顧客検索画面
	 */
	public function action_index()
	{

		$val = Validation::forge();
		$val->add_callable('Brvalidate');
		$val->add('search_customer_id', '会員ID');
		$val->add('search_pref', '都道府県');
		$val->add('search_name', 'お名前');

		if( Input::post('search_kana') != "" ) {
			$val->add('search_kana', 'お名前(フリガナ)')->add_rule('kana_only');
		} else {
			$val->add('search_kana', 'お名前(フリガナ)');
		}

		$val->add('search_sex', '性別');
		$val->add('search_birth_month', '誕生月');

		if( Input::post('search_b_start_year') != "" || Input::post('search_b_start_month') != "" || Input::post('search_b_start_day') != "" ) {
			$val->add('search_b_start_year', '誕生日開始年')->add_rule('required');
			$val->add('search_b_start_month', '誕生日開始月')->add_rule('required');
			$val->add('search_b_start_day', '誕生日開始日')->add_rule('required');
		} else {
			$val->add('search_b_start_year', '誕生日開始年');
			$val->add('search_b_start_month', '誕生日開始月');
			$val->add('search_b_start_day', '誕生日開始日');
		}

		if( Input::post('search_b_end_year') != "" || Input::post('search_b_end_month') != "" || Input::post('search_b_end_day') != "" ) {
			$val->add('search_b_end_year', '誕生日終了年')->add_rule('required');
			$val->add('search_b_end_month', '誕生日終了月')->add_rule('required');
			$val->add('search_b_end_day', '誕生日終了日')->add_rule('required');
		} else {
			$val->add('search_b_end_year', '誕生日終了年');
			$val->add('search_b_end_month', '誕生日終了月');
			$val->add('search_b_end_day', '誕生日終了日');
		}

		if( Input::post('search_email') != "" ) {
			$val->add('search_email', 'メールアドレス')->add_rule('valid_email');
		} else {
			$val->add('search_email', 'メールアドレス');
		}

		if( Input::post('search_tel') != "" ) {
			$val->add('search_tel', '電話番号')->add_rule('number_only');
		} else {
			$val->add('search_tel', '電話番号');
		}

		if( Input::post('search_buy_total_from') != "" ) {
			$val->add('search_buy_total_from', '購入金額')->add_rule('number_only');
		} else {
			$val->add('search_buy_total_from', '購入金額');
		}

		if( Input::post('search_buy_total_to') != "" ) {
			$val->add('search_buy_total_to', '購入金額')->add_rule('number_only');
		} else {
			$val->add('search_buy_total_to', '購入金額');
		}

		if( Input::post('search_buy_times_from') != "" ) {
			$val->add('search_buy_times_from', '購入回数')->add_rule('number_only');
		} else {
			$val->add('search_buy_times_from', '購入回数');;
		}

		if( Input::post('search_buy_times_to') != "" ) {
			$val->add('search_buy_times_to', '購入回数')->add_rule('number_only');
		} else {
			$val->add('search_buy_times_to', '購入回数');;
		}

		if( Input::post('search_start_year') != "" || Input::post('search_start_month') != "" || Input::post('search_start_day') != "" ) {
			$val->add('search_start_year', '登録日開始年')->add_rule('required');
			$val->add('search_start_month', '登録日開始月')->add_rule('required');
			$val->add('search_start_day', '登録日開始日')->add_rule('required');
		} else {
			$val->add('search_start_year', '登録日開始年');
			$val->add('search_start_month', '登録日開始月');
			$val->add('search_start_day', '登録日開始日');
		}

		if( Input::post('search_end_year') != "" || Input::post('search_end_month') != "" || Input::post('search_end_day') != "" ) {
			$val->add('search_end_year', '登録日終了年')->add_rule('required');
			$val->add('search_end_month', '登録日終了月')->add_rule('required');
			$val->add('search_end_day', '登録日終了日')->add_rule('required');
		} else {
			$val->add('search_end_year', '登録日終了年');
			$val->add('search_end_month', '登録日終了月');
			$val->add('search_end_day', '登録日終了日');
		}

		if( Input::post('search_buy_start_year') != "" || Input::post('search_buy_start_month') != "" || Input::post('search_buy_start_day') != "" ) {
			$val->add('search_buy_start_year', '最終購入日開始年')->add_rule('required');
			$val->add('search_buy_start_month', '最終購入日開始月')->add_rule('required');
			$val->add('search_buy_start_day', '最終購入日開始日')->add_rule('required');
		} else {
			$val->add('search_buy_start_year', '最終購入日開始年');
			$val->add('search_buy_start_month', '最終購入日開始月');
			$val->add('search_buy_start_day', '最終購入日開始日');
		}

		if( Input::post('search_buy_end_year') != "" || Input::post('search_buy_end_month') != "" || Input::post('search_buy_end_day') != "" ) {
			$val->add('search_buy_end_year', '最終購入日終了年')->add_rule('required');
			$val->add('search_buy_end_month', '最終購入日終了月')->add_rule('required');
			$val->add('search_buy_end_day', '最終購入日終了日')->add_rule('required');
		} else {
			$val->add('search_buy_end_year', '最終購入日終了年');
			$val->add('search_buy_end_month', '最終購入日終了月');
			$val->add('search_buy_end_day', '最終購入日終了日');
		}

		if( Input::post('search_buys_start_year') != "" || Input::post('search_buys_start_month') != "" || Input::post('search_buys_start_day') != "" ) {
			$val->add('search_buys_start_year', '購入期間日開始年')->add_rule('required');
			$val->add('search_buys_start_month', '購入期間日開始月')->add_rule('required');
			$val->add('search_buys_start_day', '購入期間日開始日')->add_rule('required');
		} else {
			$val->add('search_buys_start_year', '購入期間日開始年');
			$val->add('search_buys_start_month', '購入期間日開始月');
			$val->add('search_buys_start_day', '購入期間日開始日');
		}

		if( Input::post('search_buys_end_year') != "" || Input::post('search_buys_end_month') != "" || Input::post('search_buys_end_day') != "" ) {
			$val->add('search_buys_end_year', '購入期間日終了年')->add_rule('required');
			$val->add('search_buys_end_month', '購入期間日終了月')->add_rule('required');
			$val->add('search_buys_end_day', '購入期間日終了日')->add_rule('required');
		} else {
			$val->add('search_buys_end_year', '購入期間日終了年');
			$val->add('search_buys_end_month', '購入期間日終了月');
			$val->add('search_buys_end_day', '購入期間日終了日');
		}

		$val->add('search_buy_product_name', '購入商品名');
		$val->add('search_buy_product_code', '購入商品コード');
		$val->add('search_category_id', 'カテゴリ');
		$val->add('search_status', '会員状態');
		$val->add('search_mailmaga', '会員メルマガ');
		$val->add('search_rank', '会員ランク');
		$val->add('search_page_max', '検索結果表示件数');
		$val->add('search_page', '検索結果表示ページ');
		$val->add('search_sale_statuses', 'セール区分');

		$this->arrResult["arrCustomer"] = array();

		if( $val->run()) {
			// バリデーションエラーなし
			$post_per_page = $val->input('search_page_max');
			$page = $val->input('search_page');

			$offset = ($page -1) * $post_per_page;
			$arrBind = array();

			$mode = Input::param('mode');

			$sql  = "SELECT SQL_CALC_FOUND_ROWS t1.* ";
			$sql .= ",t2.name AS status_name ";
			$sql .= ",t3.name AS pref_name ";
			$sql .= ",t4.name AS sex_name ";
			if ($mode == "csv")
				$sql .= ",t5.point AS point ";
			$sql .= " FROM dtb_customer AS t1 ";
			$sql .= " LEFT JOIN mtb_customer_status AS t2 ON t1.status = t2.id ";
			$sql .= " LEFT JOIN mtb_pref AS t3 ON t1.pref = t3.id ";
			$sql .= " LEFT JOIN mtb_sex AS t4 ON t1.sex = t4.id ";
			if ($mode == "csv")
				$sql .= " LEFT JOIN dtb_point AS t5 ON t1.customer_id = t5.customer_id ";
			
			$sql .= " WHERE del_flg = 0 ";

			// 会員ID
			if( $val->input('search_customer_id')) {
				$sql .= " AND t1.customer_id = :customer_id ";
				$arrBind['customer_id'] = $val->input('search_customer_id');
			}

			// 都道府県
			if( $val->input('search_pref')) {
				$sql .= " AND pref = :pref ";
				$arrBind['pref'] = $val->input('search_pref');
			}

			// お名前
			if( $val->input('search_name')) {
				$sql .= " AND (name01 LIKE :name OR name02 LIKE :name) ";
				$arrBind['name'] = '%'.$val->input('search_name').'%';
			}

			// お名前(フリガナ)
			if( $val->input('search_kana')) {
				$sql .= " AND (kana01 LIKE :kana OR kana02 LIKE :kana) ";
				$arrBind['kana'] = '%'.$val->input('search_kana').'%';
			}

			// 性別
			if( $val->input('search_sex')) {
				$sql .= " AND sex IN ( ".implode(',', $val->input('search_sex'))." ) ";
			}

			// 誕生月
			if( $val->input('search_birth_month')) {
				$sql .= " AND birth LIKE '____-".substr('00'.$val->input('search_birth_month'), -2)."-__ %' ";
			}

			// 誕生日：開始
			if( $val->input('search_b_start_year')) {
				$sql .= " AND birth >= '".$val->input('search_b_start_year')."-".substr('00'.$val->input('search_b_start_month'), -2)."-".substr('00'.$val->input('search_b_start_day'), -2)."' ";
			}

			// 誕生日：終了
			if( $val->input('search_b_end_year')) {
				$sql .= " AND birth <= '".$val->input('search_b_end_year')."-".substr('00'.$val->input('search_b_end_month'), -2)."-".substr('00'.$val->input('search_b_end_day'), -2)."' ";
			}

			// メールアドレス
			if( $val->input('search_email')) {
				$sql .= " AND email = :email ";
				$arrBind['email'] = $val->input('search_email');
			}

			// 電話番号
			if( $val->input('search_tel')) {
				$sql .= " AND tel01 = :tel01 ";
				$arrBind['tel01'] = $val->input('search_tel');
			}
/*
			// 購入金額：開始
			if( $val->input('search_buy_total_from')) {
				$sql .= " AND buy_total >= :buy_total1 ";
				$arrBind['buy_total1'] = $val->input('search_buy_total_from');
			}

			// 購入金額：終了
			if( $val->input('search_buy_total_to')) {
				$sql .= " AND buy_total <= :buy_total2 ";
				$arrBind['buy_total2'] = $val->input('search_buy_total_to');
			}
*/
			// 購入金額：開始
			if( $val->input('search_buy_total_from')) {
				$sql .= " AND (select SUM(payment_total) from (select SUM(payment_total) as payment_total,customer_id from dtb_order where ((status = 5 || status = 9 || status = 17) and del_flg = 0) group by customer_id union all select SUM(payment_total) as payment_total,customer_id from dtb_history_order where ((status = 5 || status = 9 || status = 17) and del_flg = 0) group by customer_id) as A where customer_id = t1.customer_id) >= :buy_total1 ";
				$arrBind['buy_total1'] = $val->input('search_buy_total_from');
			}

			// 購入金額：終了
			if( $val->input('search_buy_total_to')) {
				$sql .= " AND (select SUM(payment_total) from (select SUM(payment_total) as payment_total,customer_id from dtb_order where ((status = 5 || status = 9 || status = 17) and del_flg = 0) group by customer_id union all select SUM(payment_total) as payment_total,customer_id from dtb_history_order where ((status = 5 || status = 9 || status = 17) and del_flg = 0) group by customer_id) as A where customer_id = t1.customer_id) <= :buy_total2 ";
				$arrBind['buy_total2'] = $val->input('search_buy_total_to');
			}

/*
			// 購入回数：開始
			if( $val->input('search_buy_times_from')) {
				$sql .= " AND buy_times >= :buy_times1 ";
				$arrBind['buy_times1'] = $val->input('search_buy_times_from');
			}

			// 購入回数：終了
			if( $val->input('search_buy_times_to')) {
				$sql .= " AND buy_times <= :buy_times2 ";
				$arrBind['buy_times2'] = $val->input('search_buy_times_to');
			}
*/
			// 購入回数：開始
			if( $val->input('search_buy_times_from')) {
				$sql .= " AND (select SUM(cnt) from (select count(*) as cnt,customer_id from dtb_order where ((status = 5 || status = 9 || status = 17) and del_flg = 0) group by customer_id union all select count(*) as cnt,customer_id from dtb_history_order where ((status = 5 || status = 9 || status = 17) and del_flg = 0) group by customer_id) as A where customer_id = t1.customer_id) >= :buy_times1 ";
				$arrBind['buy_times1'] = $val->input('search_buy_times_from');
			}

			// 購入回数：終了
			if( $val->input('search_buy_times_to')) {
				$sql .= " AND (select SUM(cnt) from (select count(*) as cnt,customer_id from dtb_order where ((status = 5 || status = 9 || status = 17) and del_flg = 0) group by customer_id union all select count(*) as cnt,customer_id from dtb_history_order where ((status = 5 || status = 9 || status = 17) and del_flg = 0) group by customer_id) as B where customer_id = t1.customer_id) <= :buy_times2 ";
				$arrBind['buy_times2'] = $val->input('search_buy_times_to');
			}

			// 登録日：開始
			if( $val->input('search_start_year')) {
				$sql .= " AND create_date >= '".$val->input('search_start_year')."-".substr('00'.$val->input('search_start_month'), -2)."-".substr('00'.$val->input('search_start_day'), -2)." 00:00:00' ";
			}

			// 登録日：終了
			if( $val->input('search_end_year')) {
				$sql .= " AND create_date <= '".$val->input('search_end_year')."-".substr('00'.$val->input('search_end_month'), -2)."-".substr('00'.$val->input('search_end_day'), -2)." 23:59:59' ";
			}
/*
			// 最終購入日：開始
			if( $val->input('search_buy_start_year')) {
				$sql .= " AND last_buy_date >= '".$val->input('search_buy_start_year')."-".substr('00'.$val->input('search_buy_start_month'), -2)."-".substr('00'.$val->input('search_buy_start_day'), -2)." 00:00:00' ";
			}

			// 最終購入日：	終了
			if( $val->input('search_buy_end_year')) {
				$sql .= " AND last_buy_date <= '".$val->input('search_buy_end_year')."-".substr('00'.$val->input('search_buy_end_month'), -2)."-".substr('00'.$val->input('search_buy_end_day'), -2)." 23:59:59' ";
			}
*/
			// 最終購入日：開始
			if( $val->input('search_buy_start_year')) {
				$sql .= " AND (select MAX(create_date) from (select MAX(create_date) as create_date,customer_id from dtb_order where ((status = 5 || status = 9 || status = 17) and del_flg = 0) group by customer_id union all select MAX(create_date) as create_date,customer_id from dtb_history_order where ((status = 5 || status = 9 || status = 17) and del_flg = 0) group by customer_id) as A where customer_id = t1.customer_id) >= '".$val->input('search_buy_start_year')."-".substr('00'.$val->input('search_buy_start_month'), -2)."-".substr('00'.$val->input('search_buy_start_day'), -2)." 00:00:00' ";
			}

			// 最終購入日：	終了
			if( $val->input('search_buy_end_year')) {
				$sql .= " AND (select MAX(create_date) from (select MAX(create_date) as create_date,customer_id from dtb_order where ((status = 5 || status = 9 || status = 17) and del_flg = 0) group by customer_id union all select MAX(create_date) as create_date,customer_id from dtb_history_order where ((status = 5 || status = 9 || status = 17) and del_flg = 0) group by customer_id) as A where customer_id = t1.customer_id) <= '".$val->input('search_buy_end_year')."-".substr('00'.$val->input('search_buy_end_month'), -2)."-".substr('00'.$val->input('search_buy_end_day'), -2)." 23:59:59' ";
			}

			// 購入期間日：開始
			if( $val->input('search_buys_start_year')) {
				$sql .= " AND EXISTS ( ";
				$sql .= "	SELECT * FROM dtb_order_detail AS st1 ";
				$sql .= "	JOIN dtb_order AS st2 ON st2.order_id = st1.order_id AND st2.del_flg = 0 ";
				$sql .= "	WHERE st2.customer_id = t1.customer_id ";
				$sql .= "	AND st2.create_date >= '".$val->input('search_buys_start_year')."-".substr('00'.$val->input('search_buys_start_month'), -2)."-".substr('00'.$val->input('search_buys_start_day'), -2)." 00:00:00' ";
				$sql .= " ) ";
			}

			// 購入期間日：終了
			if( $val->input('search_buys_end_year')) {
				$sql .= " AND EXISTS ( ";
				$sql .= "	SELECT * FROM dtb_order_detail AS st1 ";
				$sql .= "	JOIN dtb_order AS st2 ON st2.order_id = st1.order_id AND st2.del_flg = 0 ";
				$sql .= "	WHERE st2.customer_id = t1.customer_id ";
				$sql .= "	AND st2.create_date <= '".$val->input('search_buys_end_year')."-".substr('00'.$val->input('search_buys_end_month'), -2)."-".substr('00'.$val->input('search_buys_end_day'), -2)." 23:59:59' ";
				$sql .= " ) ";
			}

			// 購入商品名
			if( $val->input('search_buy_product_name')) {
				$sql .= " AND EXISTS ( ";
				$sql .= "	SELECT * FROM dtb_order_detail AS st1 ";
				$sql .= "	JOIN dtb_order AS st2 ON st2.order_id = st1.order_id AND st2.del_flg = 0 ";
				$sql .= "	WHERE st2.customer_id = t1.customer_id ";
				$sql .= "	AND st1.product_name LIKE :product_name ";
				$sql .= " ) ";
				$arrBind['product_name'] = '%'.$val->input('search_buy_product_name').'%';
			}

			// 購入商品コード
			if( $val->input('search_buy_product_code')) {
				$sql .= " AND EXISTS ( ";
				$sql .= "	SELECT * FROM dtb_order_detail AS st1 ";
				$sql .= "	JOIN dtb_order AS st2 ON st2.order_id = st1.order_id AND st2.del_flg = 0 ";
				$sql .= "	WHERE st2.customer_id = t1.customer_id ";
				$sql .= "	AND st1.product_id = :product_id ";
				$sql .= " ) ";
				$arrBind['product_id'] = $val->input('search_buy_product_code');
			}

			// カテゴリ
			if( $val->input('search_category_id')) {
				$sql .= " AND EXISTS ( ";
				$sql .= "	SELECT * FROM dtb_order_detail AS st1 ";
				$sql .= "	JOIN dtb_order AS st2 ON st2.order_id = st1.order_id AND st2.del_flg = 0 ";
				$sql .= "	JOIN dtb_product_category AS st3 ON st3.product_id = st1.product_id ";
				$sql .= "	WHERE st2.customer_id = t1.customer_id ";
				$sql .= "	AND st3.category_id = ".$val->input('search_category_id');
				$sql .= " ) ";
			}

			// 会員状態
			if( $val->input('search_status')) {
				$sql .= " AND status IN ( ".implode(',', $val->input('search_status'))." ) ";
			}

			// 会員メルマガ
			if( $val->input('search_mailmaga')) {
				$sql .= " AND mailmaga_flg IN ( ".implode(',', $val->input('search_mailmaga'))." ) ";
			}

			// 会員ランク
			if( $val->input('search_rank')) {
				$sql .= " AND customer_rank = ".$val->input('search_rank');
			}
			if( $val->input('search_sale_statuses')) {
				$sql .= " AND sale_status IN ( ".implode(',', $val->input('search_sale_statuses'))." ) ";
//				$sql .= " AND sale_status in ( ".:sale01 ";
//				$arrBind['sale01'] = $val->input('search_sale_statuses');
			}

			$sql .= " GROUP BY t1.customer_id ";
			$sql .= " ORDER BY t1.customer_id ASC ";
			
			$sql2 = $sql;
			
			$sql .= " LIMIT ".$offset.", ".$post_per_page;

			/*
			echo $sql."<br/>";
			print_r($arrBind);
			*/

//var_dump($mode);
//var_dump($sql2);

			$query = DB::query($sql);
//			foreach ( $arrBind as $k => $v ) {
//				$query->bind($k, $v);
//			}

			$query->parameters($arrBind);
			$arrRet = $query->execute()->as_array();

			//echo "<br/>".count($arrRet);

			$query2 = DB::query("SELECT FOUND_ROWS()");
			$arrRet2 = $query2->execute()->as_array();
			$maxCount = $arrRet2[0]['FOUND_ROWS()'];

			// 戻り値設定
			$this->arrResult["arrCustomer"] = $arrRet;
			$this->arrResult["recordNum"] = count($arrRet);
			$this->arrResult["maxRecordNum"] = $maxCount;
			$this->arrResult["pageNum"] = $page;
			$this->arrResult["maxPageNum"] = ceil($maxCount/$post_per_page);

			if ($mode == 'csv')
			{
				$keys = array(
					'会員ID',
					'メールアドレス',
					'ランク',
					'お名前（姓）',
					'お名前（名）',
					'ポイント',
					'セール区分',
				);
				$cols = array();
				foreach ($keys as $k) {
					$cols[] = $k;
				}

				$csv_data = array();
				array_push($csv_data, $cols);

				$query = DB::query($sql2);
				foreach ( $arrBind as $k => $v ) {
					$query->bind($k, $v);
				}
	
				$arrRet = $query->execute()->as_array();

				foreach ($arrRet as $data) {
					$data2 = array();
					foreach ( $data as &$col ) {
						$col = htmlspecialchars($col);
					}
					$data2[] = $data['customer_id'];
					$data2[] = $data['email'];
					$data2[] = $data['customer_rank'];
					$data2[] = $data['name01'];
					$data2[] = $data['name02'];
					$data2[] = $data['point'];
					$data2[] = $data['sale_status'];
		
					array_push($csv_data, $data2);
				}
		
				$this->response = new Response();
				$this->response->set_header('Content-Type', 'application/csv');
				$this->response->set_header('Content-Disposition', 'attachment; filename="'.'customer'.'_'.date('Ymd').'.csv"');
				echo Format::forge($csv_data)->to_csv();
				$this->response->send(true);
				exit();
			}
		} else {
			// バリデーションエラーあり
			$errors = $val->error();

			$arrError = array();
			foreach($errors as $f => $error )
			{
				$arrError[$f] = $error->get_message();
			}
			$this->arrResult["arrError"] = $arrError;
		}

		$this->arrResult["arrForm"] = $val->input();
//var_dump($this->arrResult['arrForm']);
//exit;
		$this->tpl = 'smarty/admin/customer/index.tpl';
		return $this->view;
	}

    public function set_point($customer_id, $point, $status, $create_date, $order_id = 0, $del_id = 0)
    {
		$table_name = 'dtb_point_log';
		$column['customer_id'] = $customer_id;
		$column['order_id'] = $order_id;
		$column['point'] = $point;
		$column['status'] = $status;
		$column['create_date'] = $create_date;
		$column['del_id'] = $del_id;
		
		$query = DB::insert($table_name);
		$query->set($column);
		$query->execute();
    }

    public function set_temp_point($customer_id, $point, $create_date, $order_id = 0)
    {
		$table_name = 'dtb_temp_point';
		$column['customer_id'] = $customer_id;
		$column['order_id'] = $order_id;
		$column['point'] = $point;
		$column['create_date'] = $create_date;
		
		$query = DB::insert($table_name);
		$query->set($column);
		$query->execute();
    }

	public function del_temp_point($customer_id, $order_id, $point, $create_date)
	{
		$temp = array();
		$temp['customer_id'] = $customer_id;
		$temp['order_id'] = $order_id;
		$temp['point'] = $point;
		$temp['create_date'] = $create_date;

		$table_name = "dtb_temp_point";
		$query = DB::delete($table_name)->where('customer_id', '=', $customer_id)->and_where('order_id', '=', $order_id)->and_where('point', '=', $point);
		$query->execute();
	}


	/**
	 * 顧客情報編集画面
	 */
	public function action_edit()
	{

		$this->arrResult["arrSearch"] = Input::post();

		$mode = Input::post('mode');
		$customer_id = Input::post('customer_id');

		if ($mode == 'point_add')
		{
			$point_rate = Input::post('point_rate');
			$price = Input::post('price');
			$last_buy_date = Input::post('create_date');
			$point_mode = Input::post('point_mode');
			$addLogPoint = Input::post('add_point', '0');
			$addLogStatus = POINT_LOG_ISSUE_SHOP;
			//($customer_id, $point, $status, $create_date, $order_id = 0)
			
			if ($point_mode == '1')
			{
				$addLogPoint = ($price / ((TAX_RATE+100)/100)) * ($point_rate/100);
			}
			
			$this->set_point($customer_id, $addLogPoint, $addLogStatus, $last_buy_date);
			$this->set_temp_point($customer_id, $addLogPoint, $last_buy_date);

        	$sql = "update dtb_customer set last_buy_date = '{$last_buy_date}' where customer_id = '{$customer_id}'";
	        $query = DB::query($sql);
	        $query->execute();
			DB::commit_transaction();

//			$addLogStatus = POINT_LOG_ADD;
			
//			return Response::redirect(Input::referrer());
		}
		else if ($mode == 'point_delete')
		{
			$del_id = Input::post('del_id');
			$del_point = Input::post('del_point');
			$last_buy_date = Input::post('del_date');
			$order_id = 0;
			$this->del_temp_point($customer_id, $order_id, $del_point, $last_buy_date);

			$addLogStatus = POINT_LOG_CANCEL;
			$this->set_point($customer_id, $del_point, $addLogStatus, date('Y-m-d H:i:s'), 0, $del_id);

        	$sql = "update dtb_point_log set del_id = '1' where id = {$del_id}";
	        $query = DB::query($sql);
	        $query->execute();
			DB::commit_transaction();
			
//			return Response::redirect(Input::referrer());
		}

		$arrCustomer = DB::select(
				'dtb_customer.*',
				array('mtb_customer_rank.name', 'rank_name'),
				'dtb_stage.point_rate',
				'dtb_point.point'
				)->from('dtb_customer')
				->join('dtb_point', 'left')->on('dtb_customer.customer_id', '=', 'dtb_point.customer_id')
				->join('dtb_stage', 'left')->on('dtb_customer.customer_rank', '=', 'dtb_stage.stage_rank')
				->join('mtb_customer_rank', 'left')->on('dtb_customer.customer_rank', '=', 'mtb_customer_rank.id')
				->where('dtb_customer.customer_id', $customer_id)->execute()->as_array();

		if( Input::post('name01') !="") {
			$this->arrResult['arrForm'] = Input::post();
			if( 0 < count($arrCustomer)) {
				$this->arrResult['arrForm']['last_buy_date'] = $arrCustomer[0]['last_buy_date'];
			}
		} else {
//			$arrCustomer = DB::select(
//					'dtb_customer.*',
//					array('mtb_customer_rank.name', 'rank_name'),
//					'dtb_stage.point_rate',
//					'dtb_point.point'
//					)->from('dtb_customer')
//					->join('dtb_point', 'left')->on('dtb_customer.customer_id', '=', 'dtb_point.customer_id')
//					->join('dtb_stage', 'left')->on('dtb_customer.customer_rank', '=', 'dtb_stage.stage_rank')
//					->join('mtb_customer_rank', 'left')->on('dtb_customer.customer_rank', '=', 'mtb_customer_rank.id')
//					->where('dtb_customer.customer_id', $customer_id)->execute()->as_array();

			$this->arrResult['arrForm'] = array();
			if( 0 < count($arrCustomer)) {
				$this->arrResult['arrForm'] = $arrCustomer[0];
				$this->arrResult['arrForm']['password'] = "";
				$this->arrResult['arrForm']['reminder_answer'] = "";
			}
		}

		$psql = "SELECT * FROM dtb_point_log where order_id = 0 and status = 9 and del_id = 0 and customer_id = ".$customer_id;
        $query = DB::query($psql);
        $arrPointRet = $query->execute()->as_array();

		foreach($arrPointRet as $p)
		{
			$arrTemp = array();
			$psql = "SELECT count(*) as cnt FROM dtb_temp_point where customer_id = '{$customer_id}' and point = '{$p['point']}' and create_date = '{$p['create_date']}' and order_id = 0";
	        $query = DB::query($psql);
	        $arrTemp = $query->execute()->as_array();
	        
	        if (count($arrTemp) > 0 && $arrTemp[0]['cnt'] == 0)
	        {
				$psql = "update dtb_point_log set del_id = 1 where customer_id = '{$customer_id}' and point = '{$p['point']}' and create_date = '{$p['create_date']}' and order_id = 0 and status = 9";
		        $query = DB::query($psql)->execute();
	        }
		}

		// ポイントログ履歴取得
		$this->arrResult['arrPointHistory'] = DB::select('dtb_point_log.*', array('mtb_point_status.name', 'status_name'))->from('dtb_point_log')
			->join('mtb_point_status', 'left')->on('dtb_point_log.status', '=', 'mtb_point_status.id')
			->where('customer_id', $customer_id)->order_by('create_date', 'desc')->execute()->as_array();

		$retPoint = DB::select(array(DB::expr('sum(point)'), 'point'))->from('dtb_point_log')->where('customer_id', $customer_id)->where('status', POINT_LOG_ISSUE)->execute()->as_array();
		if( $retPoint[0]['point'] != "" ) {
			$tempPoint = intVal($retPoint[0]['point']);
		} else {
			$tempPoint = 0;
		}

		$retPoint = DB::select(array(DB::expr('sum(point)'), 'point'))->from('dtb_point_log')->where('customer_id', $customer_id)->where('status', POINT_LOG_ENABLE)->execute()->as_array();
		if( $retPoint[0]['point'] != "" ) {
			$tempPointAct = intVal($retPoint[0]['point']);
		} else {
			$tempPointAct = 0;
		}
		$this->arrResult['tempPoint'] = $tempPoint - $tempPointAct;


		// 購入履歴一覧
		$post_per_page = Input::post('search_page_max', 10);
		$page = Input::post('search_page', 1);
		$offset = ($page -1) * $post_per_page;

		$sql  = "SELECT SQL_CALC_FOUND_ROWS t1.* ";
		$sql .= ",t2.name AS payment_name ";
		$sql .= " FROM dtb_order AS t1 ";
		$sql .= " LEFT JOIN mtb_payment AS t2 ON t1.payment_id = t2.id ";
		$sql .= " WHERE t1.customer_id = ".$customer_id;
		$sql .= " ORDER BY t1.create_date DESC ";
		$sql .= " LIMIT ".$offset.", ".$post_per_page;

		$query = DB::query($sql);
		$arrRet = $query->execute()->as_array();

		$query2 = DB::query("SELECT FOUND_ROWS()");
		$arrRet2 = $query2->execute()->as_array();
		$maxCount = $arrRet2[0]['FOUND_ROWS()'];

		$this->arrResult['arrPurchaseHistory'] = $arrRet;
		$this->arrResult["recordNum"] = count($arrRet);
		$this->arrResult["maxRecordNum"] = $maxCount;
		$this->arrResult["pageNum"] = $page;
		$this->arrResult["maxPageNum"] = ceil($maxCount/$post_per_page);

		$y = date('Y') - 1;
		$format = $y.'-m-d 00:00:00';
		$before = date($format, strtotime($arrCustomer[0]['create_date']));
		$after = date('Y-m-d 00:00:00', strtotime($before." +1 year"));
		
		if (date('Ymd',strtotime($after)) < date('Ymd'))
		{
			$y = date('Y');
			$format = $y.'-m-d 00:00:00';
			$before = date($format, strtotime($arrCustomer[0]['create_date']));
			$after = date('Y-m-d 00:00:00', strtotime($before." +1 year"));
		}
		
//var_dump(date('Ymd',strtotime($format)));
$prev_before = date('Y-m-d 00:00:00', strtotime($before." -1 year"));
//var_dump($prev_before);
//var_dump($before);
		$this->arrResult['payment_total_prev'] = DB::query("select SUM(payment_total) as total from (select SUM(payment_total) as payment_total,customer_id from dtb_order where ((status = 5 || status = 9 || status = 17) and del_flg = 0) and create_date >= '{$prev_before}' and create_date <= '{$before}' group by customer_id union all select SUM(payment_total) as payment_total,customer_id from dtb_history_order where ((status = 5 || status = 9 || status = 17) and del_flg = 0) and create_date >= '{$prev_before}' and create_date <= '{$before}' group by customer_id) as A where customer_id = ".$customer_id)->execute()->as_array();
//var_dump($this->arrResult['payment_total_prev']);
//		$before = $arrCustomer[0]['create_date'];
		$this->arrResult['payment_total'] = DB::query("select SUM(payment_total) as total from (select SUM(payment_total) as payment_total,customer_id from dtb_order where ((status = 5 || status = 9 || status = 17) and del_flg = 0) and create_date >= '{$before}' and create_date <= '{$after}' group by customer_id union all select SUM(payment_total) as payment_total,customer_id from dtb_history_order where ((status = 5 || status = 9 || status = 17) and del_flg = 0) and create_date >= '{$prev_before}' and create_date <= '{$before}' group by customer_id) as A where customer_id = ".$customer_id)->execute()->as_array();
//		$this->arrResult['payment_total_update'] = date('次回ランク更新　m/d', strtotime($after." +1 month +1 day"));
		$this->arrResult['payment_total_update'] = date('次回ランク更新　m/d', strtotime($after." +30 day"));
		$this->tpl = 'smarty/admin/customer/edit.tpl';
		return $this->view;
	}


	/**
	 * 顧客情報入力チェック～確認画面
	 */
	public function action_confirm()
	{

		$this->arrResult["arrSearch"] = Input::post();

		$mode = Input::post('mode');
		$customer_id = Input::post('customer_id');

		if (!$this->doValidToken())
		{
		 	return Response::redirect('/admin/error', 'location', 301);
		}

		$val = Validation::forge();
		$val->add_callable('Brvalidate');
		$val->add('customer_id', '会員ID')->add_rule('required');
		$val->add('status', '会員状態')->add_rule('required');
		$val->add('rank_name', '会員ランク');
		$val->add('point_rate', 'ポイントレート');
		$val->add('sale_status', 'セール対象');
		$val->add('name01', 'お名前（姓）')->add_rule('required');
		$val->add('name02', 'お名前（名）')->add_rule('required');
		$val->add('kana01', 'フリガナ（セイ）')->add_rule('required')->add_rule('kana_only');
		$val->add('kana02', 'フリガナ（メイ）')->add_rule('required')->add_rule('kana_only');
		$val->add('company', '会社名');
		$val->add('department', '部署名');
		$val->add('last_buy_date', '最終購入日');
		$val->add('zip01', '郵便番号1')->add_rule('required')->add_rule('exact_length', 3)->add_rule('number_only');
		$val->add('zip02', '郵便番号2')->add_rule('required')->add_rule('exact_length', 4)->add_rule('number_only');
		$val->add('pref', '都道府県')->add_rule('required_select');
		$val->add('addr01', '市区町村・番地')->add_rule('required');
		$val->add('addr02', 'ビル/マンション名・部屋番号');
		$val->add('tel01', '電話番号')->add_rule('required')->add_rule('number_only');
		if( Input::post('email') == Input::post('email_before') ) {
			$val->add('email', 'メールアドレス');
		} else {
			$val->add('email', 'メールアドレス')->add_rule('required')->add_rule('valid_email')->add_rule('customer_unique_email');
		}
		$val->add('email_before', '変更前メールアドレス');
		$val->add('sex', '性別')->add_rule('required_select');
		$val->add('year', '生年月日（年）')->add_rule('required');
		$val->add('month', '生年月日（月）')->add_rule('required');
		$val->add('day', '生年月日（日）')->add_rule('required');
		if( Input::post('password') == "" ) {
			$val->add('password', 'パスワード');
			$val->add('password2', 'パスワード（確認用）');
		} else {
			$val->add('password', 'パスワード')->add_rule('required')->add_rule('min_length', 8)->add_rule('ipass');
			$val->add('password2', 'パスワード（確認用）')->add_rule('required')->add_rule('min_length', 8)->add_rule('ipass')->add_rule('match_field','password');
		}
		$val->add('reminder', '質問')->add_rule('required_select');
		if( Input::post('reminder_answer') == "" ) {
			$val->add('reminder_answer', '質問の答え');
		} else {
			$val->add('reminder_answer', '質問の答え')->add_rule('required');
		}
		$val->add('mailmaga_flg', 'メールマガジン購読')->add_rule('required_select');
		$val->add('note', 'SHOP用メモ');
		$val->add('point', '所持ポイント')->add_rule('required')->add_rule('number_only');
		$val->add('oldpoint', '変更前所持ポイント')->add_rule('required');

		$this->arrResult["arrError"] = array();

		if( $val->run()) {
			// バリデーションエラーなし
			$this->tpl = 'smarty/admin/customer/edit_confirm.tpl';

		} else {
			// バリデーションエラーあり
			$errors = $val->error();
//			var_dump($errors);
//			exit;

			$arrError = array();
			foreach($errors as $f => $error )
			{
				$arrError[$f] = $error->get_message();
			}
//var_dump($arrError);
			$this->arrResult["arrError"] = $arrError;


			// ポイントログ履歴取得
			$this->arrResult['arrPointHistory'] = DB::select('dtb_point_log.*', array('mtb_point_status.name', 'status_name'))->from('dtb_point_log')
				->join('mtb_point_status', 'left')->on('dtb_point_log.status', '=', 'mtb_point_status.id')
				->where('customer_id', $customer_id)->order_by('create_date', 'desc')->execute()->as_array();

			$retPoint = DB::select(array(DB::expr('sum(point)'), 'point'))->from('dtb_point_log')->where('customer_id', $customer_id)->where('status', POINT_LOG_ISSUE)->execute()->as_array();
			if( $retPoint[0]['point'] != "" ) {
				$tempPoint = intVal($retPoint[0]['point']);
			} else {
				$tempPoint = 0;
			}

			$retPoint = DB::select(array(DB::expr('sum(point)'), 'point'))->from('dtb_point_log')->where('customer_id', $customer_id)->where('status', POINT_LOG_ENABLE)->execute()->as_array();
			if( $retPoint[0]['point'] != "" ) {
				$tempPointAct = intVal($retPoint[0]['point']);
			} else {
				$tempPointAct = 0;
			}
			$this->arrResult['tempPoint'] = $tempPoint - $tempPointAct;


			// 購入履歴一覧
			$post_per_page = Input::post('search_page_max', 10);
			$page = Input::post('search_page', 1);
			$offset = ($page -1) * $post_per_page;

			$sql  = "SELECT SQL_CALC_FOUND_ROWS t1.* ";
			$sql .= ",t2.name AS payment_name ";
			$sql .= " FROM dtb_order AS t1 ";
			$sql .= " LEFT JOIN mtb_payment AS t2 ON t1.payment_id = t2.id ";
			$sql .= " WHERE t1.customer_id = ".$customer_id;
			$sql .= " ORDER BY t1.create_date DESC ";
			$sql .= " LIMIT ".$offset.", ".$post_per_page;

			$query = DB::query($sql);
			$arrRet = $query->execute()->as_array();

			$query2 = DB::query("SELECT FOUND_ROWS()");
			$arrRet2 = $query2->execute()->as_array();
			$maxCount = $arrRet2[0]['FOUND_ROWS()'];

			$this->arrResult['arrPurchaseHistory'] = $arrRet;
			$this->arrResult["recordNum"] = count($arrRet);
			$this->arrResult["maxRecordNum"] = $maxCount;
			$this->arrResult["pageNum"] = $page;
			$this->arrResult["maxPageNum"] = ceil($maxCount/$post_per_page);

			$this->tpl = 'smarty/admin/customer/edit.tpl';
		}

		$this->arrResult["arrForm"] = $val->input();

		return $this->view;
	}



	/**
	 * 顧客情報DB更新～完了画面
	 */
	public function action_complete()
	{

		$this->arrResult["arrSearch"] = Input::post();

		$mode = Input::post('mode');
		$customer_id = Input::post('customer_id');

		if (!$this->doValidToken())
		{
			return Response::redirect('/admin/error', 'location', 301);
		}

		try {
			$objCustomer = new Tag_customerctrl();

			// トランザクション開始
			DB::start_transaction();

			// dtb_customer
			$arrUpdate = array();
			$arrUpdate['status'] = Input::post('status');
			$arrUpdate['name01'] = Input::post('name01');
			$arrUpdate['name02'] = Input::post('name02');
			$arrUpdate['kana01'] = Input::post('kana01');
			$arrUpdate['kana02'] = Input::post('kana02');
			$arrUpdate['company'] = Input::post('company');
			$arrUpdate['department'] = Input::post('department');
			$arrUpdate['last_buy_date'] = Input::post('last_buy_date');
			if ($arrUpdate['last_buy_date'] == '')
				unset($arrUpdate['last_buy_date']);
			$arrUpdate['zip01'] = Input::post('zip01');
			$arrUpdate['zip02'] = Input::post('zip02');
			$arrUpdate['pref'] = Input::post('pref');
			$arrUpdate['addr01'] = Input::post('addr01');
			$arrUpdate['addr02'] = Input::post('addr02');
			$arrUpdate['tel01'] = Input::post('tel01');
			$arrUpdate['email'] = Input::post('email');
			$arrUpdate['sex'] = Input::post('sex');
			$arrUpdate['sale_status'] = Input::post('sale_status');
			$arrUpdate['birth'] = Input::post('year').'/'.Input::post('month').'/'.Input::post('day');
			$arrUpdate['reminder'] = Input::post('reminder');
			$arrUpdate['customer_rank'] = Input::post('rank_name');
			//$arrUpdate['reminder_answer'] = Input::post('reminder_answer');

			if(  Input::post('reminder_answer') != "" ) {
				$sql  = "SELECT salt FROM dtb_customer WHERE customer_id = ".$customer_id;
				$query = DB::query($sql);
				$arrRet = $query->execute()->as_array();
				$salt = $arrRet[0]['salt'];

				$arrUpdate['reminder_answer'] = $objCustomer->sfGetHashString(Input::post('reminder_answer'), $salt);
			}

			$arrUpdate['mailmaga_flg'] = Input::post('mailmaga_flg');
			$arrUpdate['note'] = Input::post('note');
			$arrUpdate['update_date'] = date('Y-m-d H:i:s');

			if(  Input::post('password') != "" ) {
				$secret_key = "";
				do {
					$secret_key = $objCustomer->gfMakePassword(8);
					$exists = DB::select()->from('dtb_customer')->where('secret_key', $secret_key)->where('del_flg', 0)->execute()->as_array();
				} while ($exists);

				$salt = $objCustomer->gfMakePassword(10);
				$password = $objCustomer->sfGetHashString(Input::post('password'), $salt);

				$arrUpdate['salt'] = $salt;
				$arrUpdate['secret_key'] = $secret_key;
				$arrUpdate['password'] = $password;
				$arrUpdate['reminder_answer'] = $objCustomer->sfGetHashString(Input::post('reminder_answer'), $salt);
			}

			// アップデート
			$objUpdate = DB::update('dtb_customer');

			foreach ( $arrUpdate as $col => $val ) {
				$objUpdate->value( $col, $val );
			}
			$result = $objUpdate->where('customer_id', $customer_id)->execute();
			if( $result == 0){
				//throw new Exception("登録に失敗しました。");
			}


			// dtb_point
			$arrUpdate2 = array();
			$arrUpdate2['point_flg'] = Input::post('point_flg');
			$arrUpdate2['point_rate'] = Input::post('point_rate');
			$arrUpdate2['point'] = Input::post('point');

			$objUpdate2 = DB::update('dtb_point');

			foreach ( $arrUpdate2 as $col => $val ) {
				$objUpdate2->value( $col, $val );
			}
			$result2 = $objUpdate2->where('customer_id', $customer_id)->execute();
			if( $result2 == 0){
				//throw new Exception("登録に失敗しました。");
			}


			// dtb_point_log
			$addLogPoint = intVal(Input::post('point')) - intVal(Input::post('oldpoint'));
			if( Input::post('point') < Input::post('oldpoint')) {
				$addLogStatus = POINT_LOG_SUB;
			} else if( Input::post('point') > Input::post('oldpoint')) {
				$addLogStatus = POINT_LOG_ADD;
			}

			if( $addLogPoint != 0) {
				$arrInsert = array();
				$arrInsert['customer_id'] = $customer_id;
				$arrInsert['point'] = $addLogPoint;
				$arrInsert['status'] = $addLogStatus;
				$arrInsert['create_date'] = date('Y-m-d H:i:s');
				$arrInsert['order_id'] = 0;

				$result3 = DB::insert('dtb_point_log')->set($arrInsert)->execute();

				if( $result3[1] == 0){
					//throw new Exception("登録に失敗しました。");
				}
			}


			DB::commit_transaction();
			$this->arrResult['msg'] = "登録が完了致しました。";

		} catch ( Exception $e ) {
			DB::rollback_transaction();
			//$this->arrResult['msg'] = $e->getMessage();
			$this->arrResult['msg'] = "登録に失敗しました。";
		}

		$this->tpl = 'smarty/admin/customer/edit_complete.tpl';

		return $this->view;
	}


	/**
	 * 顧客情報削除
	 */
	public function action_delete()
	{

		$this->arrResult["arrSearch"] = Input::post();

		$mode = Input::post('mode');
		$customer_id = Input::post('customer_id');

		if (!$this->doValidToken())
		{
			return Response::redirect('/admin/error', 'location', 301);
		}

		// アップデート
		$result = DB::update('dtb_customer')->value('del_flg', 1)->value('update_date', date('Y-m-d H:i:s'))->where('customer_id', $customer_id)->execute();

		if( 0 < $result ){
			$this->arrResult['msg'] = "削除が完了致しました。";
		} else {
			$this->arrResult['msg'] = "削除に失敗しました。";
		}

		$this->tpl = 'smarty/admin/customer/edit_complete.tpl';

		return $this->view;
	}


	/**
	 * 仮登録メール再送
	 */
	public function action_resendmail()
	{

		$this->arrResult["arrSearch"] = Input::post();

		$mode = Input::post('mode');
		$customer_id = Input::post('customer_id');

		if (!$this->doValidToken())
		{
			return Response::redirect('/admin/error', 'location', 301);
		}

		$arrCustomer = DB::select()->from('dtb_customer')->where('customer_id', $customer_id)->execute()->as_array();
		if( 0 < count($arrCustomer)) {

			// メール送信
			$tpl = 'smarty/email/signup_temp_menber.tpl';
			$arrResult["arrForm"] = $arrCustomer[0];
			$arrResult['registurl'] = (empty($_SERVER["HTTPS"]) ? "http://" : "https://").'www.bronline.jp'."/signup/complete?id=".$arrResult["arrForm"]['customer_id']."&sk=".$arrResult["arrForm"]['secret_key'];

			try {
				$email = Email::forge();
				$email->header('Content-Transfer-Encoding', 'base64');
				$email->from(CUSTOMER_TEMP_MAIL_FROM);
				$email->to($arrResult["arrForm"]['email']);
				$email->subject(CUSTOMER_TEMP_MAIL_TITLE);
				$email->body(\View_Smarty::forge( $tpl, $arrResult, false));

				$history = array();
				$history['order_id'] = 0;
				$emails = $email->get_to();
				$tos = array();
				foreach($emails as $k=>$m)
				{
					$tos[] = $k;
				}
				$history['to_email'] = implode(',', $tos);
				$history['subject'] = $email->get_subject();
				$history['body'] = $email->get_body();
				$query = DB::insert('dtb_mail_history');
				$query->set($history);
				$query->execute();

				$email->send();

				$this->arrResult['msg'] = "メール送信が完了致しました。";
			} catch( Exception $e ) {
				$this->arrResult['msg'] = "メール送信に失敗しました。";
			}
		} else {
			$this->arrResult['msg'] = "顧客情報が取得できませんでした。";
		}

		$this->tpl = 'smarty/admin/customer/edit_complete.tpl';

		return $this->view;
	}


	/**
	 * 会員状態一括変更
	 */
	public function action_changestatus()
	{

		$this->arrResult["arrSearch"] = Input::post();

		$mode = Input::post('mode');
		$arrCustomer_id = Input::post('change_customer_id');
		$status_change = Input::post('status_change');

		if (!$this->doValidToken())
		{
			return Response::redirect('/admin/error', 'location', 301);
		}

		try {
			foreach ( $arrCustomer_id as $customer_id ) {
				$result = DB::update('dtb_customer')->value('status', $status_change)->value('update_date', date('Y-m-d H:i:s'))->where('customer_id', $customer_id)->execute();
			}
			$this->arrResult['msg'] = "会員状態の一括変更が完了いたしました。";
		} catch( Exception $e ) {
			$this->arrResult['msg'] = "会員状態の一括変更に失敗しました。";
		}

		$this->tpl = 'smarty/admin/customer/edit_complete.tpl';

		return $this->view;
	}


	function action_uploadsale()
	{

		$this->tpl = 'smarty/admin/customer/upload_sale.tpl';
		return $this->view;
	}

	function post_uploadsale()
	{
		$file_tmp  = $_FILES["csv_file"]["tmp_name"];
		ini_set('memory_limit', '2048M');
		ini_set('auto_detect_line_endings', true);
		$shop = $_SESSION['shop_id'];
		if ($shop == '')
			return;

		$csv = array();

//		$file = fopen($file_tmp, 'r');
		$buffer = mb_convert_encoding(file_get_contents($file_tmp), "UTF-8", "sjis-win");
		$file = tmpfile();
		fwrite($file, $buffer);
		rewind($file);

		$cnt = 0;
		$csv_key = array();

		while (($data = fgetcsv($file, 0, ",")) !== FALSE)
		{
			//htmlタグが文字化けするのでHTML エンティティに変換
			//表示する時にHTML エンティティのデコードする
			if ($cnt == 0)
			{
				$csv_key = $data;
				//var_dump($csv_key);
				$cnt++;
			}
			else
			{
				//$data = implode(",", $data);
//				$temp[] = htmlentities($data);
//				var_dump($data);

				$csv_temp = array();
//var_dump($data);
				foreach($data as $k=>$v)
				{
//var_dump($csv_key[$k]."::".$v);
					$csv_temp[$csv_key[$k]] = $v;//mb_convert_encoding($v, 'UTF-8', 'sjis-win');
				}
				$csv[] = $csv_temp;
				$cnt++;
			}
		}
		fclose($file);
//print("</pre>");
//exit;
		$keys = array('customer_id', 'sale_status');
		if (count($csv_key) != count($keys))
		{
 			$this->arrResult['error'] = "項目数に違いがあります。".count($keys).'の項目が必要です。';
 			$this->tpl = 'smarty/admin/customer/upload_sale.tpl';
 			return $this->view;
		}
		$cnt = 1;
		$result = array();
//var_dump($shop);
//exit;
		foreach($csv as $c)
		{
			$cnt++;
			$ret = DB::update('dtb_customer')->value('sale_status', $c['sale_status'])->where('customer_id', $c['customer_id'])->execute();
			if ($ret)
				$result[] = $cnt."行目　会員ID: ".$c['customer_id']." 更新しました。";
			else
				$result[] = $cnt."行目　会員ID: ".$c['customer_id']." 更新失敗しました。";
		}
		$this->arrResult['error'] = "処理が完了しました。";
		$this->arrResult['csv_result'] = array();
		$this->arrResult['csv_result'] = $result;
//var_dump($result);
		$this->tpl = 'smarty/admin/customer/upload_sale.tpl';
		return $this->view;
	}



	/**
	 * The 404 action for the application.
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_404()
	{
		return Response::forge(Presenter::forge('home/404'), 404);
//        return View_Smarty::forge('smarty/404.tpl');
//		return Response::forge(Presenter::forge('home/404'), 404);
	}

}
