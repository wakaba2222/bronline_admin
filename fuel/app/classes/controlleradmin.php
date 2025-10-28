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

class ControllerAdmin extends Controller
{
	/**
	 * @var  Request  The current Request object
	 */
	public $request;

	/**
	 * @var  Integer  The default response status
	 */
	public $response_status = 200;

// 	protected $shop_name = '';
// 	protected $shop_url = '';
	protected $view;
	protected $tpl;
	protected $arrResult = array();

	/**
	 * Sets the controller request object.
	 *
	 * @param   \Request $request  The current request object
	 */
	public function __construct(\Request $request)
	{
		$this->request = $request;
	}

	/**
	 * This method gets called before the action is called
	 */
	public function before()
	{
		if (!isset($_SESSION['authority']))
		{
			Response::redirect('/admin/error', 'location', 301);
		}
		
		$this->view = View_Smarty::forge('smarty/admin/main_frame.tpl');
// 		$this->view->head = View_Smarty::forge('smarty/admin/head.tpl');
// 		$this->view->footer = View_Smarty::forge('smarty/admin/footer.tpl');
//		$this->view = View_Smarty::forge('smarty/admin/main_frame.tpl');
// 		$this->view->head = View_Smarty::forge('smarty/admin/head.tpl');
// 		$this->view->footer = View_Smarty::forge('smarty/admin/footer.tpl');

//		$_SESSION['shop'] = 'brshop';
	}

	/**
	 * This method gets called after the action is called
	 * @param \Response|string $response
	 * @return \Response
	 */
	public function after($response)
	{		
		if (isset($response->status) && $response->status == 404)
		{
			if ( ! $response instanceof Response)
			{
				$response = \Response::forge($response, $this->response_status);
			}
	
	
			/*
			echo "<pre>";
			print_r($response->body);
			echo "</pre>";
			*/
	
			return $response;
		}
		define('TEMPLATE_ADMIN_REALDIR', './');
		define('ROOT_URLPATH', '/admin_common/');
		$_SESSION['login_name'] = "";
		$_SESSION['shop_mode'] = "";
		$_SESSION['shop_admin'] = "";
		$this->arrResult['TPL_URLPATH'] = '/admin_common/';
		$this->arrResult['GLOBAL_ERR'] = '';
		$this->arrResult['tpl_mainno'] = '';
		$this->arrResult['tpl_javascript'] = '';
		$this->arrResult['tpl_onload'] = '';
		$this->arrResult['tpl_authority'] = '';
		$this->arrResult['login_name'] = '';
		$this->arrResult['shop_mode'] = '';
		$this->arrResult['tpl_subtitle'] = '';
		$this->arrResult['tpl_subno'] = '';
		$this->arrResult['shop_admin'] = '';
		$this->arrResult['tpl_mainpage'] = $this->tpl;
		$this->arrResult['transactionid'] = '';
//		$this->arrResult['arrError'] = array();
		$this->arrResult['arrErr'] = array('search_product_id'=>'', 'search_smaregi_product_id'=>'', 'search_product_statuses'=>'');

//		$this->arrResult['arrForm'] = array('search_startyear'=>array('value'=>'', 'length'=>''),'search_group_view'=>array('value'=>''), 'search_product_id'=>array('value'=>'', 'length'=>''), 'search_smaregi_product_id'=>array('value'=>'', 'length'=>''), 'search_product_statuses'=>array('value'=>'', 'length'=>''));
		$this->arrResult['transactionid'] = Tag_Session::getToken();
		
		foreach($this->arrResult as $k=>$v)
		{
			$response->set($k, $v);
		}

//		$response->head = View_Smarty::forge('smarty/admin/head.tpl');
		// Make sure the $response is a Response object
		if ( ! $response instanceof Response)
		{
			$response = \Response::forge($response, $this->response_status);
		}

		return $response;
	}
	
	public function setItemParam($arrRet, $k = 'id', $v = 'name')
	{
		$arrTemp = array();
		foreach($arrRet as $ret)
		{
			$arrTemp[$ret[$k]] = $ret[$v];
		}
		
		return $arrTemp;
	}

	public function setData($arrRet, $key = 'arrProducts')
	{
		$this->arrResult[$key] = $arrRet;
		return;
	}
	
	public function setFormParams($key, $name, $value, $length)
	{
		$arrData = array();
		$arrData['name'] = $name;
		$arrData['value'] = $value;
		$arrData['length'] = $length;
		
		$this->arrResult[$key][$name] = $arrData;
	}

	/**
	 * This method returns the named parameter requested, or all of them
	 * if no parameter is given.
	 *
	 * @param   string  $param    The name of the parameter
	 * @param   mixed   $default  Default value
	 * @return  mixed
	 */
	public function param($param, $default = null)
	{
		return $this->request->param($param, $default);
	}

	/**
	 * This method returns all of the named parameters.
	 *
	 * @return  array
	 */
	public function params()
	{
		return $this->request->params();
	}

    public function doValidToken($is_admin = false)
    {
        if ($is_admin)
        {
            $mode = $this->getMode();
            if ($_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'GET')
            {
                if (!Tag_Session::isValidToken(false))
                {
                	return false;
//                    SC_Utils_Ex::sfDispError(INVALID_MOVE_ERRORR);
//                    SC_Response_Ex::actionExit();
                }
            }
        }
        else
        {
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                if (!Tag_Session::isValidToken(false))
                {
                	return false;
//                     SC_Utils_Ex::sfDispSiteError(PAGE_ERROR, '', true);
//                     SC_Response_Ex::actionExit();
                }
             }
        }

        return true;
    }

    function getMode() {
        $pattern = '/^[a-zA-Z0-9_]+$/';
        $mode = null;
        if (isset($_GET['mode']) && preg_match($pattern, $_GET['mode'])) {
            $mode =  $_GET['mode'];
        } elseif (isset($_POST['mode']) && preg_match($pattern, $_POST['mode'])) {
            $mode = $_POST['mode'];
        }
        return $mode;
    }

}
