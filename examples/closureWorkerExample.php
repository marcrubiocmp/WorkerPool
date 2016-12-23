<?php

require_once(__DIR__ . '/../autoload.php');


$wp=new \QXS\WorkerPool\WorkerPool();
$wp->setWorkerPoolSize(4)
   ->create(new \QXS\WorkerPool\ClosureWorker(
                        /**
			 * The Worker::run() Method
                         * @param mixed $input the input from the WorkerPool::run() Method
                         * @param \ArrayObject $storage a persistent storge for the current child process
                         */
                        function($input, $storage) {
				$storage->append($input);
                                echo "[".getmypid()."]"." hi $input\n";
                                sleep(rand(1,3)); // this is the working load!
                                return $input;
                        },
                        /**
                         * The Worker::onProcessCreate() Method
                         * @param \ArrayObject $storage a persistent storge for the current child process
                         */
                        function($storage) {
                                echo "[".getmypid()."]"." child has been created\n";
                        },
                        /**
                         * The Worker::onProcessDestroy() Method
                         * @param \ArrayObject $storage a persistent storge for the current child process
                         */
                        function($storage) {
                	                echo "[".getmypid()."]"." child will be destroyed, see its history\n";
					foreach($storage as $val) {
						echo "\t$val\n";
					}
                        }

                )
);


for($i=0; $i<10; $i++) {
        $wp->run($i);
}

$wp->waitForAllWorkers(); // wait for all workers

foreach($wp as $val) {
	echo "Parent has retrieved: ".$val['data']."\n";
}


