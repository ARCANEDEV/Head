<?php namespace Arcanedev\Head\Exceptions;

class InvalidTypeException extends Exception
{
	/* ------------------------------------------------------------------------------------------------
	 |  Constructor
	 | ------------------------------------------------------------------------------------------------
	 */
	/**
	 * @param string $name
	 * @param mixed  $value
	 */
	public function __construct($name, $value, $expected = "string")
	{
		$type = gettype($value);

		if ( $type === 'object' )
			$type = get_class($value);

		parent::__construct("The $name must be $expected, $type is given !");
	}
}
