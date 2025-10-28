<?php
use Oil\Exception;

class Controller_Admin_Template extends ControllerAdmin
{

	public function before() {
		parent::before();

		$this->arrResult["arrError"] = array();
		$this->arrResult["arrMsg"] = array();
	}


	/**
	 * 初期画面
	 */
	public function action_index()
	{
		if (!$this->doValidToken())
		{
			return Response::redirect('/admin/error', 'location', 301);
		}


		$ads = get_ad();
//print('<pre>');
//var_dump($ads['arrPosts']);
//print('</pre>');

		$arrTemp = array();
		$arrTemp[0]['post_content'] = '';
		$arrOptions = array();
		$arrOptions[] = '選択してください';
		foreach($ads['arrPosts'] as $ad)
		{
			$arrOptions[$ad['ID']] = $ad['post_title'];
//			$arrOptions[] = $this->catch_that_image($ad['ID']);
			$arrTemp[$ad['ID']]['image'] = $this->catch_that_image($ad['post_content']);
//			$arrTemp['ID'] = $ad['ID'];
			$arrTemp[$ad['ID']]['post_title'] = $ad['post_title'];
			$arrTemp[$ad['ID']]['post_content'] = $ad['post_content'];
		}
		
		$table_name = 'dtb_ads';
		$where = '';
		$order = 'id';
		$columns = Tag_Util::get_columns($table_name);
		foreach($columns as $c)
		{
			$column[] = $c['Field'];
		}
		$arrRet = Tag_Util::get_table($column, $table_name, $where, $order);

		$mode = Input::param('mode', '');
		if ($mode == 'regist')
		{
			$arrItem = array();
			$query = DB::update($table_name);
			$arrItem['big'] = Input::param('big_id');
			$arrItem['big_contents'] = $arrTemp[$arrItem['big']]['post_content'];
			$arrItem['middle'] = Input::param('middle_id');
			$arrItem['middle_contents'] = $arrTemp[$arrItem['middle']]['post_content'];
			$arrItem['footer'] = Input::param('footer_id');
			$arrItem['footer_contents'] = $arrTemp[$arrItem['footer']]['post_content'];
			$arrItem['2col'] = Input::param('2col_id');
			$arrItem['2col_contents'] = $arrTemp[$arrItem['2col']]['post_content'];
			
			$query->set($arrItem)->where('id', 1)->execute();
			$arrRet[0] = $arrItem;
		}

		$this->arrResult["arrAdsVal"] = $arrRet[0];
		$this->arrResult["arrAdImg"] = $arrOptions;
		$this->arrResult["arrAds"] = $arrTemp;
		$this->arrResult["jAds"] = json_encode($arrTemp);


//var_dump(Input::param());

		$this->tpl = 'smarty/admin/basis/template.tpl';
		return $this->view;
	}

function catch_that_image($post_content)
{
	$first_img = '';
//	$matches = array();
   	preg_match_all("/<img[^>]+src=[\"'](s?https?:\/\/[\-_\.!~\*'()a-z0-9;\/\?:@&=\+\$,%#]+\.(jpg|jpeg|png|gif))[\"'][^>]+>/i", $post_content, $matches);
//  	var_dump($matches[1][0]);
//  	foreach($matches as $m)
//  	{
//  		if (isset($m[0]))
//	  		var_dump($m[0]);
//  	}
//var_dump($matches);
	if (isset($matches[1][0]))
	    $first_img = $matches[1][0];
 
    if(empty($first_img)){ //Defines a default image
        $first_img = "";
    }
	return $first_img;
/*
	$args = array(
	    'post_type' => 'attachment',
	    'posts_per_page' => 1,
	    'post_status' => null,
	    'post_parent' => $id
	    ); 
	$attachments = get_posts($args);
	if ($attachments) {
	    foreach ($attachments as $attachment) {
	        return the_attachment_link($attachment->ID, false);
	    }
	}
	return '';
*/
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
