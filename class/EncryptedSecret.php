<?php
namespace SizzleLink;

class EncryptedSecret {
	public function __construct(
		private string $code,
		private string $dataDir = "data",
	) {
		if(!file_exists("$this->dataDir/$this->code")) {
			throw new SecretNotFoundException($this->code);
		}
	}

	public function decrypt(string $password):string {
		throw new IncorrectDecryptionPasswordException();
	}

}
