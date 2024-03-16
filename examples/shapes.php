<?php

include "../vendor/autoload.php";

use AP\Geometry\Int1D\Helpers\Shape;
use AP\Geometry\Int1D\Shape\Point;
use AP\Geometry\Int1D\Shape\Segment;
use AP\Geometry\Int1D\Shape\ShapesCollection;
use AP\Geometry\Int1D\Shape\Vector;

// Point
$point = new Point(10);
$point = Shape::p(10);

// Segment
$segment = new Segment(new Point(-9), new Point(5));
$segment = Shape::s(-9, 5);

// Vector (direction towards Positive infinity)
$vector = new Vector(new Point(5), directionTowardsPositiveInfinity: true);
$vector = Shape::vp(5);

// Vector (direction towards Negative infinity)
$vector = new Vector(new Point(5), directionTowardsPositiveInfinity: false);
$vector = Shape::vn(5);

// Collection
$collection = new ShapesCollection([
    new Point(10),
    new Segment(new Point(-9), new Point(5)),
    new Vector(new Point(5), directionTowardsPositiveInfinity: true)
]);
$collection = Shape::col([
    Shape::p(10),
    Shape::s(-9, 5),
    Shape::vp(5)
]);