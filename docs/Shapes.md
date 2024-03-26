# Shape Creation Examples

This document provides examples of creating different geometric shapes using both direct instantiation and helper methods from the AP\Geometry library.

## Point

A `Point` represents a single point in space.

```php
use AP\Geometry\Int1D\Shape\Point;

// Direct instantiation
$point = new Point(10);

// Using a helper method
$point = Shape::p(10);
```

## Segment

A `Segment` represents a line segment defined by two endpoints.

```php
use AP\Geometry\Int1D\Shape\Segment;

// Direct instantiation
$segment = new Segment(new Point(-9), new Point(5));

// Using a helper method
$segment = Shape::s(-9, 5);
```

## Vector

A `Vector` represents a directional line segment. It can be directed towards positive infinity or negative infinity.

### Vector Directed Towards Positive Infinity

```php
use AP\Geometry\Int1D\Shape\Vector;

// Direct instantiation
$vectorPos = new Vector(new Point(5), directionTowardsPositiveInfinity: true);

// Using a helper method
$vectorPos = Shape::vp(5);
```

### Vector Directed Towards Negative Infinity

```php
// Direct instantiation
$vectorNeg = new Vector(new Point(5), directionTowardsPositiveInfinity: false);

// Using a helper method
$vectorNeg = Shape::vn(5);
```

## All

A `All` represents any points from  Negative Infinity to Positive Infinity 

```php
use AP\Geometry\Int1D\Shape\All;

// Direct instantiation
$all = new All();

// Using a helper method
$segment = Shape::all();
```

## ShapesCollection

A `ShapesCollection` is a collection that can contain multiple shapes, including points, segments, and vectors.

```php
use AP\Geometry\Int1D\Shape\ShapesCollection;

// Direct instantiation
$collection = new ShapesCollection([
    new Point(10),
    new Segment(new Point(-9), new Point(5)),
    new Vector(new Point(5), directionTowardsPositiveInfinity: true)
]);

// Using a helper method
$collection = Shape::col([
    Shape::p(10),
    Shape::s(-9, 5),
    Shape::vp(5)
]);
```

Each shape type (Point, Segment, Vector) can be instantiated directly or via the provided helper methods (`Shape::p`, `Shape::s`, `Shape::vp`, `Shape::vn`) for convenience and readability. The `ShapesCollection` class allows grouping multiple shapes together, which can be useful for operations that involve multiple geometric entities.
