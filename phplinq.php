<?php

class Queryable
{
	private $array = null;

	public function Queryable($array) {
		if (is_array($array)) {
			$this->array = $array;
		} else {
			throw new Exception("The 'array' parameter must be an array.");
		}
	}

	public function ToArray() {
		return $this->array;
	}

	public function Where($predicate) {
		$item;
		$newArray = array();

		foreach ($this->array as $item) {
			if ($predicate($item)) {
				$newArray[] = $item;
			}
		}

		return Queryable::Create($newArray);
	}

	public function OrderBy($predicate) {
		$newArray = array();

		foreach ($this->array as $item) {
			$newArray[] = $item;
		}

		$sortFn = function($a, $b) use ($predicate) {
			$x = $predicate($a);
			$y = $predicate($b);

			return (($x < $y) ? -1 : (($x > $y) ? 1 : 0));
		};

		usort($newArray, $sortFn);
		return Queryable::Create($newArray);
	}


	public function OrderByDescending($predicate) {
		$newArray = array();

		foreach ($this->array as $item) {
			$newArray[] = $item;
		}

		$sortFn = function($a, $b) use ($predicate) {
			$x = $predicate($b);
			$y = $predicate($a);

			return (($x < $y) ? -1 : (($x > $y) ? 1 : 0));
		};

		usort($newArray, $sortFn);
		return Queryable::Create($newArray);
	}

	public function Select($predicate) {
		$newArray = array();

		foreach ($this->array as $item) {
			$newArray[] = $predicate($item);
		}

		return Queryable::Create($newArray);
	}

	public function Count($predicate) {
		if ($predicate == null) {
			return count($this->array);
		} else {
			return count($this->Where($predicate));
		}
	}

	public function Any($predicate) {
		return ($this->Count($predicate) > 0);
	}

	public function Join($inner, $outerKeySelector, $innerKeySelector, $projection) {
		$newArray = array();

		foreach ($this->array as $o) {
			foreach ($inner as $i) {
				if ($outerKeySelector($o) == $innerKeySelector($i)) {
					$newArray[] = $projection($o, $i);
				}
			}
		}

		return Queryable::Create($newArray);
	}

	public static function Create($array) {
		return new Queryable($array);
	}
}

?>
