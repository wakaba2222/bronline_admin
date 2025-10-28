<?php
use AmazonPay\Client as Client;

class Tag_Paymentapi extends Model
{
    public static function _init()
    {
        Config::load('development/payment_conf.php', 'paymentapi');
        // GMO提供ライブラリのパス
        if ( strpos( get_include_path(), Config::get('paymentapi.gmo_path_gpay_client') ) == false ) {
            set_include_path(get_include_path().PATH_SEPARATOR.Config::get('paymentapi.gmo_path_gpay_client') );
        }

        require_once( 'com/gmo_pg/client/input/SearchTradeInput.php' );
        require_once( 'com/gmo_pg/client/tran/SearchTrade.php' );
        require_once( 'com/gmo_pg/client/input/AlterTranInput.php' );
        require_once( 'com/gmo_pg/client/tran/AlterTran.php' );
    }


    public function gmoCardGetOrder( $inp )
    {
        // 処理情報をログに出力する
        Log::info( __FUNCTION__.' start:'.json_encode( $inp, JSON_UNESCAPED_UNICODE ) );

        $res['error'] = false;
        try {
            // 引数チェック
            if ( !isset( $inp['order_id'] ) || empty( $inp['order_id'] ) ) throw new Exception( "注文番号が未設定です", 3 );

            // 入力パラメータクラス
            $input = new SearchTradeInput();
            // パラメータの設定
            $input->setShopId( Config::get('paymentapi.gmo_shop_id') );
            $input->setShopPass( Config::get('paymentapi.gmo_shop_pwd') );
            $input->setOrderId( $inp['order_id'] );

            // APIクラス
            $exe = new SearchTrade();
            // 実行メソッド
            $output = $exe->exec( $input );

            // APIの戻り値を返す
            parse_str( $output->toString(), $detail );
            $res['detail'] = $detail;
            $res['order_id'] = $output->getOrderID();
            $res['access_id'] = $output->getAccessID();
            $res['access_pass'] = $output->getAccessPass();

            // エラーの確認
            if ( $output->isErrorOccurred() ) {
                throw new Exception( $detail['ErrInfo'], 99 );
            }
        } catch ( Exception $e ) {
            $res['error'] = true;
            $res['error_id'] = $e->getCode();
            $res['error_msg'] = $e->getMessage();
            // エラー情報をログに出力する
            Log::error( __FUNCTION__.' :'.json_encode( $res, JSON_UNESCAPED_UNICODE ) );
        }        
        // 処理結果をログに出力する
        Log::info( __FUNCTION__.' end:'.json_encode( $res, JSON_UNESCAPED_UNICODE ) );
        return $res;
    }

    public function gmoCardCancel( $inp )
    {
        // 処理情報をログに出力する
        Log::info( __FUNCTION__.' start:'.json_encode( $inp, JSON_UNESCAPED_UNICODE ) );

        $res['error'] = false;
        try {
            // 引数チェック
            if ( !isset( $inp['access_id'] ) || empty( $inp['access_id'] ) ) throw new Exception( "アクセスIDが未設定です", 1 );
            if ( !isset( $inp['access_pass'] ) || empty( $inp['access_pass'] ) ) throw new Exception( "アクセスパスワードが未設定です", 2 );
            if ( !isset( $inp['job_cd'] ) || empty( $inp['job_cd'] ) ) throw new Exception( "処理区分が未設定です", 3 );

            // 入力パラメータクラス
            $input = new AlterTranInput();
            // パラメータの設定
            $input->setShopId( Config::get('paymentapi.gmo_shop_id') );
            $input->setShopPass( Config::get('paymentapi.gmo_shop_pwd') );
            $input->setAccessId( $inp['access_id'] );
            $input->setAccessPass( $inp['access_pass'] );
            $input->setJobCd( $inp['job_cd'] );

            // APIクラス
            $exe = new AlterTran();
            // 実行メソッド
            $output = $exe->exec( $input );

            // APIの戻り値を返す
            parse_str( $output->toString(), $detail );
            $res['detail'] = $detail;

            // エラーの確認
            if ( $output->isErrorOccurred() ) {
                throw new Exception( $detail['errInfo'], 99 );
            }
        } catch ( Exception $e ) {
            $res['error'] = true;
            $res['error_id'] = $e->getCode();
            $res['error_msg'] = $e->getMessage();
            // エラー情報をログに出力する
            Log::error( __FUNCTION__.' :'.json_encode( $res, JSON_UNESCAPED_UNICODE ) );
        }

        // 処理結果をログに出力する
        Log::info( __FUNCTION__.' end:'.json_encode( $res, JSON_UNESCAPED_UNICODE ) );
        return $res;
    }


    public function gmoCardCapture( $inp )
    {
        // 処理情報をログに出力する
        Log::info( __FUNCTION__.' start:'.json_encode( $inp, JSON_UNESCAPED_UNICODE ) );

        $res['error'] = false;
        try {
            // 引数チェック
            if ( !isset( $inp['access_id'] ) || empty( $inp['access_id'] ) ) throw new Exception( "アクセスIDが未設定です", 1 );
            if ( !isset( $inp['access_pass'] ) || empty( $inp['access_pass'] ) ) throw new Exception( "アクセスパスワードが未設定です", 2 );
            if ( !isset( $inp['amount'] ) || empty( $inp['amount'] ) ) throw new Exception( "実売上金額が未設定です", 3 );
            if ( $inp['amount'] < 0 ) throw new Exception( "実売上金額がマイナスです", 4 );

            // 入力パラメータクラス
            $input = new AlterTranInput();
            // パラメータの設定
            $input->setShopId( Config::get('paymentapi.gmo_shop_id') );
            $input->setShopPass( Config::get('paymentapi.gmo_shop_pwd') );
            $input->setAccessId( $inp['access_id'] );
            $input->setAccessPass( $inp['access_pass'] );
            $input->setJobCd( 'SALES' );    // 実売上
            $input->setAmount( $inp['amount'] );
            if ( isset( $inp['display_date'] ) && !empty( $inp['display_date'] ) ) {
               $input->setDisplayDate( $inp['display_date'] ); // YY/MM/DD
            }
 
            // APIクラス
            $exe = new AlterTran();
            // 実行メソッド
            $output = $exe->exec( $input );

            // APIの戻り値を返す
            parse_str( $output->toString(), $detail );
            $res['detail'] = $detail;

            // エラーの確認
            if ( $output->isErrorOccurred() ) {
                throw new Exception( $detail['errInfo'], 99 );
            }
        } catch ( Exception $e ) {
            $res['error'] = true;
            $res['error_id'] = $e->getCode();
            $res['error_msg'] = $e->getMessage();
            // エラー情報をログに出力する
            Log::error( __FUNCTION__.' :'.json_encode( $res, JSON_UNESCAPED_UNICODE ) );
        }

        // 処理結果をログに出力する
        Log::info( __FUNCTION__.' end:'.json_encode( $res, JSON_UNESCAPED_UNICODE ) );
        return $res;
    }


