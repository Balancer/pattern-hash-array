<?php

class PatternHashArray implements ArrayAccess
{
	private $container = [];

	const ASSOC = 1;
	const REGEXP = 2;
	const GLOB = 3;

	function offsetSet($key, $value)
	{
		if(is_array($key))
			list($key, $type) = $key;
		else
			$type = self::ASSOC;

		$this->container[$key] = [$value, $type];
	}

	function offsetExists($key)
	{
		if(is_array($key))
			list($key, $type) = $key;
		else
			$type = self::ASSOC;

		return isset($this->container[$key]);
	}

	function offsetUnset($key)
	{
		if(is_array($key))
			list($key, $type) = $key;
		else
			$type = self::ASSOC;

		unset($this->container[$key]);
	}

	function offsetGet($key)
	{
		foreach($this->container as $pattern => $value)
		{
			switch($value[1])
			{
				case self::ASSOC:
					if($pattern == $key)
						return $value[0];

					break;

				case self::REGEXP:

					if(preg_match('#'.str_replace('#', "\\#", $pattern).'#', $key))
						return $value[0];
					break;

				case self::GLOB:

					if(fnmatch($pattern, $key))
						return $value[0];

					break;
			}
		}

		return NULL;
	}
}
