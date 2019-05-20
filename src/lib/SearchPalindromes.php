<?php 

namespace TestPoly;

use TestPoly\AbstractSearcher;
use TestPoly\SearchInterface;

/**
 * Search palindromes in string
 */
class SearchPalindromes extends AbstractSearcher implements SearchInterface
{

	private $searchString;
	private $processedSymbols;
	private $errors;
	protected $searchResults;

	/**
	 * Validates input
	 * @return boolean Validation result
	 */
	public function validate()
	{
		$this->errors = [];
		$this->searchResults = [];

		if(!isset($this->params['searchString'])){
			$this->errors['searchString'][] = 'Не указана строка для поиска в запросе';
		}

		if(isset($this->params['searchString']) && trim($this->params['searchString'])==''){
			$this->errors['searchString'][] = 'Строка для поиска пустая';	
		}

		// some more validation here if any
		
		return empty($this->errors);

	}

	/**
	 * Get errors
	 * @return array Array of errors
	 */
	public function getErrors()
	{
		return ['errors' => $this->errors];
	}

	/**
	 * Initialisation of params
	 * @return SearchPalindromes
	 */
	public function init()
	{
		$this->searchString = trim($this->params['searchString'] ?? null);

		$this->searchString = mb_strtolower($this->searchString);

		if(mb_strlen($this->searchString) == 0)
			$this->searchString = null;

		return $this;
	}

	/**
	 * Make regular search of palindromes
	 * @return array Search result (sorted)
	 */
	public function search()
	{
		$this->searchResults = [];

		$charsArray = preg_split('//u', $this->searchString, -1, PREG_SPLIT_NO_EMPTY);

		for($i = 0; $i < count($charsArray); $i++){

			$tempStr = $charsArray[$i];

			for($j = $i+1; $j < count($charsArray); $j++){

				$tempStr .= $charsArray[$j];

				if($this->isPalindrome($charsArray, $i, $j)){					
					$this->addToResults($tempStr);				
				}

			}

		}

		return $this->sortResults();
	}

	/**
	 * Test for palindrome in regular search
	 * @param  array $charsArray Array of characters of original string
	 * @param  int  $i          Start position of substring to test for 
	 * @param  int  $j          End position of substring to test for
	 * @return boolean          Test for palindrome result
	 */
	public function isPalindrome($charsArray = [], $i, $j)
	{
		while($i <= $j){

			if($charsArray[$i] != $charsArray[$j])
				return false;

			$i++;
			$j--;

		}		

		return true;

	}

	/**
	 * Add string to results
	 * @param string $palindromeSubstring String to add to results
	 */
	public function addToResults($palindromeSubstring)
	{
	    if(!in_array($palindromeSubstring, $this->searchResults))
	    	$this->searchResults[] = $palindromeSubstring;
	}

	/**
	 * Wrapper for seach for palindromes using Manaker algorythm
	 * @return array Search result (sorted)
	 */
	public function searchManaker()
	{
		$this->searchResults = [];

		$charsArray = preg_split('//u', $this->searchString, -1, PREG_SPLIT_NO_EMPTY);

		$this->palindromeOdd($charsArray);
		$this->palindromeEven($charsArray);		
		
		return $this->sortResults();
	}

	/**
	 * Search for palindromes which are odd length using Manaker algorythm
	 * @param  array $charsArray Array of characters of original string
	 */
	function palindromeOdd($charsArray){

		$leftBorder = 0;
		$rightBorder = -1;
		$tempMirror = null;

		for($i = 0; $i < count($charsArray); $i++){

			$tempMirror = ($i > $rightBorder ? 0 : min($answers[$leftBorder + $rightBorder - $i], $rightBorder - $i)) + 1;

			while($i + $tempMirror < count($charsArray) && $i - $tempMirror >= 0 && $charsArray[$i - $tempMirror] == $charsArray[$i + $tempMirror]){
				$tempMirror++;
			}
			// echo ' w:'.$tempMirror;

			$answers[$i] = --$tempMirror;

			if($i + $tempMirror > $rightBorder){
				$leftBorder = $i - $tempMirror;
				$rightBorder = $i + $tempMirror;            
			}

			for($k = 0; $k < $answers[$i]; $k++){
				$tempStr = mb_substr($this->searchString, $leftBorder+$k, ($rightBorder - $leftBorder + 1) - $k*2);
				$this->addToResults($tempStr);
			}
		}

	}

	/**
	 * Search for palindromes which are even length using Manaker algorythm
	 * @param  array $charsArray Array of characters of original string
	 */
	function palindromeEven($charsArray){

		$leftBorder = 0;
		$rightBorder = -1;
		$tempMirror = null;

		for($i = 0; $i < count($charsArray); $i++){

			$tempMirror = ($i > $rightBorder ? 0 : min($answers[$leftBorder + $rightBorder - $i + 1], $rightBorder - $i + 1)) + 1;

			while($i + $tempMirror - 1 < count($charsArray) && $i - $tempMirror >= 0 && $charsArray[$i - $tempMirror] == $charsArray[$i + $tempMirror - 1]){
				$tempMirror++;
			}
			// echo ' w:'.$tempMirror;

			$answers[$i] = --$tempMirror;

			if($i + $tempMirror - 1 > $rightBorder){
				$leftBorder = $i - $tempMirror;
				$rightBorder = $i + $tempMirror - 1;            
			}

			for($k = 0; $k < $answers[$i]; $k++){
				$tempStr = mb_substr($this->searchString, $leftBorder+$k, ($rightBorder - $leftBorder + 1) - $k*2);
				$this->addToResults($tempStr);
			}
		}

	}

}

?>