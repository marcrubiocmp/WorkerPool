<?php
namespace QXS\Tests\WorkerPool\Fixtures;

use QXS\WorkerPool\WorkerInterface;

Class FatalFailingWorker implements WorkerInterface {

	public function onProcessCreate() {
	}

	public function onProcessDestroy() {
	}

	public function run($input) {
		@$x->abc(); // fatal error
		return "Hi $input";
	}
}
