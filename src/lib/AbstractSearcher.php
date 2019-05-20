<?php 
namespace TestPoly;

/**
 * Class for common search logic
 */
abstract class AbstractSearcher
{
	
	protected $params;

	public function __construct($params = [])
	{
		$this->params = $params;
	}

	/**
	 * Sorting search results by string length
	 * @return array Sorted search results
	 */
	public function sortResults()
	{
		usort($this->searchResults, function($a, $b) {
		    return mb_strlen($a) - mb_strlen($b);
		});

	    return $this->searchResults;
	}
	
}
?>