    public function gmoGetMultiEntryParam( $inp, $type = '1' ) {
        // 処理情報をログに出力する
        //Log::info( __FUNCTION__.' start:'.$item_name.','.$order_id.','.$amount.','.$member_id.','.$template.','.$response_url );

        $item_name = $inp['item_name'];
        $order_id = $inp['order_id'];
        $amount = $inp['amount'];
        $member_id = $inp['member_id'];
        $template_no = $inp['template_no'];
        $response_url = $inp['response_url'];
        $cancel_url = $inp['cancel_url'];

        // 日時情報
	    date_default_timezone_set('Asia/Tokyo');		// タイムゾーン設定
	    $entry_date = date('YmdHis');

	    // ショップ情報チェック文字列
	    $shop_info = Config::get('paymentapi.gmo_shop_id').'|'.$order_id.'|'.$amount.'||'.Config::get('paymentapi.gmo_shop_pwd').'|'.$entry_date;
	    $shop_info_md5 = md5($shop_info);

	    // 会員情報チェック文字列（購入時）
	    $member_info_buy = Config::get('paymentapi.gmo_site_id').'|'.$member_id.'|'.Config::get('paymentapi.gmo_site_pwd').'|'.$entry_date;
	    $member_info_buy_md5 = md5($member_info_buy);

        $res = "";
	    $res = $res.'<input type="hidden" name="ShopID" value="'.Config::get('paymentapi.gmo_shop_id').'">';
	    $res = $res.'<input type="hidden" name="OrderID" value="'.$order_id.'">';
	    $res = $res.'<input type="hidden" name="Amount" value="'.$amount.'">';
        $res = $res.'<input type="hidden" name="DateTime" value="'.$entry_date.'">';
        $res = $res.'<input type="hidden" name="ShopPassString" value="'.$shop_info_md5.'">';
        $res = $res.'<input type="hidden" name="RetURL" value="'.$response_url.'">';
        $res = $res.'<input type="hidden" name="CancelURL" value="'.$cancel_url.'">';
        if ($type == '5')
	        $res = $res.'<input type="hidden" name="UseRakutenId" value="1">';	// 楽天ペイを使用する
	    else
	        $res = $res.'<input type="hidden" name="UseCredit" value="1">';			// クレジットカードを使用する
//        $res = $res.'<input type="hidden" name="RakutenIdItemId" value="'.$order_id.'">';	// 楽天ペイを使用する
        $res = $res.'<input type="hidden" name="RakutenIdItemName" value="'.$item_name.'">';
        $res = $res.'<input type="hidden" name="TemplateNo" value="'.$template_no.'">';
        if ($type == '5')
	        $res = $res.'<input type="hidden" name="JobCd" value="AUTH">';
	    else
	        $res = $res.'<input type="hidden" name="JobCd" value="'.Config::get('paymentapi.gmo_job_cd').'">';

        if ( $member_id == '' ) {
            $res = $res.'<input type="hidden" name="SiteID" value="">';
            $res = $res.'<input type="hidden" name="MemberID" value="">';
            $res = $res.'<input type="hidden" name="MemberPassString" value="">';
        } else {
            $res = $res.'<input type="hidden" name="SiteID" value="'.Config::get('paymentapi.gmo_site_id').'">';
            $res = $res.'<input type="hidden" name="MemberID" value="'.$member_id.'">';
            $res = $res.'<input type="hidden" name="MemberPassString" value="'.$member_info_buy_md5.'">';
        }

        return $res;
    }

    public function gmoGetMemberEditParam( $inp ) {
        // 処理情報をログに出力する
        //Log::info( __FUNCTION__.' start:'.$member_id.','.$member_name.','.$template.','.$response_url );

        $member_id = $inp['member_id'];
        $member_name = $inp['member_name'];
        $template_no = $inp['template_no'];
        $response_url = $inp['response_url'];
        $cancel_url = $inp['cancel_url'];

        // 日時情報
	    date_default_timezone_set('Asia/Tokyo');		// タイムゾーン設定
	    $entry_date = date('YmdHis');

        // 会員情報チェック文字列（編集時）
	    $member_info = Config::get('paymentapi.gmo_site_id').'|'.$member_id.'|'.Config::get('paymentapi.gmo_shop_id').'|'.Config::get('paymentapi.gmo_site_pwd').'|'.$entry_date;
	    $member_info_md5 = md5($member_info);

        $res = "";
	    $res = $res.'<input type="hidden" name="SiteID" value="'.Config::get('paymentapi.gmo_site_id').'">';
	    $res = $res.'<input type="hidden" name="MemberID" value="'.$member_id.'">';
	    $res = $res.'<input type="hidden" name="MemberName" value="'.$member_name.'">';
	    $res = $res.'<input type="hidden" name="ShopID" value="'.Config::get('paymentapi.gmo_shop_id').'">';
	    $res = $res.'<input type="hidden" name="MemberPassString" value="'.$member_info_md5.'">';
	    $res = $res.'<input type="hidden" name="RetURL" value="'.$response_url.'">';
	    $res = $res.'<input type="hidden" name="CancelURL" value="'.$cancel_url.'">';
	    $res = $res.'<input type="hidden" name="DateTime" value="'.$entry_date.'">';
        $res = $res.'<input type="hidden" name="TemplateNo" value="'.$template_no.'">';

        return $res;
    }
    
