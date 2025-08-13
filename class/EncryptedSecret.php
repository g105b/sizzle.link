<?php
namespace SizzleLink;

class EncryptedSecret {
	const string SIZZLED = "SIZZLED";
	private Crypto $crypto;

	public function __construct(
		private string $code,
		private string $dataDir = "data",
		?Crypto $crypto = null,
		string $cryptoSalt = "1234567890abcdef",
	) {
		if(!file_exists("$this->dataDir/$this->code")) {
			throw new SecretNotFoundException($this->code);
		}

		$this->crypto = $crypto ?? new Crypto($cryptoSalt);
	}

	public function decrypt(string $password):string {
		$cipher = file_get_contents("$this->dataDir/$this->code");
		if($cipher === self::SIZZLED) {
			throw new SecretSizzledException();
		}
		$decrypted = $this->crypto->decrypt($cipher, $password);
		file_put_contents("$this->dataDir/$this->code", self::SIZZLED);
		return $decrypted;
	}
}
