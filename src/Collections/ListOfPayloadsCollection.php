<?php

namespace Pgly\Omie\Api\Collections;

use Piggly\ApiClient\Payloads\AbstractPayload;

/**
 * A collection of payloads with list metadatas:
 * page, total pages, records, total records.
 *
 * @package Pgly\Omie\Api
 * @subpackage Pgly\Omie\Api\Collections
 * @version 0.1.0
 * @since 0.1.0
 * @category Collections
 * @author Caique Araujo <caique@piggly.com.br>
 * @author Piggly Lab <dev@piggly.com.br>
 * @license MIT
 * @copyright 2022 Piggly Lab <dev@piggly.com.br>
 */
class ListOfPayloadsCollection
{
	/**
	 * Page number.
	 *
	 * @var int
	 * @since 0.1.0
	 */
	protected $_page = 0;

	/**
	 * Total pages.
	 *
	 * @var int
	 * @since 0.1.0
	 */
	protected $_totalPages = 0;

	/**
	 * Total records.
	 *
	 * @var int
	 * @since 0.1.0
	 */
	protected $_totalRecords = 0;

	/**
	 * Records.
	 *
	 * @var int
	 * @since 0.1.0
	 */
	protected $_records = 0;

	/**
	 * Items
	 *
	 * @var array<AbstractPayload>
	 * @since 0.1.0
	 */
	protected $_items = [];

	/**
	 * Get current page.
	 *
	 * @since 0.1.0
	 * @return int
	 */
	public function page(): int
	{
		return $this->_page;
	}

	/**
	 * Get total pages.
	 *
	 * @since 0.1.0
	 * @return int
	 */
	public function totalPages(): int
	{
		return $this->_totalPages;
	}

	/**
	 * Get total records.
	 *
	 * @since 0.1.0
	 * @return int
	 */
	public function totalRecords(): int
	{
		return $this->_totalRecords;
	}

	/**
	 * Get size of records.
	 *
	 * @since 0.1.0
	 * @return int
	 */
	public function size(): int
	{
		return $this->_records;
	}

	/**
	 * Get items.
	 *
	 * @since 0.1.0
	 * @return array<AbstractPayload>
	 */
	public function items(): array
	{
		return $this->_items;
	}

	/**
	 * Check if is empty.
	 *
	 * @since 0.1.0
	 * @return boolean
	 */
	public function isEmpty()
	{
		return empty($this->_items);
	}

	/**
	 * Check if has next page.
	 */
	public function hasNext()
	{
		return $this->_page < $this->_totalPages;
	}

	/**
	 * Create a list of payloads collection.
	 *
	 * @param integer $page
	 * @param integer $totalpages
	 * @param integer $records
	 * @param integer $totalrecords
	 * @param array $items
	 * @since 0.1.0
	 * @return ListOfPayloadsCollection
	 */
	public static function create(
		int $page,
		int $totalpages,
		int $records,
		int $totalrecords,
		array $items
	): ListOfPayloadsCollection {
		$collection = new self();
		$collection->_page = $page;
		$collection->_totalPages = $totalpages;
		$collection->_records = $records;
		$collection->_totalRecords = $totalrecords;
		$collection->_items = $items;

		return $collection;
	}
}