    public function gmoGetLinkTypeInfo() {
	    return array(
        	'url_multi_entry' => Config::get('paymentapi.gmo_url_multi_entry'),
            'url_member_edit' => Config::get('paymentapi.gmo_url_member_edit'),
            );
    }

    //***************************************************
    // リンクタイプの戻り値を確認する
    // ※表示は呼び出し側の処理、戻り値の設定のみにする
    //***************************************************
    function gmoResponseCheck( $post )
    {
        // 処理情報をログに出力する
        Log::info( __FUNCTION__.' start:'.json_encode( $post, JSON_UNESCAPED_UNICODE ) );

        $res['error'] = false;
        try {
            if ( isset( $post['PayType'] ) ) {
                $res['order_id'] = $_POST['OrderID'];
                $res['pay_type'] = $_POST['PayType'];	// 決済方法
                if ( !empty( $_POST['ErrInfo'] ) ) {
                    throw new Exception( $_POST['ErrInfo'], 99 );
                }
            }
        } catch ( Exception $e ) {
            $res['error'] = true;
            $res['error_id'] = $e->getCode();
            $res['error_msg'] = $e->getMessage();
            // エラー情報をログに出力する
            Log::error( __FUNCTION__.' :'.json_encode( $res, JSON_UNESCAPED_UNICODE ) );
        }

        // 処理結果をログに出力する
        Log::info( __FUNCTION__.' end:'.json_encode( $res, JSON_UNESCAPED_UNICODE ) );
        return $res;
    }











    public function amazonGetSellerInfo() {
	    return array(
           	'merchant_id' => Config::get('paymentapi.amazon_merchant_id'),
    	    'access_key'  => Config::get('paymentapi.amazon_access_key'),
        	'secret_key'  => Config::get('paymentapi.amazon_secret_key'),
        	'client_id'   => Config::get('paymentapi.amazon_client_id'),
    	    'region'      => Config::get('paymentapi.amazon_region'),
    	    'currency_code' => Config::get('paymentapi.amazon_currency_code'),
    	    'sandbox'     => Config::get('paymentapi.amazon_sandbox')
	        );
    }

    public function amazonGetWidgetInfo() {
	    return array(
    	    'merchant_id' => Config::get('paymentapi.amazon_merchant_id'),
            'client_id'   => Config::get('paymentapi.amazon_client_id'),
            'url_widget_js' => Config::get('paymentapi.amazon_url_widget_js'),
	        );
    }

    //******************************************
    // 注文情報取得処理
    // order_reference_id：Amazonログインで取得したOrderReferenceID
    //******************************************
    public function amazonGetOrderDetails( $inp )
    {
        // 処理情報をログに出力する
        Log::info( __FUNCTION__.' start:'.json_encode( $inp, JSON_UNESCAPED_UNICODE ) );

        $res['error'] = false;
        try {
            // 引数チェック
            if ( !isset( $inp['order_reference_id'] ) || empty( $inp['order_reference_id'] ) ) throw new Exception( "orderReferenceIdが未設定です", 1 );
            if ( !isset( $inp['access_token'] ) || empty( $inp['access_token'] ) ) throw new Exception( "accessTokenが未設定です", 2 );
    
            $config = $this->amazonGetSellerInfo();
            $client = new Client($config);

            // 購入者情報を取得
            $params = [];
            $params['amazon_order_reference_id'] = $inp['order_reference_id'];
            $params['access_token'] = $inp['access_token'];
            // API呼び出し
            $orderReferenceDetailsResponse = $client->getOrderReferenceDetails( $params );
            $orderReferenceDetailsArray = $orderReferenceDetailsResponse->toArray();
            // APIの戻り値を全て返す
            $res['detail'] = $orderReferenceDetailsArray;
            if ( $orderReferenceDetailsArray['ResponseStatus'] != 200 )
                throw new Exception( $orderReferenceDetailsArray['Error']['Message'], $orderReferenceDetailsArray['ResponseStatus'] );

            // 購入者詳細情報
            $refDetails = $orderReferenceDetailsArray['GetOrderReferenceDetailsResult']['OrderReferenceDetails'];
            $res['prefectures'] = $refDetails['Destination']['PhysicalDestination']['StateOrRegion'];
            $res['phone'] = $refDetails['Destination']['PhysicalDestination']['Phone'];
            $res['postal_cd'] = $refDetails['Destination']['PhysicalDestination']['PostalCode'];
            $res['name'] = $refDetails['Destination']['PhysicalDestination']['Name'];
            $res['address1'] = $refDetails['Destination']['PhysicalDestination']['AddressLine1'];
            $res['email'] = $refDetails['Buyer']['Email'];
            // AddressLine2／AddressLine3は本番環境のみ存在
            $res['address2'] = '';
            if ( array_key_exists( 'AddressLine2', $refDetails['Destination']['PhysicalDestination'] ) )
                $res['address2'] = $refDetails['Destination']['PhysicalDestination']['AddressLine2'];
            $res['address3'] = '';
            if ( array_key_exists( 'AddressLine3', $refDetails['Destination']['PhysicalDestination'] ) )
                $res['address3'] = $refDetails['Destination']['PhysicalDestination']['AddressLine3'];

        } catch ( Exception $e ) {
            $res['error'] = true;
            $res['error_id'] = $e->getCode();
            $res['error_msg'] = $e->getMessage();
            // エラー情報をログに出力する
            Log::error( __FUNCTION__.' :'.json_encode( $res, JSON_UNESCAPED_UNICODE ) );
       }
        
         // 処理結果をログに出力する
         Log::info( __FUNCTION__.' end:'.json_encode( $res, JSON_UNESCAPED_UNICODE ) );
         return $res;
    }

