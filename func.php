<?php
function wpfid_sizes($bytes)
{
    if ($bytes < 1024) {
        return $bytes .' B';
    } elseif ($bytes < 1048576) {
        return round($bytes / 1024, 2) .' KB';
    } elseif ($bytes < 1073741824) {
        return round($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes < 1099511627776) {
        return round($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes < 1125899906842624) {
        return round($bytes / 1099511627776, 2) .' TB';
    } elseif ($bytes < 1152921504606846976) {
        return round($bytes / 1125899906842624, 2) .' PB';
    } elseif ($bytes < 1180591620717411303424) {
        return round($bytes / 1152921504606846976, 2) .' EB';
    } elseif ($bytes < 1208925819614629174706176) {
        return round($bytes / 1180591620717411303424, 2) .' ZB';
    } else {
        return round($bytes / 1208925819614629174706176, 2) .' YB';
    }
}
?>