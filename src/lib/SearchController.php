<?php

namespace TestPoly;

use TestPoly\AbstractSearcher;
use TestPoly\SearchInterface;

/**
 * Controller for searching anything in strings 
 */
class SearchController
{
	
	protected $searcher;

	protected $result;

	public function __construct(SearchInterface $searcher)
	{
		$this->searcher = $searcher;
	}

	/**
	 * Make searching 
	 * @return SearchController
	 */
	public function doSearching()
	{
		// Regular search
		$this->result = $this->searcher->init()->search();

		// Manaker search
		// $this->result = $this->searcher->init()->searchManaker();

		return $this;
	}

	/**
	 * Get search results
	 * @return array Search results
	 */
	public function getResult()
	{

		if(!count($this->result))
			$this->result[] = 'Палиндромов не найдено';

		return $this->result;
	}

	/**
	 * Validate input of search
	 * @return boolean result of search validation
	 */
	public function validate()
	{
		return $this->searcher->validate();
	}

	/**
	 * Get errors 
	 * @return array errors of search validation
	 */
	public function getErrors()
	{
		return $this->searcher->getErrors();
	}
	
}
?>