    //******************************************
    // 仮売上（与信枠確保）処理
    // order_reference_id：Amazonログインで取得したOrderReferenceID
    // access_token：Amazonログインで取得したAccessToken
    // order_id：システム側で管理する注文番号
    // amount：決済金額
    //******************************************
    public function amazonAuthorize( $inp )
    {
        // 処理情報をログに出力する
        Log::info( __FUNCTION__.' start:'.json_encode( $inp, JSON_UNESCAPED_UNICODE ) );

        $res['error'] = false;
        try {
            // 引数チェック
            if ( !isset( $inp['order_reference_id'] ) || empty( $inp['order_reference_id'] ) ) throw new Exception( "orderReferenceIdが未設定です", 1 );
            if ( !isset( $inp['access_token'] ) || empty( $inp['access_token'] ) ) throw new Exception( "accessTokenが未設定です", 2 );
            if ( !isset( $inp['order_id'] ) || empty( $inp['order_id'] ) ) throw new Exception( "注文番号が未設定です", 3 );
            if ( !isset( $inp['amount'] ) || empty( $inp['amount'] ) ) throw new Exception( "決済金額が未設定です", 4 );
            if ( $inp['amount'] < 0 ) throw new Exception( "決済金額がマイナスです", 5 );

            $config = $this->amazonGetSellerInfo();
            $client = new Client($config);
Log::debug(__FUNCTION__.'amazonGetSellerInfo');
            // 注文詳細のセット 
            $params = [];
            $params['amazon_order_reference_id'] = $inp['order_reference_id'];
            $params['amount'] = $inp['amount'];             // 注文金額
            $params['seller_order_id'] = $inp['order_id'];  // サイト側注文番号
            // API呼び出し
            $setOrderReferenceDetailsResponse = $client->setOrderReferenceDetails( $params );
            $setOrderReferenceDetailsArray = $setOrderReferenceDetailsResponse->toArray();
Log::debug(__FUNCTION__.'setOrderReferenceDetails');
Log::debug(var_export($inp, true));
Log::debug(var_export($setOrderReferenceDetailsArray, true));

            if ( $setOrderReferenceDetailsArray['ResponseStatus'] != 200 ) 
                throw new Exception( $setOrderReferenceDetailsArray['Error']['Message'], $setOrderReferenceDetailsArray['ResponseStatus'] );
        
            // 注文詳細の確認（Order Referenceオブジェクト→Open）
            $params = [];
            $params['amazon_order_reference_id'] = $inp['order_reference_id'];
            // API呼び出し
            $confirmOrderReferenceResponse = $client->confirmOrderReference( $params );
            $confirmOrderReferenceArray = $confirmOrderReferenceResponse->toArray();
Log::debug(__FUNCTION__.'confirmOrderReference');
            if ( $confirmOrderReferenceArray['ResponseStatus'] != 200 ) 
                throw new Exception( $confirmOrderReferenceArray['Error']['Message'] );
        
            // 購入者情報を取得
            $params = [];
            $params['amazon_order_reference_id'] = $inp['order_reference_id']; 
            $params['access_token'] = $inp['access_token'];
            // API呼び出し
            $orderReferenceDetailsResponse = $client->getOrderReferenceDetails( $params );
            $orderReferenceDetailsArray = $orderReferenceDetailsResponse->toArray();
Log::debug(__FUNCTION__.'getOrderReferenceDetails');
            if ( $orderReferenceDetailsArray['ResponseStatus'] != 200 )
                throw new Exception( $orderReferenceDetailsArray['Error']['Message'], $orderReferenceDetailsArray['ResponseStatus'] );
            // 購入者詳細情報
            $refDetails = $orderReferenceDetailsArray['GetOrderReferenceDetailsResult']['OrderReferenceDetails'];
            $res['prefectures'] = $refDetails['Destination']['PhysicalDestination']['StateOrRegion'];
            $res['phone'] = $refDetails['Destination']['PhysicalDestination']['Phone'];
            $res['postal_cd'] = $refDetails['Destination']['PhysicalDestination']['PostalCode'];
            $res['name'] = $refDetails['Destination']['PhysicalDestination']['Name'];
            $res['address1'] = $refDetails['Destination']['PhysicalDestination']['AddressLine1'];
            $res['email'] = $refDetails['Buyer']['Email'];
            // AddressLine2／AddressLine3は本番環境のみ存在
            $res['address2'] = '';
            if ( array_key_exists( 'AddressLine2', $refDetails['Destination']['PhysicalDestination'] ) )
                $res['address2'] = $refDetails['Destination']['PhysicalDestination']['AddressLine2'];
            $res['address3'] = '';
            if ( array_key_exists( 'AddressLine3', $refDetails['Destination']['PhysicalDestination'] ) )
                $res['address3'] = $refDetails['Destination']['PhysicalDestination']['AddressLine3'];
        
            // オーソリ、与信確保
            $params = [];
            $params['amazon_order_reference_id'] = $inp['order_reference_id'];
            $params['authorization_amount'] = $inp['amount'];
            $params['authorization_reference_id'] = time();     // ユニークなID
            $params['transaction_timeout'] = 0;                 // 同期モードでは「0」
            $params['capture_now'] = false;                     // true：即時売上、false：仮売上
            // API呼び出し
            $authorizeResponse = $client->authorize( $params );
            $authorizeArray = $authorizeResponse->toArray();
            // APIの戻り値を全て返す
            $res['detail'] = $authorizeArray;
Log::debug(__FUNCTION__.'authorize');
            if ( $authorizeArray['ResponseStatus'] != 200 ) 
                throw new Exception( $authorizeArray['Error']['Message'], $authorizeArray['ResponseStatus'] );

            // レスポンス情報の取得
            $authorizationDetails = $authorizeArray['AuthorizeResult']['AuthorizationDetails'];

            // オーソリ結果の確認（Pending／Open／Declined／Closed）
            $authorizationState = $authorizationDetails['AuthorizationStatus']['State'];
    
            //  Open（通常Open状態となる）
            if ( $authorizationState == 'Open' ) {
                // オーソリIDを返す
                $res['amazon_authorization_id'] = $authorizationDetails['AmazonAuthorizationId'];
            }

            //  Pending（通常Pending状態にはならない）
            else if ( $authorizationState == 'Pending' ) {
                // 異常状態なので注文をキャンセル
                $params = [];
                $params['amazon_order_reference_id'] = $inp['order_reference_id'];
                $cancelOrderReferenceResponse = $client->cancelOrderReference( $params );
                $cancelOrderReferenceArray = $cancelOrderReferenceResponse->toArray();
Log::debug(__FUNCTION__.'cancelOrderReference');
                if ( $cancelOrderReferenceArray['ResponseStatus'] != 200 ) 
                    throw new Exception( $cancelOrderReferenceArray['Error']['Message'], $cancelOrderReferenceArray['ResponseStatus'] );
            }
        
            //  Declined
            else if ( $authorizationState == 'Declined' ) { 
                $authorizationStatusReasonCode = $authorizationDetails['AuthorizationStatus']['ReasonCode'];
                switch ($authorizationStatusReasonCode) {
                    case 'InvalidPaymentMethod':
                    case 'ProcessingFailure':
                    case 'TransactionTimedOut':
                        // 異常状態なので注文をキャンセル
                        $params = [];
                        $params['amazon_order_reference_id'] = $inp['order_reference_id'];
                        $cancelOrderReferenceResponse = $client->cancelOrderReference( $params );
                        $cancelOrderReferenceArray = $cancelOrderReferenceResponse->toArray();
Log::debug(__FUNCTION__.'cancelOrderReference');
                        if ( $cancelOrderReferenceArray['ResponseStatus'] != 200 ) 
                            throw new Exception( $cancelOrderReferenceArray['Error']['Message'], $cancelOrderReferenceArray['ResponseStatus'] );
                        throw new Exception( "オーソリに失敗しました。再度注文してください。", 101 );
                        break;
                    case 'AmazonRejected':
Log::debug(__FUNCTION__.'AmazonRejected');
                        throw new Exception( "決済時に問題が発生しました、別の支払い方法を選択してください。", 102 );          
                        break;
                    default:
Log::debug(__FUNCTION__.'other');
                        throw new Exception( "予定外のReasonCode", 103 );
                        break;
                }
            }    
        
            //  Closed
            else if ( $authorizationState == 'Closed' ) {
                // 異常状態なので注文をキャンセル
                $params = [];
                $params['amazon_order_reference_id'] = $inp['order_reference_id'];
                $cancelOrderReferenceResponse = $client->cancelOrderReference( $params );
                $cancelOrderReferenceArray = $cancelOrderReferenceResponse->toArray();
Log::debug(__FUNCTION__.'cancelOrderReference');
                if ( $cancelOrderReferenceArray['ResponseStatus'] != 200 ) 
                    throw new Exception( $cancelOrderReferenceArray['Error']['Message'], $cancelOrderReferenceArray['ResponseStatus'] );
            }       

        } catch ( Exception $e ) {
            $res['error'] = true;
            $res['error_id'] = $e->getCode();
            $res['error_msg'] = $e->getMessage();
            // エラー情報をログに出力する
            Log::error( __FUNCTION__.' :'.json_encode( $res, JSON_UNESCAPED_UNICODE ) );
       }
        
         // 処理結果をログに出力する
         Log::info( __FUNCTION__.' end:'.json_encode( $res, JSON_UNESCAPED_UNICODE ) );
         return $res;
    }


