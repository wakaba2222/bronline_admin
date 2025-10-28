<?php
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
 
 
class Controller_Admin_Pdf extends ControllerAdmin
{
	public function get_index()
	{
		$order_id = Input::param('order_id', 0);
		$type = Input::param('type', 0);
		$arrForm = array();
		$arrForm['pdf_order_id'] = Input::param('pdf_order_id');
		if ($arrForm['pdf_order_id'] == null)
			$arrForm['pdf_order_id'] = array();
		$arrForm['order_id'] = $order_id;
// 		var_dump($arrForm);
// 		exit;
		
		$this->arrResult['arrForm'] = $arrForm;
//		var_dump($this->arrResult['arrForm']);
//var_dump($_GET);
//var_dump($_POST);
//var_dump($type);

		if ($type == 0)
			$this->tpl = 'smarty/admin/order/pdf_input.tpl';
		else if ($type == 1)
			$this->tpl = 'smarty/admin/order/order_input.tpl';
		else if ($type == 2)
			$this->tpl = 'smarty/admin/order/receipt_input.tpl';

		return $this->view;
	}

	public function action_test()
	{
		Package::load('pdf');
		$pdf = Pdf::factory('tcpdf')->init("P", "mm", "A4", true, "UTF-8");
		$pdf->setFontSubsetting(true);
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
 		$pdf->AddPage();
  		$order_id = 1;
  		$pdf->Output( date('Y-m-d').$order_id.'.pdf', 'I' );
// 		$name = 'aaa';
// 		$view = new View;
// 		$view->bind('name', $name, false);
// 		$text = $view->render('home/nouhinsho');
// 		$pdf->SetFont("ipagp", "", 10);
// $style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => '10,20,5,10', 'phase' => 10, 'color' => array(0, 0, 0));
// $style2 = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
// $style3 = array('width' => 1, 'cap' => 'round', 'join' => 'round', 'dash' => '2,10', 'color' => array(255, 0, 0));
// $pdf->Line(5, 10, 205, 10, $style2);
// $pdf->Line(205, 10, 205, 20, $style2);
// $pdf->Line(205, 20, 5, 20, $style2);
// $pdf->Line(5, 20, 5, 10, $style2);
// $pdf->SetFont("ipagp", "", 15);
// $title = 'テスト';
// $pdf->Text(95, 12, $title);
// $pdf->SetFont("ipagp", "", 10);
//  		$pdf->Output( date('Y-m-d').$order_id.'.pdf', 'I' );
		$this->tpl = 'smarty/test.tpl';
			return $this->view;
	}
	public function post_index()
	{
		$post = Input::param();

		$arrForm = array();
		$type = Input::param('type', 0);
		if ($post['mode'] == 'pdf')
		{
			if ($type == 1)
				$this->tpl = 'smarty/admin/order/order_input.tpl';
			else if ($type == 2)
				$this->tpl = 'smarty/admin/order/receipt_input.tpl';
			else
				$this->tpl = 'smarty/admin/order/pdf_input.tpl';
			$arrForm['pdf_order_id'] = Input::param('pdf_order_id');
			$order_id = Input::param('order_id', 0);
			$arrForm['order_id'] = $order_id;
			$this->arrResult['arrForm'] = $arrForm;
			return $this->view;
		}
		
		if ($type == 0)
			$this->f_deliv($post);
		else if ($type == 1)
			$this->f_order($post);
		else if ($type == 2)
			$this->f_receipt($post);
		$this->tpl = 'smarty/pdf.tpl';

		return $this->view;
	}

