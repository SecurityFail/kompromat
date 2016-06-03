<?php

$N="25777";
$e="3";
$d="16971";

$gmp_N=gmp_init($N,10);
$gmp_e=gmp_init($e,10);
$gmp_d=gmp_init($d,10);

$gmp_k=gmp_sub(gmp_mul($gmp_e, $gmp_d), 1);

$gmp_test = gmp_powm(gmp_powm(1337, $gmp_e, $gmp_N), $gmp_d, $gmp_N);
$str_test = gmp_strval($gmp_test, 10);
echo "test=$str_test\n";

$a = 5000;
do {
    echo "-----\n";

    $gmp_g=gmp_random_range(2, gmp_sub($gmp_N, 1));
    $gmp_t=$gmp_k;

    if(gmp_testbit($gmp_t, 0)==1) {
        continue;
    }

    $str_g=gmp_strval($gmp_g, 10);
    echo "==> $str_g\n";

    do {
        $gmp_t=gmp_div($gmp_t, 2);
        $gmp_x=gmp_powm($gmp_g, $gmp_t, $gmp_N);
        $gmp_y=gmp_gcd(gmp_sub($gmp_x, 1), $gmp_N);
    } while(gmp_testbit($gmp_t, 0)==0 && (gmp_cmp($gmp_x, 1)>0 || gmp_cmp($gmp_y, 1)>0));
} while(gmp_cmp($gmp_x, 1)<=0 || gmp_cmp($gmp_y, 1)<=0);

$str_x=gmp_strval($gmp_x, 10);
$str_y=gmp_strval($gmp_y, 10);

$gmp_p=$gmp_y;
$gmp_q=gmp_div($gmp_N, $gmp_y);

$str_p=gmp_strval($gmp_p, 10);
$str_q=gmp_strval($gmp_q, 10);

printf("\np=%s\nq=%s\n", $str_p, $str_q);
