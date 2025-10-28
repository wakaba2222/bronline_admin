<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"><!--レスポンシブ用-->
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1.0"/><!--レスポンシブ用-->
    <title>注文確認ページ</title>


    <!-- Bootstrap core CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap core JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>


    <!-- Custom styles for this template -->
    <link href="css/shop-confirmation.css" rel="stylesheet">
    <script type='text/javascript'>
      function getURLParameter(name, source) {
          return decodeURIComponent((new RegExp('[?|&amp;|#]' + name + '=' +
                          '([^&;]+?)(&|#|;|$)').exec(source) || [, ""])[1].replace(/\+/g, '%20')) || null;
      }

      var error = getURLParameter("error", location.search);
      if (typeof error === 'string' && error.match(/^access_denied/)) {
        console.log('Amazonアカウントでのサインインをキャンセルされたため、戻る');
        window.location.href = 'https://dev.bronline.jp/paytest';
      }
    </script>

  </head>

  <body>

    <!-- Page Content -->
    <div class="container">

      <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

          <h1 class="my-4">ご注文手続き</h1>

          <?php if (!empty($errorMessage)) :?>
          <div class="alert alert-danger" role="alert">
            <p>エラーが発生しました：</p>
            <?php echo $errorMessage;?>
          </div>
          <?php endif;?>

          <!-- Blog Post -->
          <div class="card mb-4">
            <div class="card-body">
              <h5>お届け先・お支払い方法の選択</h5>
              <div id="addressBookWidgetDiv" style="height:250px"></div>
              <div id="walletWidgetDiv" style="height:250px"></div>
            </div>
          </div>

        </div>

        <!-- Sidebar Widgets Column -->
        <div class="col-md-4">

          <!-- Side Widget -->
          <div class="card my-4">
            <h5 class="card-header">お支払い金額</h5>
            <div class="card-body" id="highlight2">

              <table class="table table-striped">
                  <tbody>
                      <tr>
                          <td><strong>総合計</strong></td>
                          <td class="text-right"><strong>￥<?php echo $amount ?></strong></td>
                      </tr>
                  </tbody>
              </table>
              <div>

              <div>
                <form action="https://dev.bronline.jp/paytest/shop" method="POST">
                  <input type="hidden" name="amount" id="amount" value="<?php echo $amount ?>" />
                  <input type="hidden" name="order_id" id="order_id" value="<?php echo $order_id ?>" />
                  <input type="text" name="orderReferenceId" id="orderReferenceId" value="" />
                  <input type="text" name="accessToken" id="accessToken" value="" />
                  <button type="submit" name="amazon_capture" class="btn btn-block btn-success">購入</button>
                </form>
              </div>

              </br>
              
            </div>
          </div>

        </div>

      </div>
      <!-- /.row -->

    </div>
    <!-- /.container -->


    <!-- Amazon Pay JavaScript -->
    <script type='text/javascript'>
    
    let clientId = "<?php echo $ama['client_id'] ?>"; 
    let sellerId = "<?php echo $ama['merchant_id'] ?>";
    
    
      // get access token
      function getURLParameter(name, source) {
          return decodeURIComponent((new RegExp('[?|&amp;|#]' + name + '=' +
                          '([^&;]+?)(&|#|;|$)').exec(source) || [, ""])[1].replace(/\+/g, '%20')) || null;
      }
      //popup=trueにする場合
      var accessToken = getURLParameter("access_token", location.href);
      // popup=falseにする場合
      // var accessToken = getURLParameter("access_token", location.hash);
      // if (typeof accessToken === 'string' && accessToken.match(/^Atza/)) {
      //     document.cookie = "amazon_Login_accessToken=" + accessToken + ";path=/;secure";
      // }

      window.onAmazonLoginReady = function() {
        amazon.Login.setClientId(clientId);
        amazon.Login.setUseCookie(false); //popup=falseにときに必要

        if (accessToken) {
          document.getElementById("accessToken").value = accessToken;
          amazon.Login.retrieveProfile(accessToken, function (response){
            if (response.success) {
              console.log("Amazon Account Name :" + response.profile.Name);
              console.log("Amazon Account Mail :" + response.profile.PrimaryEmail);
              console.log("Amazon UserId :" + response.profile.CustomerId);
              
            }
          });
        }
      };

      window.onAmazonPaymentsReady = function() {
        showAddressBookWidget();

      };

      function showAddressBookWidget() {
          // AddressBook
          new OffAmazonPayments.Widgets.AddressBook({
            sellerId: sellerId,

            onReady: function (orderReference) {
                var orderReferenceId = orderReference.getAmazonOrderReferenceId();
                
                document.getElementById("orderReferenceId").value = orderReferenceId;
                
                // Wallet
                showWalletWidget(orderReferenceId);
            },
            onAddressSelect: function (orderReference) {    // 住所選択時
                // お届け先の住所が変更された時に呼び出されます、ここで手数料などの再計算ができます。
            },
            design: {
                designMode: 'responsive'
            },
            onError: function (error) {
                // エラー処理
                // エラーが発生した際にonErrorハンドラーを使って処理することをお勧めします。
                // @see https://payments.amazon.com/documentation/lpwa/201954960
                //console.log('OffAmazonPayments.Widgets.AddressBook', error.getErrorCode(), error.getErrorMessage());
                switch (error.getErrorCode()) {
                  case 'AddressNotModifiable':
                      // オーダーリファレンスIDのステータスが正しくない場合は、お届け先の住所を変更することができません。
                      break;
                  case 'BuyerNotAssociated':
                      // 購入者とリファレンスIDが正しく関連付けられていません。
              　　　    // ウィジェットを表示する前に購入者はログインする必要があります。
                      break;
                  case 'BuyerSessionExpired':
                      // 購入者のセッションの有効期限が切れました。
         　　　　        // ウィジェットを表示する前に購入者はログインする必要があります。
                      break;
                  case 'InvalidAccountStatus':
                      // マーチャントID（セラーID）がリクエストを実行する為に適切な状態ではありません。
        　　　　         // 考えられる理由 ： 制限がかかっているか、正しく登録が完了されていません。
                      break;
                  case 'InvalidOrderReferenceId':
                      // オーダーリファレンスIDが正しくありません。
                      break;
                  case 'InvalidParameterValue':
                      // 指定されたパラメータの値が正しくありません。
                      break;
                  case 'InvalidSellerId':
                      // マーチャントID（セラーID）が正しくありません。
                      break;
                  case 'MissingParameter':
                      // 指定されたパラメータが正しくありません。
                      break;
                  case 'PaymentMethodNotModifiable':
                      // オーダーリファレンスIDのステータスが正しくない場合はお支払い方法を変更することができません。
                      break;
                  case 'ReleaseEnvironmentMismatch':
                      // 使用しているオーダーリファレンスオブジェクトがリリース環境と一致しません。
                      break;
                  case 'StaleOrderReference':
                      // 使用しているオーダーリファレンスIDがキャンセルされています。
                  　　　// キャンセルされたオーダーリファレンスIDでウィジェットを関連付けすることはできません。
                      break;
                  case 'UnknownError':
                      // 不明なエラーが発生しました。(UnknownError)
                      break;
                  default:
                      // 不明なエラーが発生しました。
                }
            }
          }).bind("addressBookWidgetDiv");
      }

      function showWalletWidget(orderReferenceId) {
          // Wallet
          new OffAmazonPayments.Widgets.Wallet({
            sellerId: sellerId,
            amazonOrderReferenceId: orderReferenceId,
            onReady: function(orderReference) {
                console.log(orderReference.getAmazonOrderReferenceId());
            },
            onPaymentSelect: function() {   // 支払方法選択
                console.log(arguments);
            },
            design: {
                designMode: 'responsive'
            },
            onError: function(error) {
                // エラー処理
                // エラーが発生した際にonErrorハンドラーを使って処理することをお勧めします。
                // @see https://payments.amazon.com/documentation/lpwa/201954960
                console.log('OffAmazonPayments.Widgets.Wallet', error.getErrorCode(), error.getErrorMessage());
            }
          }).bind("walletWidgetDiv");
      }

    </script>

    <script type="text/javascript" src="<?php echo $ama['url_widget_js'] ?>" async></script>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
  </body>

</html>
