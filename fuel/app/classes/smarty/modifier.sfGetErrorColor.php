    function smarty_modifier_sfGetErrorColor($val) {
        if ($val != '') {
            return 'background-color:red';
        }
        return '';
    }