	public function f_order($post)
	{
// 		var_dump($post['pdf_order_id']);
		if (!isset($post['pdf_order_id']))
		{
			$post['pdf_order_id'] = array();
			$post['pdf_order_id'][] = $post['order_id'];
		}
		$this->tpl = 'smarty/pdf.tpl';
		
		Package::load('pdf');
		$pdf = Pdf::factory('tcpdf')->init("P", "mm", "A4", true, "UTF-8");
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->setFooterMargin(0);
		$pdf->SetAutoPageBreak(TRUE, 0);

		$title = Input::param('title', '注文書');
		if ($title == '')
			$title = '注文書';

		foreach($post['pdf_order_id'] as $order_id)
		{
			if ($order_id == 0 || $order_id == '')
				continue;
	
			$arrOrder = Tag_Order::get_order_info($order_id);
			if (count($arrOrder) > 0)
			{
				$arrOrder = $arrOrder[0];
				if ($arrOrder['status'] == '3')
					continue;
			}
			else
				return $this->view;
			
			$arrOrderDeliv = array();
			$rank = '';
			$sale_status = -1;
			if ($arrOrder['customer_id'] == '0')
			{
				$arrOrderDeliv = Tag_Order::get_order_deliv2($order_id,true,true);
			}
			else
			{
				$rank = '';
				$arrOrderDeliv = DB::select()->from('dtb_customer')->where('customer_id', $arrOrder['customer_id'])->where('del_flg', 0)->where('status', 2)->execute()->as_array();
				if (count($arrOrderDeliv) > 0)
				{
					$rank_id = $arrOrderDeliv[0]['customer_rank'];
					$rank = DB::select('name')->from('mtb_customer_rank')->where('id', $rank_id)->execute()->as_array();
					if (count($rank) > 0)
					{
						$rank = strtoupper($rank[0]['name']);
					}
					$sale_status = $arrOrderDeliv[0]['sale_status'];

				}
			}
			
			if (count($arrOrderDeliv) == 1)
			{
				$arrOrderDeliv = $arrOrderDeliv[0];
			}

			$arrDeliv = Tag_Order::get_order_deliv2($order_id);
			if (count($arrDeliv) >= 1)
			{
				$arrTempDeliv = null;
				foreach($arrDeliv as $deliv)
				{
					if ($deliv['customer_id'] == '0')
					{
						if ($deliv['email'] == '')
						{
							$arrTempDeliv = $deliv;
							break;
						}
					}
				}
//print("<pre>");
//var_dump($arrDeliv);
//var_dump(count($arrDeliv));
//print("</pre>");
				if ($arrTempDeliv == null)
				{
					$arrDeliv = $arrDeliv[0];
				}
				else
				{
					$arrDeliv = $arrTempDeliv;
				}
//exit;
			}
			else if (count($arrDeliv) > 0)
			{
				$arrDeliv = $arrDeliv[0];
			}
			else
				return $this->view;

			$arrDetail = Tag_Order::get_order_detail($order_id);
			$pdf->AddPage();
	
//			$style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => '10,20,5,10', 'phase' => 10, 'color' => array(0, 0, 0));
//			$style2 = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
//			$style3 = array('width' => 1, 'cap' => 'round', 'join' => 'round', 'dash' => '2,10', 'color' => array(255, 0, 0));
//			$pdf->Line(5, 10, 205, 10, $style2);
//			$pdf->Line(205, 10, 205, 20, $style2);
//			$pdf->Line(205, 20, 5, 20, $style2);
//			$pdf->Line(5, 20, 5, 10, $style2);
//			$pdf->SetFont("ipagp", "", 15);
//			//$pdf->Text(95, 12, $title);
//			$pdf->SetXY( 5, 11 );
//			$pdf->Cell(200,8, Tag_Util::normalizeUtf8MacFileName($title), 0, 0, 'C', 0);
//			$pdf->SetFont("ipagp", "", 10);
//var_dump($arrOrder);			
//exit;
			$name = $arrOrderDeliv['name01'].' '.$arrOrderDeliv['name02'];
			$kananame = $arrOrderDeliv['kana01'].' '.$arrOrderDeliv['kana02'];
			$email = $arrOrderDeliv['email'];

			if (count($arrDeliv) > 0)
			{
				$deliv_name = $arrDeliv['name01'].' '.$arrDeliv['name02'].' 様';
//				$kananame = $arrDeliv['kana01'].' '.$arrDeliv['kana02'];
				if($arrDeliv['email'] != '')
					$email = $arrDeliv['email'];
			}
			else
			{
				$deliv_name = $name.' 様';
			}

			$now = date('Y/m/d H:i');

			$pdf->SetFont("ipagp", "", 11);
			$pdf->Text(10, 5, Tag_Util::normalizeUtf8MacFileName($name.' ('.$kananame.')'.' 様 '.$email));
//			$pdf->Text(160, 5, Tag_Util::normalizeUtf8MacFileName($now));
			$pdf->Text(160, 5, Tag_Util::normalizeUtf8MacFileName($arrOrder['create_date']));

			$pdf->SetXY( 10, 15 );
			$pdf->SetFont("ipagp", "", 10);

			$html = "<style>";
			$html .= "table.border { margin: 20px 0; padding:20px 0; } ";
			$html .= "table.border th { width:20%; background-color:#ddd; padding:10px; text-align:left; border: 1px solid #ccc; } ";
			$html .= "table.border td { width:80%; border: 1px solid #fff;padding:10px; } ";
			$html .= "table.border2 { margin: 20px 0; padding:20px 0; } ";
			$html .= "table.border2 th { width:20%; background-color:#ddd; padding:10px; text-align:left; border: 1px solid #eee; } ";
			$html .= "table.border2 td { width:80%; border: 1px solid #eee;padding:10px; } ";
			$html .= "table.border3 { margin: 20px 0; padding:20px 0; } ";
			$html .= "table.border3 th { width:15%; background-color:#ddd; padding:10px; text-align:left; border: 1px solid #eee; } ";
			$html .= "table.border3 td { width:35%; border: 1px solid #eee;padding:10px; } ";
			$html .= "</style>";

			$html .= '<table cellpadding="2" class="border" style="padding-top:20px;">';

			$html .= '<tr>';
			$html .= '<th>注文番号</th>';
			$html .= '<td>';
			$html .= $arrOrder['order_id'];
			$html .= '</td>';
			$html .= '</tr>';

//			$html .= '<tr>';
//			$html .= '<th>注文日時</th>';
//			$html .= '<td>';
//			$html .= $arrOrder['create_date'];
//			$html .= '</td>';
//			$html .= '</tr>';

			$html .= '<tr>';
			$html .= '<th>合計金額</th>';
			$html .= '<td>';
			$html .= '￥'.number_format($arrOrder['payment_total']);
			$html .= '</td>';
			$html .= '</tr>';

			$html .= '<tr>';
			$html .= '<th>決済方法</th>';
			$html .= '<td>';
			$html .= $this->arrResult['arrPayments'][$arrOrder['payment_id']];
			$html .= '</td>';
			$html .= '</tr>';

			$html .= '<tr>';
			$html .= '<th>注文備考</th>';
			$html .= '<td>';
			$html .= $arrOrder['memo'];
			$html .= '</td>';
			$html .= '</tr>';

			$html .= "</table><div style='font-size:6pt;height:10px;'></div>";

			//注文情報
//			$html .= '<table cellpadding="2" class="border">';
//
//			$html .= '<tr>';
//			$html .= '<th>注文番号</th>';
//			$html .= '<td>';
//			$html .= $arrOrder['order_id'];
//			$html .= '</td>';
//			$html .= '</tr>';
//
//			$html .= '<tr>';
//			$html .= '<th>合計金額</th>';
//			$html .= '<td>';
//			$html .= '￥'.number_format($arrOrder['payment_total']);
//			$html .= '</td>';
//			$html .= '</tr>';
//
//			$html .= '<tr>';
//			$html .= '<th>決済方法</th>';
//			$html .= '<td>';
//			$html .= $this->arrResult['arrPayments'][$arrOrder['payment_id']];
//			$html .= '</td>';
//			$html .= '</tr>';
//
//			$html .= '<tr>';
//			$html .= '<th>注文備考</th>';
//			$html .= '<td>';
//			$html .= $arrOrder['memo'];
//			$html .= '</td>';
//			$html .= '</tr>';
//
//			$html .= "</table><p></p>";

			//配送先
			$html .= '<table cellpadding="2" class="border">';

			$html .= '<tr>';
			$html .= '<th>配送先名前</th>';
			$html .= '<td>';
			$html .= $deliv_name;
			$html .= '</td>';
			$html .= '</tr>';

			$html .= '<tr>';
			$html .= '<th>電話番号</th>';
			$html .= '<td>';
			$html .= $arrDeliv['tel01'];
			$html .= '</td>';
			$html .= '</tr>';

			$html .= '<tr>';
			$html .= '<th>郵便番号</th>';
			$html .= '<td>';
			$html .= $arrDeliv['zip01'].'-'.$arrDeliv['zip02'];
			$html .= '</td>';
			$html .= '</tr>';

			$html .= '<tr>';
			$html .= '<th>住所</th>';
			$html .= '<td>';
			if ($arrDeliv['pref'] != '0')
			{
				$pref = $this->arrResult['arrPref'][$arrDeliv['pref']];
				$pref = $pref. $arrDeliv['addr01'].$arrDeliv['addr02'];
				$html .= $pref;
			}
			else
			{
				$pref = $arrDeliv['addr01'].$arrDeliv['addr02'];
				$html .= $pref;
			}
			$html .= '</td>';
			$html .= '</tr>';

			$html .= '<tr>';
			$html .= '<th>配送日</th>';
			$html .= '<td>';
			if ($arrOrder['deliv_date'] != '')
				$html .= date('m月d日', strtotime($arrOrder['deliv_date']));
			else
				$html .= '';
			$html .= '</td>';
			$html .= '</tr>';

			$html .= '<tr>';
			$html .= '<th>配送時間帯</th>';
			$html .= '<td>';
			$html .= $arrOrder['deliv_time'];
			$html .= '</td>';
			$html .= '</tr>';

			$html .= "</table><div style='font-size:6pt;height:10px;'></div>";

			//その他項目
			$html .= '<table cellpadding="2" class="border3">';

			$html .= '<tr>';
			$html .= '<th>明細書</th>';
			$html .= '<td>';
			$html .= ($arrOrder['detail_statement'] != '0')?'あり':'';
			$html .= '</td>';
			$html .= '<th>簡易包装</th>';
			$html .= '<td>';
			$html .= ($arrOrder['packing'] != '0')?'ダンボール箱を希望する':'';
			$html .= '</td>';
			$html .= '</tr>';

			$html .= '<tr>';
			$html .= '<th>領収書宛名</th>';
			$html .= '<td>';
			$html .= $arrOrder['recepit_atena'];
			$html .= '</td>';
			$html .= '<th>ラッピング</th>';
			$html .= '<td>';
			$html .= ($arrOrder['gift'] == '1')?'あり':'';
			$html .= '</td>';
			$html .= '</tr>';

			$html .= '<tr>';
			$html .= '<th>領収書但書</th>';
			$html .= '<td>';
			$html .= $arrOrder['receipt_tadashi'];
			$html .= '</td>';
			$html .= '<th>カード</th>';
			$html .= '<td>';
			$html .= ($arrOrder['card'] == '1')?'あり':'';
			$html .= '</td>';
			$html .= '</tr>';

//			$html .= '<tr>';
//			$html .= '<th>簡易包装</th>';
//			$html .= '<td>';
//			$html .= ($arrOrder['packing'] == '1')?'あり':'';
//			$html .= '</td>';
//			$html .= '</tr>';

//			$html .= '<tr>';
//			$html .= '<th>ラッピング</th>';
//			$html .= '<td>';
//			$html .= ($arrOrder['gift'] == '1')?'あり':'';
//			$html .= '</td>';
//			$html .= '</tr>';

//			$html .= '<tr>';
//			$html .= '<th>カード</th>';
//			$html .= '<td>';
//			$html .= ($arrOrder['card'] == '1')?'あり':'';
//			$html .= '</td>';
//			$html .= '</tr>';

			$html .= '<tr>';
			$html .= '<th>カード内容</th>';
			$html .= '<td>';
			$html .= $arrOrder['msg_card'];
			$html .= '</td>';
			$html .= '</tr>';

			$html .= "</table><div style='font-size:6pt;height:10px;'></div>";

			//商品
			foreach($arrDetail as $d)
			{
				$names = $d['product_name'].' / '.$d['product_code'].' / ['.$d['color_name'].' / '.$d['size_name'].']';
				$quantity = $d['quantity'];
				$price = '￥'.number_format(Tag_Util::taxin_cal($d['price']));
				$subtotal = number_format(Tag_Util::taxin_cal($d['price']*$d['quantity'])).' 円';
				$arrShop = Tag_Shop::get_shopdetail("A.login_id = '".$d['shop_id']."'");
				$shop_name = $arrShop[0]['shop_name'];
				$url = 'https://www.bronline.jp/mall/'.$d['shop_id'].'/item?detail='.$d['product_id'];

				$html .= '<table cellpadding="2" class="border2">';
				$html .= '<tr>';
				$html .= '<th>ショップ名</th>';
				$html .= '<td>';
				$html .= '['.$shop_name.']';
				$html .= '</td>';
				$html .= '</tr>';

				$html .= '<tr>';
				$html .= '<th>商品コード</th>';
				$html .= '<td>';
				$html .= $d['product_code'];
				$html .= '</td>';
				$html .= '</tr>';

				$reservation = '';
				if($d['reservation_flg'] == 1)
				{
					$reservation = '【完全受注生産】';
					$html .= '<tr>';
					$html .= '<th>セール/予約情報</th>';
					$html .= '<td>';
					$html .= $reservation;
					$html .= '</td>';
					$html .= '</tr>';
				}
				else if($d['reservation_flg'] == 2)
				{
					$reservation = '【予約商品】';
					$html .= '<tr>';
					$html .= '<th>セール/予約情報</th>';
					$html .= '<td>';
					$html .= $reservation;
					$html .= '</td>';
					$html .= '</tr>';
				}
				elseif($d['sale_status'] > 0 && $sale_status == $d['sale_status'] && $arrOrder['discount'] > 0)
				{
					$reservation = '【セール対象商品】';
					$html .= '<tr>';
					$html .= '<th>セール/予約情報</th>';
					$html .= '<td>';
					$html .= $reservation;
					$html .= '</td>';
					$html .= '</tr>';
				}

				$html .= '<tr>';
				$html .= '<th>商品名</th>';
				$html .= '<td>';
				$html .= $d['product_name'];
				$html .= '</td>';
				$html .= '</tr>';

				$html .= '<tr>';
				$html .= '<th>商品URL</th>';
				$html .= '<td>';
				$html .= $url;
				$html .= '</td>';
				$html .= '</tr>';

				$html .= '<tr>';
				$html .= '<th>カラー/サイズ</th>';
				$html .= '<td>';
				$html .= '['.$d['color_name'].' / '.$d['size_name'].']';
				$html .= '</td>';
				$html .= '</tr>';
				$html .= '<tr>';
				$html .= '<th>単価</th>';
				$html .= '<td>';
				$html .= $price;
				$html .= '</td>';
				$html .= '</tr>';
				$html .= '<tr>';
				$html .= '<th>数量</th>';
				$html .= '<td>';
				$html .= $quantity;
				$html .= '</td>';
				$html .= '</tr>';

				$html .= "</table><div style='font-size:6pt;height:10px;'></div>";
			}

			//購入情報
			$html .= '<table cellpadding="2" class="border3">';

			$html .= '<tr>';
			$html .= '<th>商品合計</th>';
			$html .= '<td>';
			$html .= '￥'.number_format(Tag_Util::taxin_cal($arrOrder['total']));
			$html .= '</td>';
			$html .= '<th>手数料</th>';
			$html .= '<td>';
			$html .= '￥'.number_format(Tag_Util::taxin_cal($arrOrder['fee']));
			$html .= '</td>';
			$html .= '</tr>';

			$html .= '<tr>';
			$html .= '<th>調整額</th>';
			$html .= '<td>';
			$html .= '￥'.number_format(($arrOrder['discount']*-1));
			$html .= '</td>';
			$html .= '<th>ラッピング</th>';
			$html .= '<td>';
			$html .= '￥'.number_format(Tag_Util::taxin_cal($arrOrder['gift_price']));
			$html .= '</td>';
			$html .= '</tr>';

			$html .= '<tr>';
			$html .= '<th>利用ポイント</th>';
			$html .= '<td>';
			$html .= number_format($arrOrder['use_point']).' pt';
			$html .= '</td>';
			$html .= '<th>請求額</th>';
			$html .= '<td>';
			$html .= '￥'.number_format($arrOrder['payment_total']);
			$html .= '</td>';
			$html .= '</tr>';

			$html .= '<tr>';
			$html .= '<th>送料</th>';
			$html .= '<td>';
			$html .= '￥'.number_format(Tag_Util::taxin_cal($arrOrder['deliv_fee']));
			$html .= '</td>';
			$html .= '<th>会員ステージ</th>';
			$html .= '<td>';
			$html .= @$rank;
			$html .= '</td>';
			$html .= '</tr>';

//			$html .= '<tr>';
//			$html .= '<th>手数料</th>';
//			$html .= '<td>';
//			$html .= '￥'.number_format(Tag_Util::taxin_cal($arrOrder['fee']));
//			$html .= '</td>';
//			$html .= '</tr>';

//			$html .= '<tr>';
//			$html .= '<th>ラッピング</th>';
//			$html .= '<td>';
//			$html .= '￥'.number_format(Tag_Util::taxin_cal($arrOrder['gift_price']));
//			$html .= '</td>';
//			$html .= '</tr>';

//			$html .= '<tr>';
//			$html .= '<th>請求額</th>';
//			$html .= '<td>';
//			$html .= '￥'.number_format($arrOrder['payment_total']);
//			$html .= '</td>';
//			$html .= '</tr>';

//			$html .= '<tr>';
//			$html .= '<th>会員ステージ</th>';
//			$html .= '<td>';
//			$html .= $rank;
//			$html .= '</td>';
//			$html .= '</tr>';

			$html .= "</table>";


			@$pdf->writeHTML($html);
		}
		$pdf->Output( date('Y-m-d').$order_id.'.pdf', 'I' );
	}

