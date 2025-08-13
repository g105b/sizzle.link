<?php
namespace SizzleLink;

class Crypto {
	public function decrypt(
		string $cipher,
		string $password,
	):string {
		throw new IncorrectDecryptionPasswordException();
	}
}
