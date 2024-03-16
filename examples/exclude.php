<?php

include "../vendor/autoload.php";

use AP\Geometry\Int1D\Exception\NoIntersectsException;
use AP\Geometry\Int1D\Geometry\Exclude;
use AP\Geometry\Int1D\Helpers\Shape;
use AP\Geometry\Int1D\Shape\ShapesCollection;

// exclude one segment from another
$exclude  = Shape::s(-9, 5);
$original = Shape::s(-10, 10);

try {
    $result = Exclude::exclude(exclude: $exclude, original: $original);
} catch (NoIntersectsException $e) {
    // shapes do not intersects
    $result = new ShapesCollection($original);
}
var_export($result);
// Shape::col([Shape::p(-10), Shape::s(6, 10))


// exclude point from the vector
$exclude  = Shape::p(10);
$original = Shape::vp(5);

try {
    $result = Exclude::exclude(exclude: $exclude, original: $original);
} catch (NoIntersectsException $e) {
    // shapes do not intersects
    $result = new ShapesCollection($original);
}

var_export($result);
// Shape::col([Shape::s(5, 9), Shape::vp(11)])