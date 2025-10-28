<?php
class Tag_CsvUpload
{
	function __construct()
	{
	}
	function upload($fname)
	{
	    $row = 1;
	    $err = true;
	    $handle = fopen($fname, "r");

	    while (($data = $this->fgetcsv_reg($handle)) !== false)
	    {
	        $_enc_to="UTF-8";
	        $_enc_from="SJIS";
	        mb_convert_variables($_enc_to,$_enc_from,$data);
	        $num = count($data);
	        
// 	        if ($num != 28)
// 	        {
// 	        	$text_err = "CSVのカラム数が一致しませんでした。カラム数は28ですが".$num."でした。";
// 			    $err = false;
// //print($text_err);
// 	        	break;
// 	        }

//	        echo "<p> $num fields in line $row: </p><br />\n";exit;

			if ($row == 1)
			{
		        $row++;
				continue;
			}
//$this->debug(array($data));
			$regist_sql = "INSERT INTO `m_student` (`school_id`, `student_id`, `student_nm`, `student_kn`, `student_cd`, `sex_cd`, `birth`, `zip`, `pref_cd`, `address`, `address2`, `parent_nm`, `parent_kn`, `parent_zip`, `parent_pref_cd`, `parent_address`, `parent_address2`, `parent_tel`, `is_same_address`, `career`, `entry_kbn`, `entry_date`, `entry_term`, `entry_memo`, `retire_kbn`, `retire_date`, `retire_date2`, `retire_memo`, `freeword`, `ins_datetime`, `ins_user_id`,`upd_datetime`, `upd_user_id`) values ('?','?','?','?','?','?','?','?','?','?','?','?','?','?','?','?','?','?','?','?','?','?','?','?','?','?','?','?','?','".date("Y/m/d H:m:s")."','".$teacherId."','".date("Y/m/d H:m:s")."','".$teacherId."')";
			$update_sql = "UPDATE `m_student` SET `student_nm`='?', `student_kn`='?', `student_cd`='?', `sex_cd`='?', `birth`='?', `zip`='?', `pref_cd`='?', `address`='?', `address2`='?', `parent_nm`='?', `parent_kn`='?', `parent_zip`='?', `parent_pref_cd`='?', `parent_address`='?', `parent_address2`='?', `parent_tel`='?', `is_same_address`='?', `career`='?', `entry_kbn`='?', `entry_date`='?', `entry_term`='?', `entry_memo`='?', `retire_kbn`='?', `retire_date`='?', `retire_date2`='?', `retire_memo`='?', `freeword`='?'  WHERE school_id='?' AND student_id='?'";
			$max_sql = "SELECT max(student_id) as idmax from `m_student`";

			$sqlval = array();
			if ($data[0] == 0 || $data[0] == '')
			{
//				$max_ret = $db->query($max_sql);
				$next_id = $max_ret[0]['idmax'] + 1;

				$sqlval[] = $schoolId;	// school_id
				$sqlval[] = $next_id;	// student_id
				$sqlval[] = $data[1];	// student_nm
				$sqlval[] = $data[2];	// 
				$sqlval[] = $data[3];	// 
				$sqlval[] = $data[4];	// 
				$sqlval[] = $data[5];	// 
				$sqlval[] = $data[6];	// 
				$sqlval[] = $data[7];	// 
				$sqlval[] = $data[8];	// 
				$sqlval[] = $data[9];	// 
				$sqlval[] = $data[10];	// 
				$sqlval[] = $data[11];	// 
				$sqlval[] = $data[12];	// 
				$sqlval[] = $data[13];	// 
				$sqlval[] = $data[14];	// 
				$sqlval[] = $data[15];	// 
				$sqlval[] = $data[16];	// 
				$sqlval[] = $data[17];	// 
				$sqlval[] = $data[18];	// 
				$sqlval[] = $data[19];	// 
				$sqlval[] = $data[20];	// 
				$sqlval[] = $data[21];	// 
				$sqlval[] = $data[22];	// 
				$sqlval[] = $data[23];	// 
				$sqlval[] = $data[24];	// 
				$sqlval[] = $data[25];	// 
				$sqlval[] = $data[26];	// 
				$sqlval[] = $data[27];	// 
				$sqlval[] = $data[28];	// 
/*
				$sqlval[] = $data[29];	// 
				$sqlval[] = $data[30];	// 
				$sqlval[] = $data[31];	// 
				$sqlval[] = $data[32];	// 
*/
				
				$ret = $db->sqlexec($regist_sql, $sqlval);
			}
			else
			{
				$sqlval[] = $data[1];	// 
				$sqlval[] = $data[2];	// 
				$sqlval[] = $data[3];	// 
				$sqlval[] = $data[4];	// 
				$sqlval[] = $data[5];	// 
				$sqlval[] = $data[6];	// 
				$sqlval[] = $data[7];	// 
				$sqlval[] = $data[8];	// 
				$sqlval[] = $data[9];	// 
				$sqlval[] = $data[10];	// 
				$sqlval[] = $data[11];	// 
				$sqlval[] = $data[12];	// 
				$sqlval[] = $data[13];	// 
				$sqlval[] = $data[14];	// 
				$sqlval[] = $data[15];	// 
				$sqlval[] = $data[16];	// 
				$sqlval[] = $data[17];	// 
				$sqlval[] = $data[18];	// 
				$sqlval[] = $data[19];	// 
				$sqlval[] = $data[20];	// 
				$sqlval[] = $data[21];	// 
				$sqlval[] = $data[22];	// 
				$sqlval[] = $data[23];	// 
				$sqlval[] = $data[24];	// 
				$sqlval[] = $data[25];	// 
				$sqlval[] = $data[26];	// 
				$sqlval[] = $data[27];	// 
				$sqlval[] = date("Y/m/d H:m:s");	// 
				$sqlval[] = $teacherId;	// 
				$sqlval[] = date("Y/m/d H:m:s");	// 
				$sqlval[] = $teacherId;	// 
				$sqlval[] = $schoolId;	// 学校ID
				$sqlval[] = $data[0];	// 

				$ret = $db->sqlexec($update_sql, $sqlval);
//				print("return :".$ret."<br>");
			}

			if (!$ret)
			{
	        	$text_err = "登録時にエラーが発生しました。(".$row.")";
//print($text_err);
			    $err = false;
	        	break;
			}


//	        for ($c=0; $c < $num; $c++)
//	        {
//	            print_r(nl2br($data[$c]) . "<br />\n");
//	        }

	        $row++;
	    }
	    fclose($handle);

		if ($err)
		{
			$ret = $db->sqlexec("COMMIT");
        	$text_err = ($row-2)."行登録／更新しました。";
//print($text_err);
		}
		else
			$ret = $db->sqlexec("ROLLBACK");

		$db->disconnect();


//		session_start();
//		setcookie('CSV_TEXT', $text_err);
		$_SESSION['CSV_TEXT'] = $text_err;


	    return $err;

	}

