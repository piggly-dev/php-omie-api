<?php

namespace Pgly\Omie\Api\Payloads;

use Piggly\ApiClient\Payloads\AbstractPayload;
use Piggly\ApiClient\Payloads\Rules\Required;

/**
 * Tag collection payload structure with multiple tags.
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
class TagCollectionPayload extends AbstractPayload
{
	/**
	 * All payload fields.
	 *
	 * @var array
	 * @since 0.1.0
	 */
	protected $_fields = [
		'tags' => []
	];

	/**
	 * Add a new tag.
	 *
	 * @param TagPayload $tag
	 * @since 0.1.0
	 * @return self
	 */
	public function add(TagPayload $tag)
	{
		$this->_fields['tags'][] = $tag;
		return $this;
	}

	/**
	 * Remove a tag.
	 *
	 * @param TagPayload $tag
	 * @since 0.1.0
	 * @return self
	 */
	public function remove(TagPayload $tag)
	{
		$tags = $this->_fields['tags'];
		$index = \array_search($tag, $tags);

		if ($index !== false) {
			unset($tags[$index]);
		}

		$this->_fields['tags'] = $tags;
		return $this;
	}

	/**
	 * Get tags.
	 *
	 * @since 0.1.0
	 * @return array<TagPayload>
	 */
	public function tags(): array
	{
		return $this->_get('tags');
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
		$p = new TagCollectionPayload();

		$p->_fields['tags'] = \array_map(function ($tag) {
			return TagPayload::import($tag);
		}, $body['tags'] ?? []);

		return $p;
	}

	/**
	 * Get all fields converting payloads
	 * to an array and removing null values.
	 *
	 * @since 0.1.0
	 * @return array
	 */
	public function toArray(): array
	{
		$tags = $this->tags();

		$tags = \array_map(function ($tag) {
			return $tag->toArray();
		}, $tags);

		return [
			'tags' => $tags
		];
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
			'tags' => [new Required([])],
		];
	}
}
