<?php

namespace Pgly\Omie\Api\Payloads;

use InvalidArgumentException;
use Piggly\ApiClient\Payloads\AbstractPayload;
use Piggly\ApiClient\Payloads\Rules\Required;
use Piggly\ApiClient\Payloads\Rules\StringRule;

/**
 * Tag payload structure with required tag field.
 *
 * @package Pgly\Omie\Api
 * @subpackage Pgly\Omie\Api\Payloads
 * @version 0.1.0
 * @since 0.1.0
 * @category Payloads
 * @author Caique Araujo <caique@piggly.com.br>
 * @author Piggly Lab <dev@piggly.com.br>
 * @license MIT
 * @copyright 2022 Piggly Lab <dev@piggly.com.br>
 */
class TagPayload extends AbstractPayload
{
	/**
	 * All payload fields.
	 *
	 * @var array
	 * @since 0.1.0
	 */
	protected $_fields = [
		'tag' => null
	];

	/**
	 * Construct object with required fields.
	 *
	 * @param string $tag
	 * @since 0.1.0
	 * @return void
	 */
	public function __construct(string $tag)
	{
		$this->changeTag($tag);
	}

	/**
	 * Get tag.
	 *
	 * @since 0.1.0
	 * @return string
	 */
	public function tag(): string
	{
		return $this->_get('tag');
	}

	/**
	 * Change mixed field.
	 *
	 * @param string $tag
	 * @since 0.1.0
	 * @return self
	 */
	public function changeTag($tag)
	{
		$this->_fields['tag'] = \strval($tag);
		return $this;
	}

	/**
	 * Import and return the object.
	 *
	 * @param array $body
	 * @since 0.1.0
	 * @return self
	 */
	public static function import(array $body = [])
	{
		if (!isset($body['tag'])) {
			throw new InvalidArgumentException('`tag` fields are required.');
		}

		$p = new TagPayload($body['tag']);
		return $p;
	}

	/**
	 * Get payload schema.
	 *
	 * @since 0.1.0
	 * @return array<array<RuleInterface>>
	 */
	protected static function schema(): array
	{
		return [
			'tag' => [new Required([ new StringRule() ])],
		];
	}
}
