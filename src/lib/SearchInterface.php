<?php 

namespace TestPoly;

/**
 * Interface for searching anything in strings
 */
interface SearchInterface
{

	// Validate input or anything
	public function validate();

	// Initialize searching
	public function init();

	// Make searching
	public function search();

	// retrieve errors if any 
	public function getErrors();

}
?>