<?php
namespace SizzleLink\Test;

use PHPUnit\Framework\TestCase;
use SizzleLink\SharableSecret;

class SharableSecretTest extends TestCase {
	public function testGetCode():void {
		$tmpDir = sys_get_temp_dir() . "/" . uniqid("sizzle-link-test-");
		$sut = new SharableSecret(
			uniqid(),
			bin2hex(random_bytes(8)),
			$tmpDir,
		);
		self::assertGreaterThan(4, strlen($sut->code));
	}

	public function testConstruct_createsFile():void {
		$tmpDir = sys_get_temp_dir() . "/" . uniqid("sizzle-link-test-");

		$sut = new SharableSecret(
			uniqid(),
			bin2hex(random_bytes(8)),
			$tmpDir
		);
		$code = $sut->code;
		self::assertFileExists("$tmpDir/$code");
	}

	public function testConstruct_fileDoesNotContainSecret():void {
		$tmpDir = sys_get_temp_dir() . "/" . uniqid("sizzle-link-test-");
		$secret = uniqid();
		$sut = new SharableSecret(
			$secret,
			bin2hex(random_bytes(8)),
			$tmpDir
		);
		$code = $sut->code;
		$contents = file_get_contents("$tmpDir/$code");
		self::assertGreaterThan(0, strlen($contents));
		self::assertStringNotContainsString($secret, $contents);
	}
}
