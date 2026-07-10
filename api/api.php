<?php


use GT\Input\Input;
use GT\Json\Schema\JSONDocument;
use SizzleLink\SharableSecret;

function go(
	Input $input
) {
	$json = new JsonDocument();

	$secret = $input->getString("secret") ?? null;
	$password = $input->getString("password") ?? null;

	if (!$secret || !$password) {
		$json->error("Secret and password are required");
		endApi($json, 400);
	}
	if (strlen($password) < 8) {
		$json->error("Password must be 8 characters or more");
		endApi($json, 400);
	}

	$sharableSecret = new SharableSecret(
		$secret,
		$password,
	);

	$json->set("code", $sharableSecret->code);
	$json->set("link", "https://sizzle.link/$sharableSecret->code");

	endApi($json);
}

function endApi($json, $code = 200) {
	header("content-type: application/json");
	http_response_code($code);
	echo $json;
	exit;
}
