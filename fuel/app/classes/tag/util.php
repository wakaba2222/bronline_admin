<?php

class Tag_Util
{
	var $transactionid;

	function __construct()
	{
	}
	
    public static function tax_cal($price)
    {
        $total = round($price * ((TAX_RATE)/100));
        
        return $total;
    }
    public static function taxin_cal($price)
    {
        $total = round($price * ((100+TAX_RATE)/100));
        
        return $total;
    }

    public static function sale_cal($price, $sale)
    {
//    	var_dump($price);
//    	var_dump($sale);
    	$total = (int)round($price * ((100 - intval($sale))/100));
        $total = round($total * ((100+TAX_RATE)/100));
        
        return (int)$total;
    }

    /**
     * Macで作成された日本語ファイル名の濁点／半濁点を吸収するためだけのメソッド
     * ファイル名を渡したらきれいにして返してくれる
     * @param string $string
     * @return string
     */
    static public function normalizeUtf8MacFileName($string)
    {
        $newString = '';
        $beforeChar = '';
        //基本的に一文字前の文字を一文字ずつ繋げていくので、文字数よりも一回ループが多い
        for ($i = 0; $i <= mb_strlen($string, 'UTF-8'); $i++) {
            $nowChar = mb_substr($string, $i, 1, 'UTF-8');
            if ($nowChar == hex2bin('e38299')) { //Macの濁点
                $retChar = self::macConvertKana($beforeChar, false);
                $substituteChar = 'e3829b'; //Windowsの全角濁点
                goto convPoint;
            } elseif ($nowChar == hex2bin('e3829a')) { //Macの半濁点
                $retChar = self::macConvertKana($beforeChar, true);
                $substituteChar = 'e3829c'; //Windowsの全角半濁点

                convPoint: //濁点または半濁点があった場合の処理
                if ($retChar) { //前の文字と合体可能の場合
                    $newString .= $retChar;
                    $beforeChar = '';
                } else { //前の文字と合体不可能の場合
                    $newString .= $beforeChar;
                    $beforeChar = hex2bin($substituteChar); //Windowsの全角濁点／半濁点に置換
                }
            } else { //濁点／半濁点以外はそのままスルー
                $newString .= $beforeChar;
                $beforeChar = $nowChar;
            }
        }
        return $newString;
    }

    /**
     * 一文字渡された文字に対し、濁点付き、半濁点付きの文字を返す
     * @param string $char
     * @param boolean $half
     * @return string
     */
    static public function macConvertKana($char, $half = false)
    {
        $retChar = '';
        if ($char) {
            //濁点の対応表
            $fullTable = array(
                    'か' => 'が','き' => 'ぎ','く' => 'ぐ','け' => 'げ','こ' => 'ご',
                    'さ' => 'ざ','し' => 'じ','す' => 'ず','せ' => 'ぜ','そ' => 'ぞ',
                    'た' => 'だ','ち' => 'ぢ','つ' => 'づ','て' => 'で','と' => 'ど',
                    'は' => 'ば','ひ' => 'び','ふ' => 'ぶ','へ' => 'べ','ほ' => 'ぼ',
                    'ゝ' => 'ゞ',
                    'カ' => 'ガ','キ' => 'ギ','ク' => 'グ','ケ' => 'ゲ','コ' => 'ゴ',
                    'サ' => 'ザ','シ' => 'ジ','ス' => 'ズ','セ' => 'ゼ','ソ' => 'ゾ',
                    'タ' => 'ダ','チ' => 'ヂ','ツ' => 'ヅ','テ' => 'デ','ト' => 'ド',
                    'ハ' => 'バ','ヒ' => 'ビ','フ' => 'ブ','ヘ' => 'ベ','ホ' => 'ボ',
                    'ウ' => 'ヴ','ヽ' => 'ヾ',
            );
            //半濁点の対応表
            $halfTable = array(
                    'は' => 'ぱ','ひ' => 'ぴ','ふ' => 'ぷ','へ' => 'ぺ','ほ' => 'ぽ',
                    'ハ' => 'パ','ヒ' => 'ピ','フ' => 'プ','ヘ' => 'ペ','ホ' => 'ポ',
            );
            //どちらの対応表を使うか
            if ($half) {
                $targetArray = $halfTable;
            } else {
                $targetArray = $fullTable;
            }
            //対応表に合致するか
            if (isset($targetArray[$char])) {
                $retChar = $targetArray[$char];
            }
        }
        return $retChar;
    }

	public static function get_columns($table_name)
	{
		$sql = " DESCRIBE {$table_name} ";
		$query = DB::query($sql);
		$arrRet = $query->execute()->as_array();
		return $arrRet;
	}

	public static function get_table($column, $table_name = "", $where = "", $order = "")
	{
		$query = DB::select_array($column)->from($table_name);
 		if (is_array($where) && count($where) == 3)
 			$query->where($where[0],$where[1],$where[2]);
 
 		if ($order != '')
 			$query->order_by($order);

		$arrRet = $query->execute()->as_array();
//		var_dump(DB::last_query());
//		exit;
		Profiler::console(DB::last_query());
		return $arrRet;
	}
}