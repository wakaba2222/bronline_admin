<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<p>スマレジ　ツール</p>

<p>
<select name="shop" id="shop">
<option value="brshop" selected>BRSHOP</option>
<option value="astilehouse">ASTILE</option>
</select>
</p>

<p>受注番号：<input type="text" name="order_id" id="order_id" value="" /><button type="button" id="search_btn">取得</button></p>

<div id="order_area">
<p>スマレジ取引ID：<span id="smaregi_order_id"></span></p>
<p id="button_area">
<button type="button" id="regist_btn">受注をスマレジに登録</button>
<button type="button" id="cancel_btn">受注をスマレジキャンセル</button>
</p>
</div>



<script type="text/javascript" src="/common/js/cart.js"></script>
<script>
$(function(){
	$('#button_area').hide();
	$('#search_btn').click(function(){
			var url = "/api/search_order.json";
			var _order_id = $('#order_id').val();
			var _shop = $('#shop').val();

			var data = {order_id : _order_id, shop_url : _shop};
			var res = sendApi(url, data, order_area);
	});
	$('#regist_btn').click(function(){
			var url = "/api/regist_smaregi_order.json";
			var _order_id = $('#order_id').val();
			var _shop = $('#shop').val();

			var data = {order_id : _order_id, shop_url : _shop};
			var res = sendApi(url, data, order_area);
	});
	$('#cancel_btn').click(function(){
			var url = "/api/regist_smaregi_order.json";
			var _order_id = $('#order_id').val();
			var _shop = $('#shop').val();
			var _cancel = 1;

			var data = {order_id : _order_id, shop_url : _shop, cancel : _cancel};
			var res = sendApi(url, data, order_area);
	});
});

function order_area(data)
{
	console.log(data);
	smaregi = data.smaregi;
//	console.log(smaregi.order_id.length);

	if (smaregi.order_id == -1 || smaregi.smaregi_order_id == null)
	{
		$('#smaregi_order_id').text('関連するスマレジ取引がありません');
		$('#button_area').show();
	}
	else
	{
		$('#smaregi_order_id').text(data.smaregi.smaregi_order_id);
		$('#button_area').show();
	}

}
</script>
