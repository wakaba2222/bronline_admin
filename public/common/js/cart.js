function sendApi(hostUrl, param, callback)
{
		console.log(hostUrl);
		console.log(param);
//		setTimeout("displayLoading()", 100);
		_res = null;
		$.ajax({
            url: hostUrl,
            type:'GET',
            dataType: 'json',
			cache: false,
            async:true,
            data : param,
            timeout:30000,
        }).done(function(data) {

			console.log(data);
			if (data.result != undefined)
			{
				if (data.result.status != 0)
				{
					alert("データ取得でエラーがありました。");
					return false;
				}
			}
			else
			{
			}

			if (callback != undefined)
				callback(data);
			
			return true;

        }).fail(function(XMLHttpRequest, textStatus, errorThrown) {
        	/*
                 alert(XMLHttpRequest.status);
                 alert(textStatus);
                 alert(errorThrown.message);
             */
                 console.log("Status:"+XMLHttpRequest.status+"Text:"+textStatus+"Msg:"+errorThrown.message);
                 
			if (callback != undefined)
			{
				callback(undefined);
			}
//			setTimeout("removeLoading()", 500);
        }).always(function(data) {
				_res = data;
//				setTimeout("removeLoading()", 500);
    	})
}
function postApi(hostUrl, param, callback)
{
//	console.log(JSON.stringify(param));
// param = {"ordermemo":"","cust":{"custcd":"00077655","sei":"","mei":"","zip":"","addr1":"","addr2":"","himituQ":"0","himituA":"","password":"","dairicustcd":"","dairihimituQ":"","dairihimituA":"","dairipassword":"","anamilage":"ANA1234567","jalmilage":"JAL1234567","kanasei":"テスト","kanamei":"タロウ","empid":"MEMBER0001","sex":"0","birthday":"19701111","tel":"080-1111-2222","email":"hwakaba2222@gmail.com","dairikanasei":"ダイリ","dairikanamei":"","dairitel":"080-1111-2222","dairiemail":"hwakaba2222@gmail.com","deptcode":"D002"},"agent":{"usecd":"Y01","agentcd":"ETBETB"},"head":{"settleflag":1,"fromdate":"20180610","code1":"","code2":"","code3":"","male":1,"female":0,"child":0,"infant":0,"soine":0,"middle":0,"basesales":[],"bookingtype":1,"business":"大阪","businessno":"0123456","sharedeptcode":"D002","contactmails":["","","","",""]},"person":[{"kanasei":"テスト","kanamei":"タロウ","sex":"0","age":"47","dohanseq":0}],"flighttickets":[{"flightdate":"20180610","carrier":"ANA","flightno":"987","tickettype":"normal_p","tickettypename":"標準","dep":"HND","arr":"CTS","etd":"0615","eta":"0745","iit":0,"sales":{"priceAdt":"51790","priceChild":"32890"}}]};

//		setTimeout("displayLoading()", 100);
		$.ajax({
            url: hostUrl,
            type:'POST',
            dataType: 'json',
//             contentType: 'application/json',
        contentType: false,
        processData: false,
			cache: false,
            async:true,
            data : param,
            timeout:30000,
        }).done(function(data) {

			if (data.result != undefined)
			{
				if (data.result.status != 0)
				{
					alert("データ取得でエラーがありました。");
					return false;
				}
			}
			else
			{
			}

			if (callback != undefined)
				callback(data);
			
			return true;

        }).fail(function(XMLHttpRequest, textStatus, errorThrown) {
                 alert(XMLHttpRequest.status);
//                  alert(textStatus);
//                  alert(errorThrown.message);
                 
                 console.log('Status:'+XMLHttpRequest.status);
                 console.log('Text:'+textStatus);
                 console.log('Message:'+errorThrown.message);
                 
                 return;
        }).always(function(data) {
// 				_res = data;
				console.log(data);
//				setTimeout("removeLoading()", 500);
    	})
}
