    function sfTrim($str) {
        $ret = mb_ereg_replace("^[　 \n\r]*", '', $str);
        $ret = mb_ereg_replace("[　 \n\r]*$", '', $ret);
        return $ret;
    }
