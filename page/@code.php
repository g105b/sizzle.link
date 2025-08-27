<?php
use Gt\DomTemplate\Binder;
use Gt\Http\Response;
use Gt\Input\Input;
use Gt\Routing\Path\DynamicPath;
use SizzleLink\EncryptedSecret;
use SizzleLink\IncorrectDecryptionPasswordException;
use SizzleLink\SecretNotFoundException;
use SizzleLink\SecretSizzledException;

function go(Input $input, Binder $binder):void {
	if($error = $input->getString("error")) {
		$errorMessage = match($error) {
			"wrong-password" => "The provided password did not match.",
			"sizzled" => "This secret has already sizzled.",
			default => "There has been an error decrypting your message.",
		};

		$binder->bindKeyValue("error", $errorMessage);
	}
}

function do_view(
	Input $input,
	DynamicPath $dynamicPath,
	Binder $binder,
	Response $response,
):void {
	$password = $input->getString("password");
	$code = $dynamicPath->get();

	try {
		$secret = new EncryptedSecret($code);
		$binder->bindKeyValue("secret", $secret->decrypt($password));
	}
	catch(SecretNotFoundException|IncorrectDecryptionPasswordException) {
		$response->redirect("?error=wrong-password");
	}
	catch(SecretSizzledException) {
		$response->redirect("?error=sizzled");
	}
}
