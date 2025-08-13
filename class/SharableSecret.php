<?php
namespace SizzleLink;

class SharableSecret {
	public string $code;

	public function __construct(
		private string $secret,
		private string $password,
		private string $dataDir = "data"
	) {
		if(!is_dir($this->dataDir)) {
			mkdir($this->dataDir, recursive: true);
		}

		$this->code = bin2hex(random_bytes(4));
		file_put_contents("$this->dataDir/$this->code", str_rot13($secret));
	}
}
