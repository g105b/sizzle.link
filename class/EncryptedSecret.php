<?php
namespace SizzleLink;

class EncryptedSecret {
	private Crypto $crypto;

	public function __construct(
		private string $code,
		private string $dataDir = "data",
		?Crypto $crypto = null,
	) {
		if(!file_exists("$this->dataDir/$this->code")) {
			throw new SecretNotFoundException($this->code);
		}

		$this->crypto = $crypto ?? new Crypto();
	}

	public function decrypt(string $password):string {
		$cipher = file_get_contents("$this->dataDir/$this->code");
		return $this->crypto->decrypt($cipher, $password);
	}

}
