<?php

class Tag_customerctrl {

	public $customer;


	public function __construct() {
		$this->customer = new Tag_Customer();
	}

	public function setSession()
	{
		$_SESSION['customer'] = serialize( $this->customer );
	}

	public function getSession()
	{
		if(isset($_SESSION['customer']) && $_SESSION['customer'] != '') {
			$this->customer = unserialize( $_SESSION['customer'] );
		}
	}
    public static function clearSession()
    {
        //unset($_SESSION['cart_order']);
        unset($_SESSION['customer']);
    }



	/*----------------------------------------------------------------------
	 * [名称] gfMakePassword
	 * [概要] ランダムパスワード生成（英数字）
	 * [引数] パスワードの桁数
	 * [戻値] ランダム生成されたパスワード
	 * [依存] なし
	 * [注釈] EC-CUBEよりメソッドを引用
	 *----------------------------------------------------------------------*/
	function gfMakePassword($pwLength) {

		// 乱数表のシードを決定
		srand((double)microtime() * 54234853);

		// パスワード文字列の配列を作成
		$character = 'abcdefghkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ2345679';
		$pw = preg_split('//', $character, 0, PREG_SPLIT_NO_EMPTY);

		$password = '';
		for ($i = 0; $i<$pwLength; $i++) {
			$password .= $pw[array_rand($pw, 1)];
		}

		return $password;
	}


	/**
	 * パスワードのハッシュ化
	 * 		EC-CUBEよりメソッドを引用
	 *
	 * @param string $str 暗号化したい文言
	 * @param string $salt salt
	 * @return string ハッシュ暗号化された文字列
	 */
	function sfGetHashString($str, $salt) {
		$res = '';
		if ($salt == '') {
			$salt = AUTH_MAGIC;
		}
		$res = hash_hmac(PASSWORD_HASH_ALGOS, $str . ':' . AUTH_MAGIC, $salt);

		return $res;
	}


	/**
	 * パスワードチェック
	 * 		本登録（status=2）で削除されていないもの（del_flg=0）が対象
	 * @param unknown $email		メールアドレス
	 * @param unknown $password		パスワード
	 * @return boolean				customer_id（一致） / false（不一致）
	 */
	function chkPassword( $email, $password ) {
		$result = DB::select()->from('dtb_customer')->where('email', $email)->where('del_flg', 0)->where('status', 2)->execute()->as_array();

		if( 0 < count($result)) {
			$arrCustomer = $result[0];

			// パスワードのハッシュ化
			$pass = $this->sfGetHashString($password, $arrCustomer['salt']);

			// ハッシュ化したパスワードと、DBのパスワードをチェック
			if( $pass == $arrCustomer['password']) {
				return $arrCustomer['customer_id'];
			}
		}
		return false;
	}

	/**
	 * dtb_customer に登録済メールアドレスかチェックする
	 * 		削除されていないもの（del_flg=0）が対象
	 *
	 * @param unknown $email		メールアドレス
	 * @return boolean				true（登録済） / false（未登録）
	 */
	function isRegisteredEmail( $email ) {
		$result = DB::select()->from('dtb_customer')->where('email', $email)->where('del_flg', 0)->execute()->as_array();

		if( 0 < count($result)) {
			return true;
		} else {
			return false;
		}
	}
}



class Tag_Customer {

	private $customer_id;		// ユーザーID
	private $name01;			// 姓名（姓）
	private $name02;			// 姓名（名）
	private $point;			// ポイント
	private $point_rate;			// ポイント
	private $rank;				// ランク
	private $login_memory;		// ログインしたままにする
	private $sale_status;

	public function setSaleStatus( $sale_status ) {
		$this->sale_status = $sale_status;
	}

	public function getSaleStatus() {
		return $this->sale_status;
	}

	public function setCustomerId( $customer_id ) {
		$this->customer_id = $customer_id;
	}

	public function getCustomerId() {
		return $this->customer_id;
	}

	public function setPointRate( $point_rate ) {
		$this->point_rate = $point_rate;
	}

	public function getPointRate() {
		return $this->point_rate;
	}


	public function setName01( $name01 ) {
		$this->name01 = $name01;
	}

	public function getName01() {
		return $this->name01;
	}


	public function setName02( $name02 ) {
		$this->name02 = $name02;
	}

	public function getName02() {
		return $this->name02;
	}


	public function setPoint( $point) {
		$this->point = $point;
	}

	public function getPoint() {
		return $this->point;
	}


	public function setRank( $rank) {
		$this->rank = $rank;
	}

	public function getRank() {
		return $this->rank;
	}


	public function setLoginMemory( $login_memory) {
		$this->login_memory = $login_memory;
	}

	public function getLoginMemory() {
		return $this->login_memory;
	}



	public function __construct() {
		$this->customer_id = '';
		$this->name01 = '';
		$this->name02 = '';
		$this->point = 0;
		$this->point_rate = 0;
		$this->rank = '';
		$this->sale_status = 0;
		$this->login_memory = 0;
	}

}

