<?php
namespace SizzleLink;

class SharableSecret {
	public string $code;

	public function __construct(
		private string $secret,
		private string $password,
		private string $dataDir = "data",
		?Crypto $crypto = null,
		string $salt = "1234567890abcdef",
	) {
		if(!is_dir($this->dataDir)) {
			mkdir($this->dataDir, recursive: true);
		}

		if(!$crypto) {
			$crypto = new Crypto($salt);
		}

		$this->code = bin2hex(random_bytes(4));
		file_put_contents(
			"$this->dataDir/$this->code",
			$crypto->encrypt($secret, $this->password)
		);
	}
}
