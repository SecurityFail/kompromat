<?php

$file = $argv[1];
printf("f =%s\n", $file);

function bytepad($foo) {
    $v = gmp_strval($foo, 16);
    if(strlen($v) & 1) {
        $v = "0$v";
    }
    if(ord($v[0]) >= ord("8")) {
        return "00$v";
    }
    return "$v";
}

function bytelen($foo) {
    $v = bytepad($foo);
    $l = intval(strlen($v) / 2);
    return $l;
}

function hex_to_base64($hex){
    $return = '';
    $hex = str_replace(array(' ', "\n"), '', $hex);
    foreach(str_split($hex, 2) as $pair){
        $return .= chr(hexdec($pair));
    }
    return join("\n", str_split(base64_encode($return), 64));
}

$lines = file($file);
$vars = array();
foreach($lines as $line) {
    if(!strstr($line, "=")) {
        continue;
    }

    list($lk, $lv) = explode("=", trim($line));
    $vars[trim($lk)] = trim($lv);
}

$n=$vars["n"];
$p=$vars["p"];
$q=$vars["q"];
$e=$vars["e"];
$d=$vars["d"];


$gmp_n = gmp_init($n, 16);
$gmp_p = gmp_init($p, 16);
$gmp_q = gmp_init($q, 16);
$gmp_e = gmp_init($e, 16);
$gmp_d = gmp_init($d, 16);

if(gmp_cmp($gmp_p, $gmp_q) < 0) {
    $tmp = $gmp_p;
    $gmp_p = $gmp_q;
    $gmp_q = $tmp;
}

$gmp_p1 = gmp_sub($gmp_p, 1);
$gmp_q1 = gmp_sub($gmp_q, 1);
$gmp_dp = gmp_mod($gmp_d, $gmp_p1);
$gmp_dq = gmp_mod($gmp_d, $gmp_q1);
$gmp_qi = gmp_invert($gmp_q, $gmp_p);

printf(
    "n =%s\ne =%s\nd =%s\np =%s\nq =%s\ndp=%s\ndq=%s\nqi=%s\n",
    gmp_strval($gmp_n, 16),
    gmp_strval($gmp_e, 16),
    gmp_strval($gmp_d, 16),
    gmp_strval($gmp_p, 16),
    gmp_strval($gmp_q, 16),
    gmp_strval($gmp_dp, 16),
    gmp_strval($gmp_dq, 16),
    gmp_strval($gmp_qi, 16)
    );

$der = sprintf(
    "3082 %04x
    0201 00
    02%02x %s
    02%02x %s
    02%02x %s
    02%02x %s
    02%02x %s
    02%02x %s
    02%02x %s
    02%02x %s\n",
    19 + bytelen($gmp_n) + bytelen($gmp_e) + bytelen($gmp_d) + bytelen($gmp_p) + bytelen($gmp_q) + bytelen($gmp_dp) + bytelen($gmp_dq) + bytelen($gmp_qi),

    bytelen($gmp_n),
    bytepad($gmp_n),

    bytelen($gmp_e),
    bytepad($gmp_e),

    bytelen($gmp_d),
    bytepad($gmp_d),

    bytelen($gmp_p),
    bytepad($gmp_p),

    bytelen($gmp_q),
    bytepad($gmp_q),

    bytelen($gmp_dp),
    bytepad($gmp_dp),

    bytelen($gmp_dq),
    bytepad($gmp_dq),

    bytelen($gmp_qi),
    bytepad($gmp_qi)
    );

echo "DER:\n$der\n";

echo "PEM:\n-----BEGIN RSA PRIVATE KEY-----\n" . hex_to_base64($der) . "\n-----END RSA PRIVATE KEY-----\n";