    //******************************************
    // 売上請求処理
    // amazon_authorization_id：与信枠確保で取得したAuthorizationId
    // amount：売上請求金額
    // seller_capture_note：購入者へのメールに表示される説明　※オプション
    // soft_descriptor：購入者の請求明細に表示される説明（JCBのみ有効）　※オプション
    //******************************************
    public function amazonCapture( $inp )
    {
        // 処理情報をログに出力する
        Log::info( __FUNCTION__.' start:'.json_encode( $inp, JSON_UNESCAPED_UNICODE ) );

        $res['error'] = false;
        try {
            // 引数チェック
            if ( !isset( $inp['amazon_authorization_id'] ) || empty( $inp['amazon_authorization_id'] ) ) throw new Exception( "AuthorizationIdが未設定です", 1 );
            if ( !isset( $inp['amount'] ) || empty( $inp['amount'] ) ) throw new Exception( "売上請求金額が未設定です", 2 );
            if ( $inp['amount'] < 0 ) throw new Exception( "売上請求金額がマイナスです", 3 );

            $config = $this->amazonGetSellerInfo();
            $client = new Client($config);

            // 注文詳細のセット 
            $params = [];
            $params['amazon_authorization_id'] = $inp['amazon_authorization_id'];
            $params['capture_reference_id'] = 'capture-'.time();    // ユニークなコード
            $params['capture_amount'] = $inp['amount'];             // 注文金額
            if ( isset( $inp['seller_capture_note'] ) && !empty( $inp['seller_capture_note'] ) ) {
                // 購入者へのメールに表示される説明
                $params['seller_capture_note'] = $inp['seller_capture_note'];    
            }
            if ( isset( $inp['soft_descriptor'] ) && !empty( $inp['soft_descriptor'] ) ) {
                // 購入者の請求明細に表示される説明（JCBのみ有効）
                $params['soft_descriptor'] = $inp['soft_descriptor'];
            }

            // API呼び出し
            $captureResponse = $client->capture($params);
            $captureArray = $captureResponse->toArray();

            // APIの戻り値を全て返す
            $res['detail'] = $captureArray;
            // エラー判定
            if ( $captureArray['ResponseStatus'] != 200 ) {
                throw new Exception( $captureArray['Error']['Message'], $captureArray['ResponseStatus'] );
            } else {
                // 売上請求ID、売上請求ステータスも返す
                $res['amazon_capture_id'] = $captureArray['CaptureResult']['CaptureDetails']['AmazonCaptureId'];
                $res['capture_state'] = $captureArray['CaptureResult']['CaptureDetails']['CaptureStatus']['State'];
            }

        } catch ( Exception $e ) {
            $res['error'] = true;
            $res['error_id'] = $e->getCode();
            $res['error_msg'] = $e->getMessage();
            // エラー情報をログに出力する
            Log::error( __FUNCTION__.' :'.json_encode( $res, JSON_UNESCAPED_UNICODE ) );
       }
        
         // 処理結果をログに出力する
         Log::info( __FUNCTION__.' end:'.json_encode( $res, JSON_UNESCAPED_UNICODE ) );
         return $res;
    }

