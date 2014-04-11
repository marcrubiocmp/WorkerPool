<?php
/**
 * The WorkerPool Requires the following PHP extensions
 *	* pcntl
 *	* posix
 *	* sysvsem
 *	* sockets
 *	* proctitle (optional)
 * 
 * Use the following commands to install them on RHEL:
 * 	yum install php-process php-pcntl
 * 	yum install php-pear php-devel ; pecl install proctitle
 * 	echo 'extension=proctitle.so' > /etc/php.d/proctitle.ini
 */


namespace QXS\WorkerPool;

/**
 * The Interface for worker processes
 */
interface Worker {
	/**
	 * After the worker has been forked into another process
	 *
	 * @param \QXS\WorkerPool\Semaphore $semaphore the semaphore to run synchronized tasks
	 * @throws \Exception in case of a processing Error an Exception will be thrown
	 */
	public function onProcessCreate(Semaphore $semaphore);
	/**
	 * Before the worker process is getting destroyed
	 *
	 * @throws \Exception in case of a processing Error an Exception will be thrown
	 */
	public function onProcessDestroy();
	/**
	 * run the work
	 *
	 * @param Serializeable $input the data, that the worker should process
	 * @return Serializeable Returns the result
	 * @throws \Exception in case of a processing Error an Exception will be thrown
	 */
	public function run($input);
}

