<?php
function smarty_modifier_alltrim($str)
{
  $str = mb_ereg_replace("^[[:space:]]+", "", $str);
  $str = mb_ereg_replace("[[:space:]]+$", "", $str);
  return $str;
}