    //******************************************
    // 即時売上処理
    // order_reference_id：Amazonログインで取得したOrderReferenceID
    // access_token：Amazonログインで取得したAccessToken
    // order_id：システム側で管理する注文番号
    // amount：決済金額
    // seller_authorization_note：購入者のメールに表示される説明　※オプション
    // soft_descriptor：購入者の請求明細に表示される説明（JCBのみ有効）　※オプション
    //******************************************
    public function amazonCaptureNow( $inp )
    {
        // 処理情報をログに出力する
        Log::info( __FUNCTION__.' start:'.json_encode( $inp, JSON_UNESCAPED_UNICODE ) );

        $res['error'] = false;
        try {
            // 引数チェック
            if ( !isset( $inp['order_reference_id'] ) || empty( $inp['order_reference_id'] ) ) throw new Exception( "orderReferenceIdが未設定です", 1 );
            if ( !isset( $inp['access_token'] ) || empty( $inp['access_token'] ) ) throw new Exception( "accessTokenが未設定です", 2 );
            if ( !isset( $inp['order_id'] ) || empty( $inp['order_id'] ) ) throw new Exception( "注文番号が未設定です", 3 );
            if ( !isset( $inp['amount'] ) || empty( $inp['amount'] ) ) throw new Exception( "決済金額が未設定です", 4 );
            if ( $inp['amount'] < 0 ) throw new Exception( "決済金額がマイナスです", 5 );

            $config = $this->amazonGetSellerInfo();
            $client = new Client($config);

            // 注文詳細のセット 
            $params = [];
            $params['amazon_order_reference_id'] = $inp['order_reference_id'];
            $params['amount'] = $inp['amount'];             // 注文金額
            $params['seller_order_id'] = $inp['order_id'];  // サイト側注文番号
            // API呼び出し
            $setOrderReferenceDetailsResponse = $client->setOrderReferenceDetails( $params );
            $setOrderReferenceDetailsArray = $setOrderReferenceDetailsResponse->toArray();
            if ( $setOrderReferenceDetailsArray['ResponseStatus'] != 200 ) 
                throw new Exception( $setOrderReferenceDetailsArray['Error']['Message'], $setOrderReferenceDetailsArray['ResponseStatus'] );
        
            // 注文詳細の確認（Order Referenceオブジェクト→Open）
            $params = [];
            $params['amazon_order_reference_id'] = $inp['order_reference_id'];
            // API呼び出し
            $confirmOrderReferenceResponse = $client->confirmOrderReference( $params );
            $confirmOrderReferenceArray = $confirmOrderReferenceResponse->toArray();
            if ( $confirmOrderReferenceArray['ResponseStatus'] != 200 ) 
                throw new Exception( $confirmOrderReferenceArray['Error']['Message'] );
        
            // 購入者情報を取得
            $params = [];
            $params['amazon_order_reference_id'] = $inp['order_reference_id']; 
            $params['access_token'] = $inp['access_token'];
            // API呼び出し
            $orderReferenceDetailsResponse = $client->getOrderReferenceDetails( $params );
            $orderReferenceDetailsArray = $orderReferenceDetailsResponse->toArray();
            if ( $orderReferenceDetailsArray['ResponseStatus'] != 200 )
                throw new Exception( $orderReferenceDetailsArray['Error']['Message'], $orderReferenceDetailsArray['ResponseStatus'] );
            // 購入者詳細情報
            $refDetails = $orderReferenceDetailsArray['GetOrderReferenceDetailsResult']['OrderReferenceDetails'];
            $res['prefectures'] = $refDetails['Destination']['PhysicalDestination']['StateOrRegion'];
            $res['phone'] = $refDetails['Destination']['PhysicalDestination']['Phone'];
            $res['postal_cd'] = $refDetails['Destination']['PhysicalDestination']['PostalCode'];
            $res['name'] = $refDetails['Destination']['PhysicalDestination']['Name'];
            $res['address1'] = $refDetails['Destination']['PhysicalDestination']['AddressLine1'];
            $res['email'] = $refDetails['Buyer']['Email'];
            // AddressLine2／AddressLine3は本番環境のみ存在
            $res['address2'] = '';
            if ( array_key_exists( 'AddressLine2', $refDetails['Destination']['PhysicalDestination'] ) )
                $res['address2'] = $refDetails['Destination']['PhysicalDestination']['AddressLine2'];
            $res['address3'] = '';
            if ( array_key_exists( 'AddressLine3', $refDetails['Destination']['PhysicalDestination'] ) )
                $res['address3'] = $refDetails['Destination']['PhysicalDestination']['AddressLine3'];
        
            // オーソリ、与信確保
            $params = [];
            $params['amazon_order_reference_id'] = $inp['order_reference_id'];
            $params['authorization_amount'] = $inp['amount'];
            $params['authorization_reference_id'] = time();     // ユニークなID
            $params['transaction_timeout'] = 0;             // 同期モードでは「0」
            $params['capture_now'] = true;                  // true：即時売上、false：仮売上
            //$params['seller_authorization_note'] = '';      // 購入者の請求明細に表示される説明(JCBの場合のみ有効) 
            if ( isset( $inp['seller_authorization_note'] ) && !empty( $inp['seller_authorization_note'] ) ) {
                // 購入者へのメールに表示される説明
                $params['seller_authorization_note'] = $inp['seller_authorization_note'];    
            }
            if ( isset( $inp['soft_descriptor'] ) && !empty( $inp['soft_descriptor'] ) ) {
                // 購入者の請求明細に表示される説明（JCBのみ有効）
                $params['soft_descriptor'] = $inp['soft_descriptor'];
            }
            // API呼び出し
            $authorizeResponse = $client->authorize( $params );
            $authorizeArray = $authorizeResponse->toArray();
            // APIの戻り値を全て返す
            $res['detail'] = $authorizeArray;
            if ( $authorizeArray['ResponseStatus'] != 200 ) 
                throw new Exception( $authorizeArray['Error']['Message'], $authorizeArray['ResponseStatus'] );

            // レスポンス情報の取得
            $authorizationDetails = $authorizeArray['AuthorizeResult']['AuthorizationDetails'];

            // オーソリ結果の確認（Pending／Open／Declined／Closed）
            $authorizationState = $authorizationDetails['AuthorizationStatus']['State'];

            //  Pending（通常Pending状態にはならない）
            if ( $authorizationState == 'Pending' ) {
                // 異常状態なので注文をキャンセル
                $params = [];
                $params['amazon_order_reference_id'] = $inp['order_reference_id'];
                $cancelOrderReferenceResponse = $client->cancelOrderReference( $params );
                $cancelOrderReferenceArray = $cancelOrderReferenceResponse->toArray();
                if ( $cancelOrderReferenceArray['ResponseStatus'] != 200 ) 
                    throw new Exception( $cancelOrderReferenceArray['Error']['Message'], $cancelOrderReferenceArray['ResponseStatus'] );
            }
        
            //  Declined（通常Declined状態にはならない）
            else if ( $authorizationState == 'Declined' ) { 
                $authorizationStatusReasonCode = $authorizationDetails['AuthorizationStatus']['ReasonCode'];
                switch ($authorizationStatusReasonCode) {
                    case 'InvalidPaymentMethod':
                    case 'ProcessingFailure':
                    case 'TransactionTimedOut':
                        // 異常状態なので注文をキャンセル
                        $params = [];
                        $params['amazon_order_reference_id'] = $inp['order_reference_id'];
                        $cancelOrderReferenceResponse = $client->cancelOrderReference( $params );
                        $cancelOrderReferenceArray = $cancelOrderReferenceResponse->toArray();
                        if ( $cancelOrderReferenceArray['ResponseStatus'] != 200 ) 
                            throw new Exception( $cancelOrderReferenceArray['Error']['Message'], $cancelOrderReferenceArray['ResponseStatus'] );
                        throw new Exception( "オーソリに失敗しました。再度注文してください。", 101 );
                        break;
                    case 'AmazonRejected':
                        throw new Exception( "決済時に問題が発生しました、別の支払い方法を選択してください。", 102 );          
                        break;
                    default:
                        throw new Exception( "予定外のReasonCode", 103 );
                        break;
                }
            }    
    
            //  Open（即時売上請求では、通常Open状態にはならない）
            else if ( $authorizationState == 'Open' ) {

            }
        
            //  Closed（即時売上請求の場合は、即Closedになる）
            else if ( $authorizationState == 'Closed' ) {
                $authorizationStatusReasonCode = $authorizationDetails['AuthorizationStatus']['ReasonCode'];
                if ($authorizationStatusReasonCode == 'MaxCapturesProcessed') {
                    // 売上請求IDも返す
                    $res['amazon_capture_id'] = $authorizationDetails['IdList']['member'];
                }
            }       

        } catch ( Exception $e ) {
            $res['error'] = true;
            $res['error_id'] = $e->getCode();
            $res['error_msg'] = $e->getMessage();
            // エラー情報をログに出力する
            Log::error( __FUNCTION__.' :'.json_encode( $res, JSON_UNESCAPED_UNICODE ) );
       }
        
         // 処理結果をログに出力する
         Log::info( __FUNCTION__.' end:'.json_encode( $res, JSON_UNESCAPED_UNICODE ) );
         return $res;
    }


