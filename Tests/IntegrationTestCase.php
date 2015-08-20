<?php

namespace MLB\DagBundle\Tests;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Input\ArrayInput;

/**
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2015 Christian Raue
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
abstract class IntegrationTestCase extends WebTestCase {

	/**
	 * {@inheritDoc}
	 */
	public static function setUpBeforeClass() {
		static::rebuildDatabase();
	}

	/**
	 * {@inheritDoc}
	 */
	protected function setUp() {
		static::createClient();
		$this->cleanDatabaseBeforeTest();
	}

	protected function cleanDatabaseBeforeTest() {
	}

	/**
	 * {@inheritDoc}
	 */
	protected static function createKernel(array $options = array()) {
		$environment = isset($options['environment']) ? $options['environment'] : 'test';
		$configFile = isset($options['config']) ? $options['config'] : 'config.yml';

		return new AppKernel($environment, $configFile);
	}

	protected static function rebuildDatabase() {
		static::createClient();
		$application = new Application(static::$kernel);
		$application->setAutoExit(false);

		static::executeCommand($application, 'doctrine:schema:drop', array('--force' => true, '--full-database' => true));
		static::executeCommand($application, 'doctrine:schema:update', array('--force' => true));
	}

	private static function executeCommand(Application $application, $command, array $options = array()) {
		$options = array_merge($options, array(
			'--env' => 'test',
			'--no-debug' => null,
			'--no-interaction' => null,
			'--quiet' => null,
			'command' => $command,
		));

		return $application->run(new ArrayInput($options));
	}

	/**
	 * @return EntityManager
	 */
	protected static function getEntityManager() {
		return static::getService('doctrine')->getManager();
	}

	/**
	 * @param string $id The service identifier.
	 * @return object The associated service.
	 */
	protected static function getService($id) {
		return static::$kernel->getContainer()->get($id);
	}

}
