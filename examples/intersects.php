<?php

include "../vendor/autoload.php";

use AP\Geometry\Int1D\Geometry\Intersects;
use AP\Geometry\Int1D\Helpers\Shape;

$result = Intersects::intersectsShapes(
    Shape::p(10),
    Shape::s(5, 34)
);
var_dump($result);
// true

$result = Intersects::intersectsShapes(
    Shape::vp(10),
    Shape::s(5, 7)
);
var_dump($result);
// false
