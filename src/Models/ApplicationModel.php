<?php

namespace Pgly\Omie\Api\Models;

use Pgly\Omie\Api\Environments\ProductionEnvironment;
use Piggly\ApiClient\Interfaces\EnvInterface;
use Piggly\ApiClient\Models\ApplicationModel as BaseApplicationModel;

/**
 * Application model structure.
 *
 * @package Pgly\Omie\Api
 * @subpackage Pgly\Omie\Api\Models
 * @version 0.1.0
 * @since 0.1.0
 * @category Models
 * @author Caique Araujo <caique@piggly.com.br>
 * @author Piggly Lab <dev@piggly.com.br>
 * @license MIT
 * @copyright 2022 Piggly Lab <dev@piggly.com.br>
 */
class ApplicationModel extends BaseApplicationModel
{
	/**
	 * Must return the Environment object according to
	 * the current Environment.
	 *
	 * @since 0.1.0
	 * @return EnvInterface
	 */
	public function createEnvironment(): EnvInterface
	{
		return new ProductionEnvironment();
	}
}