    //******************************************
    // キャンセルリクエスト処理
    // order_reference_id：Amazonログインで取得したOrderReferenceID
    // reason：キャンセルした理由(1024文字) ※オプション
    //******************************************
    function amazonCancel( $inp )
    {
        // 処理情報をログに出力する
        Log::info( __FUNCTION__.' start:'.json_encode( $inp, JSON_UNESCAPED_UNICODE ) );

        $res['error'] = false;
        try {
            // 引数チェック
            if ( !isset( $inp['order_reference_id'] ) || empty( $inp['order_reference_id'] ) ) throw new Exception( 'amazonOrderReferenceIdが未設定です', 1 );

            $config = $this->amazonGetSellerInfo();
            $client = new Client($config);

            $params = [];
            $params['amazon_order_reference_id'] = $inp['order_reference_id'];
            if ( isset( $inp['reason'] ) && !empty( $inp['reason'] ) ) {
                $params['cancelation_reason'] = $inp['reason'];
            }
            // キャンセルAPI呼び出し
            $refundResponse = $client->CancelOrderReference( $params );
            $refundArray = $refundResponse->toArray();
            // APIの戻り値を全て返す
            $res['detail'] = $refundArray;
            // エラー判定
            if ( $refundArray['ResponseStatus'] != 200 ) {
                throw new Exception( $refundArray['Error']['Message'], $refundArray['ResponseStatus'] );
            }

        } catch ( Exception $e ) {
            $res['error'] = true;
            $res['error_id'] = $e->getCode();
            $res['error_msg'] = $e->getMessage();
            // エラー情報をログに出力する
            Log::error( __FUNCTION__.' :'.json_encode( $res, JSON_UNESCAPED_UNICODE ) );
        }
        
        // 処理結果をログに出力する
        Log::info( __FUNCTION__.' end:'.json_encode( $res, JSON_UNESCAPED_UNICODE ) );
        return $res;
    }