	public function f_receipt($post)
	{
// 		var_dump($post['pdf_order_id']);
		if (!isset($post['pdf_order_id']))
		{
			$post['pdf_order_id'] = array();
			$post['pdf_order_id'][] = $post['order_id'];
		}
		$this->tpl = 'smarty/pdf.tpl';
		
		Package::load('pdf');
		$pdf = Pdf::factory('tcpdf')->init("P", "mm", "A5", true, "UTF-8");
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->setFooterMargin(0);
		$pdf->SetAutoPageBreak(TRUE, 0);

		$title = Input::param('title', '領収書');
		if ($title == '')
			$title = '領収書';

		foreach($post['pdf_order_id'] as $order_id)
		{
			if ($order_id == 0 || $order_id == '')
				continue;
	
			$arrOrder = Tag_Order::get_order_info($order_id);
			if (count($arrOrder) > 0)
			{
				$arrOrder = $arrOrder[0];
				if ($arrOrder['status'] == '3')
					continue;
//				var_dump($arrOrder);
			}
			else
				return $this->view;
			$arrDeliv = Tag_Order::get_order_deliv2($order_id);
			
			
			if ($arrOrder['recepit_atena'] == '')
				continue;

			if (count($arrDeliv) == 1)
			{
				$arrDeliv = $arrDeliv[0];
			}
			else if (count($arrDeliv) > 1)
			{
				foreach($arrDeliv as $deliv)
				{
					if ($deliv['customer_id'] == '0')
					{
						if ($deliv['email'] == '')
						{
							$arrDeliv = $deliv;
							break;
						}
					}
				}
			}
			else
				return $this->view;

//			if ($arrOrder['recepit_atena'] == '')
//			{
//				$arrOrder['recepit_atena'] = $arrDeliv['name01'].' '.$arrDeliv['name02'];
//			}

			$arrDetail = Tag_Order::get_order_detail($order_id);
			$pdf->AddPage();
	
//			$style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => '10,20,5,10', 'phase' => 10, 'color' => array(0, 0, 0));
//			$style2 = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
//			$style3 = array('width' => 1, 'cap' => 'round', 'join' => 'round', 'dash' => '2,10', 'color' => array(255, 0, 0));
//			$pdf->Line(5, 10, 205, 10, $style2);
//			$pdf->Line(205, 10, 205, 20, $style2);
//			$pdf->Line(205, 20, 5, 20, $style2);
//			$pdf->Line(5, 20, 5, 10, $style2);
//			$pdf->SetFont("ipagp", "", 15);
			//$pdf->Text(95, 12, $title);
//			$pdf->SetXY( 5, 11 );
//			$pdf->Cell(200,8, Tag_Util::normalizeUtf8MacFileName($title), 0, 0, 'C', 0);
			$pdf->SetFont("ipagp", "", 10);

			$arrOrderDeliv = array();
			if ($arrOrder['customer_id'] == '0')
			{
				$arrOrderDeliv = Tag_Order::get_order_deliv2($order_id,true,true);
			}
			else
			{
				$rank = '';
				$arrOrderDeliv = DB::select()->from('dtb_customer')->where('customer_id', $arrOrder['customer_id'])->where('del_flg', 0)->where('status', 2)->execute()->as_array();
				if (count($arrOrderDeliv) > 0)
				{
					$rank_id = $arrOrderDeliv[0]['customer_rank'];
					$rank = DB::select('name')->from('mtb_customer_rank')->where('id', $rank_id)->execute()->as_array();
					if (count($rank) > 0)
					{
						$rank = strtoupper($rank[0]['name']);
					}

				}
			}
			
			if (count($arrOrderDeliv) == 1)
			{
				$arrOrderDeliv = $arrOrderDeliv[0];
			}

			$name = $arrOrderDeliv['name01'].' '.$arrOrderDeliv['name02'];

			if ((isset($arrDeliv['name01']) && $arrDeliv['name01'] != '') && (isset($arrDeliv['name02']) && $arrDeliv['name02'] != ''))
				$deliv_name = $arrDeliv['name01'].' '.$arrDeliv['name02'].' 様';
			elseif ((isset($arrDeliv['name01']) && $arrDeliv['name01'] != '') && (isset($arrDeliv['name02']) && $arrDeliv['name02'] == ''))
				$deliv_name = $arrDeliv['name01'].' 様';
			elseif ((isset($arrDeliv['name02']) && $arrDeliv['name02'] != '') && (isset($arrDeliv['name01']) && $arrDeliv['name01'] == ''))
				$deliv_name = $arrDeliv['name02'].' 様';
			$now = date('Y年m月d日', strtotime($arrOrder['create_date']));

			$pdf->SetFont("ipagp", "", 12);
//			$pdf->Text(10, 25, Tag_Util::normalizeUtf8MacFileName($name.' 様'));

//			$pdf->SetXY( 10, 35 );
			$pdf->SetXY( 10, 35 );
			$pdf->SetFont("ipagp", "", 12);
			$path = APPPATH.'views/smarty/pdf/receipt.png';
//			$pdf->Image($path, 5, 25, 157);
			$pdf->Image($path, -5, 12, 157);

			if (strlen($arrOrder['recepit_atena']) >= 72)
			{
				$pdf->SetFont("ipagp", "", 11);
				$pdf->Text(20, 41.5, Tag_Util::normalizeUtf8MacFileName($arrOrder['recepit_atena']));
			}
			else
			{
				$pdf->SetFont("ipagp", "", 14);
				$pdf->Text(20, 40.5, Tag_Util::normalizeUtf8MacFileName($arrOrder['recepit_atena']));
			}
			$pdf->SetFont("ipagp", "", 16);
			$pdf->Text(50, 52.5, Tag_Util::normalizeUtf8MacFileName('￥'.number_format($arrOrder['payment_total'])));
			$pdf->SetFont("ipagp", "", 9);

//			if ($arrOrder['receipt_tadashi'] == '品代')
//			{
//				$arrOrder['receipt_tadashi'] = '御品代として';
//			}
//			else if (strpos($arrOrder['receipt_tadashi'],'品代') !== false && mb_strlen($arrOrder['receipt_tadashi']) == 2)
//			{
//				$arrOrder['receipt_tadashi'] = '御品代として';
//			}
//			else
//				$arrOrder['receipt_tadashi'] = str_replace('お品代','御品代として',$arrOrder['receipt_tadashi']);
//			if ($arrOrder['receipt_tadashi'] == '')
//				$arrOrder['receipt_tadashi'] = "お品代として";
			$pdf->Text(30, 63, Tag_Util::normalizeUtf8MacFileName($arrOrder['receipt_tadashi']));

			$pdf->SetFont("ipagp", "", 10);
			
			if ($arrOrder['payment_id'] == 2)
				$pdf->Text(30, 69, ' 年　　月　　日銀行振込分');
			else
			{
				$pdf->SetFont("ipagp", "", 9);
				$pdf->Text(20, 69, date('Y年m月d日', strtotime($arrOrder['create_date']))."クレジットカードご利用");
				$pdf->SetFont("ipagp", "", 10);
			}

			$pdf->SetFont("ipagp", "", 7);
//			$arrOrder['payment_total'] += 20000000;
//			$arrOrder['tax'] += 2000000;
			$x = 36 - strlen($arrOrder['total'])*1.1;
			$xx = 37 - strlen($arrOrder['tax'])*1.1;
			$xxx = 37 - strlen($arrOrder['use_point'])*1.1;
			$xxxx = 37 - strlen($arrOrder['discount'])*1.1;

//			$pdf->Text(30, 85, strlen($arrOrder['payment_total']));
			$pdf->Text($x, 89.5, Tag_Util::normalizeUtf8MacFileName('￥'.number_format($arrOrder['total']+$arrOrder['gift_price']+$arrOrder['deliv_fee'])));
			$pdf->Text($xx, 93.5, Tag_Util::normalizeUtf8MacFileName('￥'.number_format($arrOrder['tax'])));
			$pdf->Text($xxx, 97.5, Tag_Util::normalizeUtf8MacFileName('￥'.number_format($arrOrder['use_point'])));
			$pdf->Text($xxxx, 101.5, Tag_Util::normalizeUtf8MacFileName('￥'.number_format($arrOrder['discount'])));
			$pdf->SetFont("ipagp", "", 10);

/*
			$pdf->Text(10, 25, '〒'.$arrDeliv['zip01'].' - '.$arrDeliv['zip02']);
			$pref = $this->arrResult['arrPref'][$arrDeliv['pref']];
			$pref = '  '.$pref. $arrDeliv['addr01'].$arrDeliv['addr02'];
			$pdf->Text(10, 30, Tag_Util::normalizeUtf8MacFileName($pref));
			$name = $arrDeliv['name01'].' '.$arrDeliv['name02'].' 様';
			$pdf->SetFont("ipagp", "", 12);
			$pdf->Text(10, 40, Tag_Util::normalizeUtf8MacFileName($name));
			$pdf->SetFont("ipagp", "", 10);
			$info = "このたびはお買い上げいただきありがとうございます。";
			$pdf->SetFont("ipagp", "", 8);
			$pdf->Text(15, 55, Tag_Util::normalizeUtf8MacFileName($info));
			$info = "下記ご注文品をお届けいたします。";
			$pdf->Text(15, 60, Tag_Util::normalizeUtf8MacFileName($info));
			$pdf->SetFont("ipagp", "", 10);
			$path = APPPATH.'views/smarty/pdf/logo.png';
			$pdf->Image($path, 120, 20, 50);
			$pdf->SetFont("ipagp", "", 8);
			$info = "B.R.ONLINE";
			$pdf->Text(122, 42, Tag_Util::normalizeUtf8MacFileName($info));
			$info = "https://www.bronline.jp/";
			$pdf->Text(122, 46, Tag_Util::normalizeUtf8MacFileName($info));
			$info = "B.R.ONLINE 運営事務局/株式会社ビー・アール・ティー";
			$pdf->Text(122, 51, Tag_Util::normalizeUtf8MacFileName($info));
			$info = "〒 150 - 0001";
			$pdf->Text(122, 55, Tag_Util::normalizeUtf8MacFileName($info));
			$info = "東京都渋谷区神宮前3-34-10";
			$pdf->Text(122, 59, Tag_Util::normalizeUtf8MacFileName($info));
			$info = "ヴィラロイヤル神宮前501号室";
			$pdf->Text(122, 63, Tag_Util::normalizeUtf8MacFileName($info));
			$info = "TEL: 03-6721-1124";
			$pdf->Text(122, 67, Tag_Util::normalizeUtf8MacFileName($info));
			$info = "Email: info@bronline.jp";
			$pdf->Text(122, 71, Tag_Util::normalizeUtf8MacFileName($info));
			$pdf->SetFont("ipagp", "", 13);
			
			$info = "総合計金額";
			$pdf->Text(10, 85, Tag_Util::normalizeUtf8MacFileName($info));
			$pdf->Line(10, 92, 95, 92, $style2);
			$info = "総合計金額";
			$pdf->SetXY( 35, 85 );
			$pdf->Cell(55, 4, number_format($arrOrder['payment_total'])." 円", 0, 0, 'R');
			
			$pdf->SetFillColor(234, 234, 234);
			$pdf->Rect(5.0, 98.0, 200.0, 8.0, 'DF');
			$info = "お買上げ明細";
			$pdf->SetFillColor(255, 255, 255);
			$pdf->Text(10, 99, Tag_Util::normalizeUtf8MacFileName($info));
			
			$info = "[ ご注文日 ]";
			$pdf->Text(10, 110, Tag_Util::normalizeUtf8MacFileName($info));
			$pdf->SetFont("ipagp", "", 10);
			$pdf->Text(10, 117, date('Y/m/d H:i', strtotime($arrOrder['create_date'])));
			$pdf->SetFont("ipagp", "", 13);
			$info = "[ 注文番号 ]";
			$pdf->Text(12, 125, Tag_Util::normalizeUtf8MacFileName($info));
			$pdf->SetFont("ipagp", "", 10);
			//$pdf->Text(12, 150, $arrOrder['order_id']);
			//$pdf->SetFillColor(234, 234, 234);
			$pdf->SetXY( 10, 110 );
			$pdf->Cell(8, 48, $arrOrder['order_id'], 0, 0, 'R');
			
			$pdf->SetXY( 5, 140 );
			$pdf->SetFillColor(234, 234, 234);
			$pdf->Cell(110, 8, '商品名/商品コード/[規格]', 1, 1, 'C', 1);
			$pdf->SetXY( 110, 140 );
			$pdf->SetFillColor(234, 234, 234);
			$pdf->Cell(20, 8, '数量', 1, 1, 'C', 1);
			$pdf->SetXY( 130, 140 );
			$pdf->SetFillColor(234, 234, 234);
			$pdf->Cell(35, 8, '単価', 1, 1, 'C', 1);
			$pdf->SetXY( 165, 140 );
			$pdf->SetFillColor(234, 234, 234);
			$pdf->Cell(40, 8, '金額(税込)', 1, 1, 'C', 1);
			
			$x = 5;
			$y = 148;
			$t = 16;
			$cnt = 0;
			$mv = array(105,20,35,40);
			$f = 0;
	
			$pdf->SetXY( $x, $y );
			$html = "<style>";
			$html .= "table.border td {";
			$html .= "  border: 1px solid #000000;padding:3px;";
			$html .= "}";
			$html .= "</style>";
			$html .= '<table cellpadding="2" class="border">';
	
			foreach($arrDetail as $d)
			{
				$f = $cnt++%2;
				$pr = array();
				$names = $d['product_name'].' / '.$d['product_code'].' / ['.$d['color_name'].' / '.$d['size_name'].']';
				$quantity = $d['quantity'];
				$price = number_format(Tag_Util::taxin_cal($d['price'])).' 円';
				$subtotal = number_format(Tag_Util::taxin_cal($d['price']*$d['quantity'])).' 円';
				if ($f)
					$html .= '<tr><td width="298" align="left">　'.$names.'　</td><td width="56" align="right">　'.$quantity.'　</td><td width="100" align="right">　'.$price.'　</td><td width="113" align="right">　'.$subtotal.'　</td></tr>';
				else
					$html .= '<tr bgcolor="#ddd"><td width="298" align="left">　'.$names.'　</td><td width="56" align="right">　'.$quantity.'　</td><td width="100" align="right">　'.$price.'　</td><td width="113" align="right">　'.$subtotal.'　</td></tr>';
			}
	
			$f = $cnt++%2;
			if ($f)
				$html .= '<tr><td width="298" align="left">　　</td><td width="56" align="right">　　</td><td width="100" align="right">　　</td><td width="113" align="right">　　</td></tr>';
			else
				$html .= '<tr bgcolor="#ddd"><td width="298" align="left">　　</td><td width="56" align="right">　　</td><td width="100" align="right">　　</td><td width="113" align="right">　　</td></tr>';
		
			$f = $cnt++%2;
			if ($f)
				$html .= '<tr>';
			else
				$html .= '<tr bgcolor="#ddd">';
		
			$html .= '<td width="298" align="left">　　</td><td width="56" align="right">　　</td><td width="100" align="right">商品合計</td><td width="113" align="right">'.number_format(Tag_Util::taxin_cal($arrOrder['total'])).' 円'.'</td></tr>';
		
			$f = $cnt++%2;
			if ($f)
				$html .= '<tr>';
			else
				$html .= '<tr bgcolor="#ddd">';
		
			$html .= '<td width="298" align="left">　　</td><td width="56" align="right">　　</td><td width="100" align="right">送料</td><td width="113" align="right">'.number_format(Tag_Util::taxin_cal($arrOrder['deliv_fee'])).' 円'.'</td></tr>';
		
			$f = $cnt++%2;
			if ($f)
				$html .= '<tr>';
			else
				$html .= '<tr bgcolor="#ddd">';
		
			$html .= '<td width="298" align="left">　　</td><td width="56" align="right">　　</td><td width="100" align="right">手数料</td><td width="113" align="right">'.number_format(Tag_Util::taxin_cal($arrOrder['fee'])).' 円'.'</td></tr>';
		
			$f = $cnt++%2;
			if ($f)
				$html .= '<tr>';
			else
				$html .= '<tr bgcolor="#ddd">';
		
			$html .= '<td width="298" align="left">　　</td><td width="56" align="right">　　</td><td width="100" align="right">ラッピング</td><td width="113" align="right">'.number_format(Tag_Util::taxin_cal($arrOrder['gift_price'])).' 円'.'</td></tr>';
		
			$f = $cnt++%2;
			if ($f)
				$html .= '<tr>';
			else
				$html .= '<tr bgcolor="#ddd">';
		
			$html .= '<td width="298" align="left">　　</td><td width="56" align="right">　　</td><td width="100" align="right">調整額</td><td width="113" align="right">'.number_format(Tag_Util::taxin_cal($arrOrder['discount']*-1)).' 円'.'</td></tr>';
		
			$f = $cnt++%2;
			if ($f)
				$html .= '<tr>';
			else
				$html .= '<tr bgcolor="#ddd">';
		
			$html .= '<td width="298" align="left">　　</td><td width="56" align="right">　　</td><td width="100" align="right">請求金額</td><td width="113" align="right">'.number_format($arrOrder['payment_total']).' 円'.'</td></tr>';
		
			$f = $cnt++%2;
			if ($f)
				$html .= '<tr>';
			else
				$html .= '<tr bgcolor="#ddd">';
		
			$html .= '<td width="298" align="left">　　</td><td width="56" align="right">　　</td><td width="100" align="right">　　</td><td width="113" align="right">　　</td></tr>';
	
			if (Input::param('disp_point') == '1')
			{
				$f = $cnt++%2;
				if ($f)
					$html .= '<tr>';
				else
					$html .= '<tr bgcolor="#ddd">';
			
				$html .= '<td width="298" align="left">　　</td><td width="56" align="right">　　</td><td width="100" align="right">利用ポイント</td><td width="113" align="right">'.number_format($arrOrder['use_point']).' pt'.'</td></tr>';
		
				$f = $cnt++%2;
				if ($f)
					$html .= '<tr>';
				else
					$html .= '<tr bgcolor="#ddd">';
			
				$html .= '<td width="298" align="left">　　</td><td width="56" align="right">　　</td><td width="100" align="right">加算ポイント</td><td width="113" align="right">'.number_format($arrOrder['add_point']).' pt'.'</td></tr>';
			}
	
			$html .= "</table>";
		
			$html .= "<br><br><p>＜ 備考 ＞</p>";
			$info = Input::param('etc1');
			if ($info != '')
				$html .= "<p>".Tag_Util::normalizeUtf8MacFileName($info)."</p>";
			$info = Input::param('etc2');
			if ($info != '')
				$html .= "<p>".Tag_Util::normalizeUtf8MacFileName($info)."</p>";
			$info = Input::param('etc3');
			if ($info != '')
				$html .= "<p>".Tag_Util::normalizeUtf8MacFileName($info)."</p>";
			$info = Input::param('msg1');
			if ($info != '')
				$html .= "<p>".Tag_Util::normalizeUtf8MacFileName($info)."</p>";
			$info = Input::param('msg2');
			if ($info != '')
				$html .= "<p>".Tag_Util::normalizeUtf8MacFileName($info)."</p>";
			$info = Input::param('msg3');
			if ($info != '')
				$html .= "<p>".Tag_Util::normalizeUtf8MacFileName($info)."</p>";
*/			
			@$pdf->writeHTML($html);
		}
		$pdf->Output( date('Y-m-d').$order_id.'.pdf', 'I' );
	}

