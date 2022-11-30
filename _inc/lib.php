<?php

declare(strict_types=1);
require_once __DIR__.'/../_vendor/autoload.php';
require_once __DIR__.'/config.php';

putenv('LC_ALL=C.UTF-8');
setlocale(LC_ALL, 'C.UTF-8');
$GLOBALS['CORP_ROOT'] = dirname(__DIR__);

function b64_slug($rv) {
	$rv = base64_encode($rv);
	$rv = trim($rv, '=');
	$rv = str_replace('+', 'z', $rv);
	$rv = str_replace('/', 'Z', $rv);
	$rv = preg_replace('~^\d~', 'n', $rv);
	return $rv;
}

function sha256_lc20($in) {
	return strtolower(substr(b64_slug(hash('sha256', $in, true)), 0, 20));
}

function json_encode_vb($v, $o=0) {
	return json_encode($v, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | $o);
}

function filter_corpora_k($arr) {
	foreach ($arr as $k => $v) {
		$us = strpos($k, '_');
		if ($us === false) {
			unset($arr[$k]);
			continue;
		}
		$g = substr($k, 0, $us);
		if (empty($GLOBALS['-corpora'][$g][$k])) {
			unset($arr[$k]);
		}
	}
	ksort($arr);
	return $arr;
}

function filter_corpora_v($arr) {
	sort($arr);
	$arr = array_unique($arr);
	foreach ($arr as $k => $v) {
		$us = strpos($v, '_');
		if ($us === false) {
			unset($arr[$k]);
			continue;
		}
		$g = substr($v, 0, $us);
		if (empty($GLOBALS['-corpora'][$g][$v])) {
			unset($arr[$k]);
		}
	}
	return array_values($arr);
}