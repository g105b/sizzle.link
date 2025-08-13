<?php
namespace SizzleLink\Test;

use PHPUnit\Framework\TestCase;
use SizzleLink\Crypto;
use SizzleLink\CryptoHashException;
use SizzleLink\IncorrectDecryptionPasswordException;

class CryptoTest extends TestCase {
	public function testEncrypt_invalidSalt():void {
		$sut = new Crypto("salt");
		self::expectException(CryptoHashException::class);
		$sut->encrypt("This is my secret", "This is my password");
	}

	public function testEncrypt():void {
		$salt = random_bytes(SODIUM_CRYPTO_PWHASH_SALTBYTES);
		$sut = new Crypto($salt);
		$secret = "This is my secret";
		$encrypted = $sut->encrypt($secret, "This is my password");
		self::assertGreaterThan(strlen($secret), strlen($encrypted));
	}

	public function testDecrypt():void {
		$salt = random_bytes(SODIUM_CRYPTO_PWHASH_SALTBYTES);
		$sutEncrypt = new Crypto($salt);
		$secret = "This is my secret";
		$password = "This is my password";
		$encrypted = $sutEncrypt->encrypt($secret, $password);

		$sutDecrypt = new Crypto($salt);
		$decrypted = $sutDecrypt->decrypt($encrypted, $password);

		self::assertSame($secret, $decrypted);
	}

	public function testDecrypt_incorrectHash():void {
		$salt1 = random_bytes(SODIUM_CRYPTO_PWHASH_SALTBYTES);
		$salt2 = random_bytes(SODIUM_CRYPTO_PWHASH_SALTBYTES);
		$sutEncrypt = new Crypto($salt1);
		$secret = "This is my secret";
		$password = "This is my password";
		$encrypted = $sutEncrypt->encrypt($secret, $password);

		$sutDecrypt = new Crypto($salt2);
		self::expectException(IncorrectDecryptionPasswordException::class);
		$sutDecrypt->decrypt($encrypted, $password);
	}
}
