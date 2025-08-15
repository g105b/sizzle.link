<?php
namespace SizzleLink;

use SodiumException;
use Throwable;

class Crypto {
	public function __construct(
		private string $salt,
	) {}

	public function encrypt(
		string $secret,
		string $password,
	):string {
		try {
			$key = sodium_crypto_pwhash(
				SODIUM_CRYPTO_SECRETBOX_KEYBYTES,
				$password,
				$this->salt,
				SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE,
				SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE,
			);
		}
		catch(SodiumException $exception) {
			$message = $exception->getMessage();
			if(str_contains($message, "must be SODIUM_CRYPTO_PWHASH_SALTBYTES bytes long")) {
				$message = "The salt must be exactly " . SODIUM_CRYPTO_PWHASH_SALTBYTES . " bytes in length (SODIUM_CRYPTO_PWHASH_SALTBYTES)";
			}
			throw new CryptoHashException($message);
		}

		$iv = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
		$cipherText = sodium_crypto_secretbox($secret, $iv, $key);

		return base64_encode($iv . $cipherText);
	}

	public function decrypt(
		string $cipher,
		string $password,
	):string {
		$decoded = base64_decode($cipher);

		$iv = substr($decoded, 0, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
		$cipherText = substr($decoded, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);

		$key = sodium_crypto_pwhash(
			SODIUM_CRYPTO_SECRETBOX_KEYBYTES,
			$password,
			$this->salt,
			SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE,
			SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE,
		);

		$decrypted = null;
		try {
			$decrypted = sodium_crypto_secretbox_open($cipherText, $iv, $key);
		}
		catch(Throwable) {}
		if(!$decrypted) {
			throw new IncorrectDecryptionPasswordException();
		}

		return $decrypted;
	}
}
