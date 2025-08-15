<?php
use Gt\Dom\HTMLDocument;
use Gt\DomTemplate\Binder;
use Gt\Http\Response;
use Gt\Input\Input;
use SizzleLink\SharableSecret;

function go(Input $input, Binder $binder, HTMLDocument $document):void {
	if($code = $input->getString("code")) {
		$binder->bindKeyValue("code", $code);
		$binder->bindKeyValue("link", "https://sizzle.link/$code");
	}
}

function do_get_secret(Input $input, Response $response):void {
	if($code = $input->getString("code")) {
		$response->redirect("/$code");
	}
	else {
		$response->reloadWithoutQuery();
	}
}

function do_create_link(Input $input, Response $response):void {
	$secret = new SharableSecret(
		$input->getString("secret"),
		$input->getString("password"),
	);
	$response->redirect("?code=$secret->code");
}
