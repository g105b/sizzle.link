<?php
namespace SizzleLink\Test;

use PHPUnit\Framework\TestCase;
use SizzleLink\EncryptedSecret;
use SizzleLink\IncorrectDecryptionPasswordException;
use SizzleLink\SecretNotFoundException;

class EncryptedSecretTest extends TestCase {
	public function testConstruct_codeNotExists():void {
		$tmpDir = sys_get_temp_dir() . "/" . uniqid("sizzle-link-test-");
		self::expectException(SecretNotFoundException::class);
		new EncryptedSecret("12345", $tmpDir);
	}

	public function testDecrypt_wrongPassword():void {
		$tmpDir = sys_get_temp_dir() . "/" . uniqid("sizzle-link-test-");
		mkdir($tmpDir, recursive: true);
		$code = "12345";
		touch("$tmpDir/$code");
		$sut = new EncryptedSecret($code, $tmpDir);
		self::expectException(IncorrectDecryptionPasswordException::class);
		$sut->decrypt("abcdef");
	}
}
