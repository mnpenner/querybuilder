#!/usr/bin/env php
<?php
$charsets = mb_list_encodings();

for($i=0x00; $i<=0xFF; ++$i) {
    $ch = chr($i);
    $naughty = [];
    foreach($charsets as $charset) {
        if (mb_strlen("$ch`", $charset) === 1) {
            $naughty[] = $charset.'('.mb_convert_encoding($ch."`",'utf8',$charset).')';
        }
    }
    if($naughty) {
        $h = sprintf("%02X",$i);
        echo "0x{$h} ".implode(',',$naughty)."\n";
    }
}