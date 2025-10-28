    function sfNoImageMainList($filename = '') {
        if (strlen($filename) == 0 || substr($filename, -1, 1) == '/') {
            $filename .= 'noimage_main_list.jpg';
        }
        return $filename;
    }