	public function f_deliv($post)
	{
		if (!isset($post['pdf_order_id']))
		{
			$post['pdf_order_id'] = array();
			$post['pdf_order_id'][] = $post['order_id'];
		}
		$this->tpl = 'smarty/pdf.tpl';
		
		Package::load('pdf');
		$pdf = Pdf::factory('tcpdf')->init("P", "mm", "A4", true, "UTF-8");
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->setFooterMargin(0);
		$pdf->SetAutoPageBreak(TRUE, 0);

		$title = Input::param('title', '納品書');
		if ($title == '')
			$title = '納品書';

		foreach($post['pdf_order_id'] as $order_id)
		{
			if ($order_id == 0 || $order_id == '')
				continue;
	
			$arrOrder = Tag_Order::get_order_info($order_id);
			if (count($arrOrder) > 0)
			{
				$arrOrder = $arrOrder[0];
				if ($arrOrder['status'] == '3')
					continue;
			}
			else
				return $this->view;

			if ($arrOrder['detail_statement'] == '0' && $post['pdf_order_id'][count($post['pdf_order_id']) - 1] == '')
				continue;

			$arrDeliv = Tag_Order::get_order_deliv2($order_id);
			if (count($arrDeliv) == 1)
			{
				$arrDeliv = $arrDeliv[0];
			}
			else if (count($arrDeliv) > 1)
			{
				foreach($arrDeliv as $deliv)
				{
					if ($deliv['customer_id'] == '0')
					{
						if ($deliv['email'] == '')
						{
							$arrDeliv = $deliv;
							break;
						}
					}
					else
					{
						if ($deliv['email'] == '')
						{
							$arrDeliv = $deliv;
							break;
						}
					}
				}
			}
			else
				return $this->view;

			$arrDetail = Tag_Order::get_order_detail($order_id);
			$pdf->AddPage();
	
			$style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => '10,20,5,10', 'phase' => 10, 'color' => array(0, 0, 0));
			$style2 = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
			$style3 = array('width' => 1, 'cap' => 'round', 'join' => 'round', 'dash' => '2,10', 'color' => array(255, 0, 0));
			$pdf->Line(5, 10, 205, 10, $style2);
			$pdf->Line(205, 10, 205, 20, $style2);
			$pdf->Line(205, 20, 5, 20, $style2);
			$pdf->Line(5, 20, 5, 10, $style2);
			$pdf->SetFont("ipagp", "", 15);
			//$pdf->Text(95, 12, $title);
			$pdf->SetXY( 5, 11 );
			$pdf->Cell(200,8, Tag_Util::normalizeUtf8MacFileName($title), 0, 0, 'C', 0);
			$pdf->SetFont("ipagp", "", 10);

//print("<prev>");
//var_dump($arrDeliv);	
//print("</prev>");
//exit;

			$pdf->Text(10, 25, '〒'.$arrDeliv['zip01'].' - '.$arrDeliv['zip02']);
			$pref = $this->arrResult['arrPref'][$arrDeliv['pref']];
			$pref = '  '.$pref. $arrDeliv['addr01'].$arrDeliv['addr02'];
			$pdf->Text(10, 30, Tag_Util::normalizeUtf8MacFileName($pref));
			$name = $arrDeliv['name01'].' '.$arrDeliv['name02'].' 様';
			$pdf->SetFont("ipagp", "", 12);
			$pdf->Text(10, 40, Tag_Util::normalizeUtf8MacFileName($name));
			$pdf->SetFont("ipagp", "", 10);
			$info = "このたびはお買い上げいただきありがとうございます。";
			$pdf->SetFont("ipagp", "", 8);
			$pdf->Text(15, 55, Tag_Util::normalizeUtf8MacFileName($info));
			$info = "下記ご注文品をお届けいたします。";
			$pdf->Text(15, 60, Tag_Util::normalizeUtf8MacFileName($info));
			$pdf->SetFont("ipagp", "", 10);
			$path = APPPATH.'views/smarty/pdf/logo.png';
			$pdf->Image($path, 120, 20, 50);
			$pdf->SetFont("ipagp", "", 8);
			$info = "B.R.ONLINE";
			$pdf->Text(122, 42, Tag_Util::normalizeUtf8MacFileName($info));
//			$info = "https://www.bronline.jp/";
			$info = "株式会社ビー・アール・ティー";
			$pdf->Text(122, 46, Tag_Util::normalizeUtf8MacFileName($info));
			$info = "登録番号：T2011001056747";
			$pdf->Text(122, 51, Tag_Util::normalizeUtf8MacFileName($info));
			$info = "〒 150 - 0001";
			$pdf->Text(122, 55, Tag_Util::normalizeUtf8MacFileName($info));
			$info = "東京都渋谷区神宮前3-35-16";
			$pdf->Text(122, 59, Tag_Util::normalizeUtf8MacFileName($info));
			$info = "ルナーハウスパート4ビル4階";
			$pdf->Text(122, 63, Tag_Util::normalizeUtf8MacFileName($info));
			$info = "TEL: 03-6721-1124";
			$info = "Email: info@bronline.jp";
			$pdf->Text(122, 67, Tag_Util::normalizeUtf8MacFileName($info));
//			$pdf->Text(122, 71, Tag_Util::normalizeUtf8MacFileName($info));
			$pdf->SetFont("ipagp", "", 13);
			
			$info = "総合計金額";
			$pdf->Text(10, 85, Tag_Util::normalizeUtf8MacFileName($info));
			$pdf->Line(10, 92, 95, 92, $style2);
			$info = "総合計金額";
			$pdf->SetXY( 35, 85 );
			$pdf->Cell(55, 4, number_format($arrOrder['payment_total'])." 円", 0, 0, 'R');
			
			$pdf->SetFillColor(234, 234, 234);
			$pdf->Rect(5.0, 98.0, 200.0, 8.0, 'DF');
			$info = "お買上げ明細";
			$pdf->SetFillColor(255, 255, 255);
			$pdf->Text(10, 99, Tag_Util::normalizeUtf8MacFileName($info));
			
			$info = "[ ご注文日 ]";
			$pdf->Text(10, 110, Tag_Util::normalizeUtf8MacFileName($info));
			$pdf->SetFont("ipagp", "", 10);
			$pdf->Text(10, 117, date('Y/m/d H:i', strtotime($arrOrder['create_date'])));
			$pdf->SetFont("ipagp", "", 13);
			$info = "[ 注文番号 ]";
			$pdf->Text(12, 125, Tag_Util::normalizeUtf8MacFileName($info));
			$pdf->SetFont("ipagp", "", 10);
			//$pdf->Text(12, 150, $arrOrder['order_id']);
			//$pdf->SetFillColor(234, 234, 234);
			$pdf->SetXY( 10, 110 );
			$pdf->Cell(8, 48, $arrOrder['order_id'], 0, 0, 'R');
			
			$pdf->SetXY( 5, 140 );
			$pdf->SetFillColor(234, 234, 234);
			$pdf->Cell(110, 8, '商品名/商品コード/[規格]', 1, 1, 'C', 1);
			$pdf->SetXY( 110, 140 );
			$pdf->SetFillColor(234, 234, 234);
			$pdf->Cell(20, 8, '数量', 1, 1, 'C', 1);
			$pdf->SetXY( 130, 140 );
			$pdf->SetFillColor(234, 234, 234);
			$pdf->Cell(35, 8, '単価', 1, 1, 'C', 1);
			$pdf->SetXY( 165, 140 );
			$pdf->SetFillColor(234, 234, 234);
			$pdf->Cell(40, 8, '金額(税込)', 1, 1, 'C', 1);
			
			$x = 5;
			$y = 148;
			$t = 16;
			$cnt = 0;
			$mv = array(105,20,35,40);
			$f = 0;
	
			$pdf->SetXY( $x, $y );
			$html = "<style>";
			$html .= "table.border td {";
			$html .= "  border: 1px solid #000000;padding:3px;";
			$html .= "} ";
			$html .= "table.borders td {";
			$html .= "  border: 0px solid #fff;padding:3px;";
			$html .= "} ";
			$html .= "</style>";
			$html .= '<table cellpadding="2" class="border">';
	
			foreach($arrDetail as $d)
			{
				$f = $cnt++%2;
				$pr = array();
				$names = $d['product_name'].' / '.$d['product_code'].' / ['.$d['color_name'].' / '.$d['size_name'].']';
				$quantity = $d['quantity'];
				$price = number_format(Tag_Util::taxin_cal($d['price'])).' 円';
				$subtotal = number_format(Tag_Util::taxin_cal($d['price']*$d['quantity'])).' 円';
				if ($f)
					$html .= '<tr><td width="298" align="left">　'.$names.'　</td><td width="56" align="right">　'.$quantity.'　</td><td width="100" align="right">　'.$price.'　</td><td width="113" align="right">　'.$subtotal.'　</td></tr>';
				else
					$html .= '<tr bgcolor="#ddd"><td width="298" align="left">　'.$names.'　</td><td width="56" align="right">　'.$quantity.'　</td><td width="100" align="right">　'.$price.'　</td><td width="113" align="right">　'.$subtotal.'　</td></tr>';
			}
	
			$f = $cnt++%2;
			if ($f)
				$html .= '<tr><td width="298" align="left">　　</td><td width="56" align="right">　　</td><td width="100" align="right">　　</td><td width="113" align="right">　　</td></tr>';
			else
				$html .= '<tr bgcolor="#ddd"><td width="298" align="left">　　</td><td width="56" align="right">　　</td><td width="100" align="right">　　</td><td width="113" align="right">　　</td></tr>';
		
			$f = $cnt++%2;
			if ($f)
				$html .= '<tr>';
			else
				$html .= '<tr bgcolor="#ddd">';
		
			$html .= '<td width="298" align="left">　　</td><td width="56" align="right">　　</td><td width="100" align="right">商品合計</td><td width="113" align="right">'.number_format(Tag_Util::taxin_cal($arrOrder['total'])).' 円'.'</td></tr>';
		
			$f = $cnt++%2;
			if ($f)
				$html .= '<tr>';
			else
				$html .= '<tr bgcolor="#ddd">';
		
			$html .= '<td width="298" align="left">　　</td><td width="56" align="right">　　</td><td width="100" align="right">送料</td><td width="113" align="right">'.number_format(Tag_Util::taxin_cal($arrOrder['deliv_fee'])).' 円'.'</td></tr>';
		
			$f = $cnt++%2;
			if ($f)
				$html .= '<tr>';
			else
				$html .= '<tr bgcolor="#ddd">';
		
			$html .= '<td width="298" align="left">　　</td><td width="56" align="right">　　</td><td width="100" align="right">手数料</td><td width="113" align="right">'.number_format(Tag_Util::taxin_cal($arrOrder['fee'])).' 円'.'</td></tr>';
		
			$f = $cnt++%2;
			if ($f)
				$html .= '<tr>';
			else
				$html .= '<tr bgcolor="#ddd">';
		
			$html .= '<td width="298" align="left">　　</td><td width="56" align="right">　　</td><td width="100" align="right">ラッピング</td><td width="113" align="right">'.number_format(Tag_Util::taxin_cal($arrOrder['gift_price'])).' 円'.'</td></tr>';
		
			$f = $cnt++%2;
			if ($f)
				$html .= '<tr>';
			else
				$html .= '<tr bgcolor="#ddd">';
		
			$html .= '<td width="298" align="left">　　</td><td width="56" align="right">　　</td><td width="100" align="right">調整額</td><td width="113" align="right">'.number_format(($arrOrder['discount']*-1)).' 円'.'</td></tr>';
		
			$f = $cnt++%2;
			if ($f)
				$html .= '<tr>';
			else
				$html .= '<tr bgcolor="#ddd">';
		
			$html .= '<td width="298" align="left">　　</td><td width="56" align="right">　　</td><td width="100" align="right">請求金額</td><td width="113" align="right">'.number_format($arrOrder['payment_total']).' 円'.'</td></tr>';
		
			$f = $cnt++%2;
			if ($f)
				$html .= '<tr>';
			else
				$html .= '<tr bgcolor="#ddd">';
		
			$html .= '<td width="298" align="left">　　</td><td width="56" align="right">　　</td><td width="100" align="right">　　</td><td width="113" align="right">　　</td></tr>';
	
			if (Input::param('disp_point') == '1')
			{
				$f = $cnt++%2;
				if ($f)
					$html .= '<tr>';
				else
					$html .= '<tr bgcolor="#ddd">';
			
				$html .= '<td width="298" align="left">　　</td><td width="56" align="right">　　</td><td width="100" align="right">利用ポイント</td><td width="113" align="right">'.number_format($arrOrder['use_point']).' pt'.'</td></tr>';
		
				$f = $cnt++%2;
				if ($f)
					$html .= '<tr>';
				else
					$html .= '<tr bgcolor="#ddd">';
			
				$html .= '<td width="298" align="left">　　</td><td width="56" align="right">　　</td><td width="100" align="right">加算ポイント</td><td width="113" align="right">'.number_format($arrOrder['add_point']).' pt'.'</td></tr>';
			}
	
			$html .= "</table>";

			$html .= '<table cellpadding="2" class="borders">';		
			$html .= '<tr><td width="298" align="left"></td><td width="56" align="right"></td><td width="100" align="right"></td><td width="113" align="right"></td></tr>';
			$html .= '<tr><td width="298" align="left"></td><td width="56" align="right"></td><td width="100" align="right">【 内訳 】</td><td width="113" align="right"></td></tr>';
			$html .= '<tr><td width="298" align="left"></td><td width="56" align="right"></td><td width="100" align="right">10%対象</td><td width="113" align="right">'.number_format($arrOrder['total']+$arrOrder['gift_price']+$arrOrder['deliv_fee']).'円</td></tr>';
			$html .= '<tr><td width="298" align="left"></td><td width="56" align="right"></td><td width="100" align="right">消費税</td><td width="113" align="right">'.number_format($arrOrder['tax']).'円</td></tr>';
			$html .= "</table>";
			
			
			$html .= "<br><br><p>＜ 備考 ＞</p>";
			$info = Input::param('etc1');
			if ($info != '')
				$html .= "<p>".Tag_Util::normalizeUtf8MacFileName($info)."</p>";
			$info = Input::param('etc2');
			if ($info != '')
				$html .= "<p>".Tag_Util::normalizeUtf8MacFileName($info)."</p>";
			$info = Input::param('etc3');
			if ($info != '')
				$html .= "<p>".Tag_Util::normalizeUtf8MacFileName($info)."</p>";
			$info = Input::param('msg1');
			if ($info != '')
				$html .= "<p>".Tag_Util::normalizeUtf8MacFileName($info)."</p>";
			$info = Input::param('msg2');
			if ($info != '')
				$html .= "<p>".Tag_Util::normalizeUtf8MacFileName($info)."</p>";
			$info = Input::param('msg3');
			if ($info != '')
				$html .= "<p>".Tag_Util::normalizeUtf8MacFileName($info)."</p>";
			
			@$pdf->writeHTML($html);
		}
		$pdf->Output( date('Y-m-d').$order_id.'.pdf', 'I' );
	}

	public function before()
	{
		parent::before();

		$y = date('Y');
		$year = array();
		for($i=$y - 1;$i <=$y+2;$i++)
		{
			$year[$i] = $i;
		}
		$month = array();
		for($i=1;$i <=12;$i++)
		{
			$month[$i] = $i;
		}
		$day = array();
		for($i=1;$i <=31;$i++)
		{
			$day[$i] = $i;
		}
		$this->arrResult['arrYear'] = $year;
		$this->arrResult['arrMonth'] = $month;
		$this->arrResult['arrDay'] = $day;
		$this->arrResult['now_y'] = date('Y');
		$this->arrResult['now_m'] = date('n');
		$this->arrResult['now_d'] = date('j');

		$arrTemp = Tag_Master::get_master('mtb_order_status');
		$arrORDERSTATUS = array();
		foreach($arrTemp as $t)
		{
			$arrORDERSTATUS[$t['id']] = $t['name'];
		}
		$this->arrResult['arrORDERSTATUS'] = $arrORDERSTATUS;

		$arrTemp = Tag_Master::get_master('mtb_payment');
		$arrPayments = array();
		foreach($arrTemp as $t)
		{
			$arrPayments[$t['id']] = $t['name'];
		}
		$this->arrResult['arrPayments'] = $arrPayments;

		$arrTemp = Tag_Master::get_master('mtb_status');
		$arrSTATUS = array();
		foreach($arrTemp as $t)
		{
			$arrSTATUS[$t['id']] = $t['name'];
		}
		$this->arrResult['arrSTATUS'] = $arrSTATUS;

		$arrTemp = Tag_Master::get_master('mtb_pref');
		$arrPref = array();
		foreach($arrTemp as $t)
		{
			$arrPref[$t['id']] = $t['name'];
		}
		$this->arrResult['arrPref'] = $arrPref;

		$arrTemp = Tag_Master::get_master('mtb_status_color');
		$arrPRODUCTSTATUS_COLOR = array();
		foreach($arrTemp as $t)
		{
			$arrPRODUCTSTATUS_COLOR[$t['id']] = $t['name'];
		}
		$this->arrResult['arrPRODUCTSTATUS_COLOR'] = $arrPRODUCTSTATUS_COLOR;

		$arrTemp = Tag_Order::get_deliv_time();
		$arrDelivTime = array();
		foreach($arrTemp as $t)
		{
			$arrDelivTime[$t['deliv_time']] = $t['deliv_time'];
		}
		//var_dump($arrDelivTime);
		$this->arrResult['arrDelivTime'] = $arrDelivTime;
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
