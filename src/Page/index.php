<?php
namespace SL\Page;
use \Aws\Common\Aws;
use \Gt\Core\Path;

class Index extends \Gt\Page\Logic {

public function go() {
	$policyFile = implode("/", [
		Path::get(Path::DATA),
		"aws_config.php",
	]);
	$aws = Aws::factory($policyFile);

	$client = $aws->get("S3");
}

}#