	function fgetcsv_reg (&$handle, $length = null, $d = ',', $e = '"') {
        $d = preg_quote($d);
        $e = preg_quote($e);
        $_line = "";
        while (($eof != true)and(!feof($handle))) {
            $_line .= (empty($length) ? fgets($handle) : fgets($handle, $length));
            $itemcnt = preg_match_all('/'.$e.'/', $_line, $dummy);
            if ($itemcnt % 2 == 0) $eof = true;
        }
        $_csv_line = preg_replace('/(?:\\r\\n|[\\r\\n])?$/', $d, trim($_line));
        $_csv_pattern = '/('.$e.'[^'.$e.']*(?:'.$e.$e.'[^'.$e.']*)*'.$e.'|[^'.$d.']*)'.$d.'/';
        preg_match_all($_csv_pattern, $_csv_line, $_csv_matches);
        $_csv_data = $_csv_matches[1];
        for($_csv_i=0;$_csv_i<count($_csv_data);$_csv_i++){
            $_csv_data[$_csv_i]=preg_replace('/^'.$e.'(.*)'.$e.'$/s','$1',$_csv_data[$_csv_i]);
            $_csv_data[$_csv_i]=str_replace($e.$e, $e, $_csv_data[$_csv_i]);
        }
        return empty($_line) ? false : $_csv_data;
    }
}
