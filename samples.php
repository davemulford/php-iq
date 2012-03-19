<?php
require_once('phplinq.php');
/*$list = array(1,9,2,7,3,8,4,6,5);
$people = array(
			(object)array("firstname" => "John", "lastname" => "Smith"),
			(object)array("firstname" => "Jane", "lastname" => "Doe")
		  );

$normal = array();
$final = array();
foreach ($people as $person) {
	$normal[] = $person;
}

usort($normal, function($a,$b) { return strcmp($a->lastname, $b->lastname); });

foreach ($normal as $n) {
	$final[] = $n->lastname;
}

$query = Queryable::Create($people)
	->Select(function($p) { return $p->lastname; })
	->OrderBy(function($p) { return $p; })
	->ToArray();
 */

$categories = array("books", "music", "games");
$products = array(
				(object)array("category" => "books", 	"name" => "Catcher in the Rye"),
				(object)array("category" => "books", 	"name" => "Lord of the Rings"),
				(object)array("category" => "books", 	"name" => "Silmarillion"),
				(object)array("category" => "music", 	"name" => "Spice Girls"),
				(object)array("category" => "music", 	"name" => "Green Day"),
				(object)array("category" => "games", 	"name" => "Halo"),
				(object)array("category" => "games", 	"name" => "Little Big Planet"),
				(object)array("category" => "games", 	"name" => "Call of Duty"),
				(object)array("category" => "games", 	"name" => "Battlefield"),
			);

$result = Queryable::Create($categories)
	->Where(function($c) { return $c == "games"; })
	->Join($products,
		function($c) { return $c; },
		function($p) { return $p->category; },
		function($c, $p) { return (object)array("category" => $c, "product" => $p->name); })
	->ToArray();


echo('<pre>'. print_r($result, true) .'</pre>');
//echo('<pre>'. print_r($query, true) .'</pre>');


?>