    //******************************************
    // 一括返金リクエスト処理
    // refundData：Array(amazonCaptureId：売上請求ID, amount：返金金額)
    //******************************************
    function amazonRefundOnce( $refundData )
    {
        // 処理情報をログに出力する
        Log::info( __FUNCTION__.' start:'.json_encode( $refundData, JSON_UNESCAPED_UNICODE ) );

        $res_array['error'] = false;
        foreach ($refundData as $rec) {
            //echo $rec['amazonCaptureId'].'-'.$rec['amount'].'<br>';
            $inp = array( 'amazon_capture_id' => $rec['amazon_capture_id'], 'amount' => $rec['amount'] );
            $res = $this->amazonRefund( $inp );
            if ( $res['error'] == true ) {
                $res_array['error'] = true;
                $res_array['err_list'][] = array( 'error_id' => $res['error_id'], 'error_msg' => $res['error_msg'] );
            }
            $res_array['detail_list'][] = $res;
        }

        // 処理結果をログに出力する
        Log::info( __FUNCTION__.' end:'.json_encode( $res_array, JSON_UNESCAPED_UNICODE ) );
        return $res_array;
    }


    //******************************************
    // 返金リクエスト処理
    // amazonCaptureId：売上請求ID
    // amount：返金金額
    //******************************************
    function amazonRefund( $inp )
    {
        // 処理情報をログに出力する
        Log::info( __FUNCTION__.' start:'.json_encode( $inp, JSON_UNESCAPED_UNICODE ) );

        $res['error'] = false;
        try {
            // 引数チェック
            if ( !isset( $inp['amazon_capture_id'] ) || empty( $inp['amazon_capture_id'] ) ) throw new Exception( 'amazonCaptureIdが未設定です', 1 );
            if ( !isset( $inp['amount'] ) || empty( $inp['amount'] ) ) throw new Exception( '決済金額が未設定です', 2 );
            if ( $inp['amount'] < 0 ) throw new Exception( '決済金額がマイナスです', 3 );

            $config = $this->amazonGetSellerInfo();
            $client = new Client($config);

            $params = [];
            $params['amazon_capture_id'] = $inp['amazon_capture_id'];
            $params['refund_reference_id'] = 'refund-'.time();    // ユニークなコード
            $params['refund_amount'] = $inp['amount'];
            // 返金API呼び出し
            $refundResponse = $client->refund( $params );
            $refundArray = $refundResponse->toArray();
            // APIの戻り値を全て返す
            $res['detail'] = $refundArray;
            // エラー判定
            if ( $refundArray['ResponseStatus'] != 200 ) {
                throw new Exception( $refundArray['Error']['Message'], $refundArray['ResponseStatus'] );
            } else {
                // 返金ID、返金ステータスも返す
                $res['amazon_refund_id'] = $refundArray['RefundResult']['RefundDetails']['AmazonRefundId'];
                $res['refund_state'] = $refundArray['RefundResult']['RefundDetails']['RefundStatus']['State'];
            }

        } catch ( Exception $e ) {
            $res['error'] = true;
            $res['error_id'] = $e->getCode();
            $res['error_msg'] = $e->getMessage();
            // エラー情報をログに出力する
            Log::error( __FUNCTION__.' :'.json_encode( $res, JSON_UNESCAPED_UNICODE ) );
        }
        
        // 処理結果をログに出力する
        Log::info( __FUNCTION__.' end:'.json_encode( $res, JSON_UNESCAPED_UNICODE ) );
        return $res;
    }


    //******************************************
    // 返金状況取得処理
    // amazonRefundId：返金ID
    //******************************************
    function amazonRefundDetails( $amazonRefundId )
    {
        // 処理情報をログに出力する
        Log::info( __FUNCTION__.' start:'.json_encode( $inp, JSON_UNESCAPED_UNICODE ) );

        $res['error'] = false;
        try {
            // 引数チェック
            if ( empty( $amazonRefundId ) ) throw new Exception( "amazonRefundIdが未設定です", 1 );

            $config = $this->amazonGetSellerInfo();
            $client = new Client($config);

            $params = [];
            $params['amazon_refund_id'] = $amazonRefundId;
            // 返金状態取得API呼び出し
            $refundDetailResponse = $client->GetRefundDetails( $params );
            $refundDetailArray = $refundDetailResponse->toArray();
            // APIの戻り値を全て返す
            $res['detail'] = $refundDetailArray;
            // 返金ID、返金ステータスも返す
            $res['amazon_refund_id'] = $refundDetailArray['GetRefundDetailsResult']['RefundDetails']['AmazonRefundId'];
            $res['refund_state'] = $refundDetailArray['GetRefundDetailsResult']['RefundDetails']['RefundStatus']['State'];
            // エラー判定
            if ( $refundDetailArray['ResponseStatus'] != 200 ) {
                throw new Exception( $refundDetailArray['Error']['Message'], $refundDetailArray['ResponseStatus'] );
            }
        } catch ( Exception $e ) {
            $res['error'] = true;
            $res['error_id'] = $e->getCode();
            $res['error_msg'] = $e->getMessage();
            // エラー情報をログに出力する
            Log::error( __FUNCTION__.' :'.json_encode( $res, JSON_UNESCAPED_UNICODE ) );
        }
        
         // 処理結果をログに出力する
         Log::info( __FUNCTION__.' end:'.json_encode( $res, JSON_UNESCAPED_UNICODE ) );
        return $res;
    }

    /* AmazonPay API スケルトン
    public function amazonGetOrderDetails( $inp )
    {
        // 処理情報をログに出力する
        Log::info( __FUNCTION__.' start:'.json_encode( $inp, JSON_UNESCAPED_UNICODE ) );

        $res['error'] = false;
        try {
            // 引数チェック
            if ( !isset( $inp['order_reference_id'] ) || empty( $inp['order_reference_id'] ) ) throw new Exception( "orderReferenceIdが未設定です", 1 );
    
            $config = $this->amazonGetSellerInfo();
            $client = new Client($config);

        } catch ( Exception $e ) {
            $res['error'] = true;
            $res['error_id'] = $e->getCode();
            $res['error_msg'] = $e->getMessage();
            // エラー情報をログに出力する
            Log::error( __FUNCTION__.' :'.json_encode( $res, JSON_UNESCAPED_UNICODE ) );
       }
        
         // 処理結果をログに出力する
         Log::info( __FUNCTION__.' end:'.json_encode( $res, JSON_UNESCAPED_UNICODE ) );
         return $res;
    }
    */
}