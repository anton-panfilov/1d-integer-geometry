# Intersections

This document provides examples of using the `intersectsShapes` method to determine if two geometric shapes intersect.

## Intersecting a Point and a Segment

```php
use AP\Geometry\Int1D\Helpers\Shape;
use AP\Geometry\Int1D\Shape\Intersects;

// Determine if a Point and a Segment intersect
$result = Intersects::intersectsShapes(
    Shape::p(10),
    Shape::s(5, 34)
);

// Expected result: true
echo $result ? 'true' : 'false';  // Outputs: true
```

In this example, a point at position `10` is checked for intersection with a segment spanning from position `5` to `34`. Since the point lies within the bounds of the segment, the method returns `true`, indicating that they intersect.

## Intersecting a Vector and a Segment

```php
// Determine if a Vector and a Segment intersect
$result = Intersects::intersectsShapes(
    Shape::vp(10),
    Shape::s(5, 7)
);

// Expected result: false
echo $result ? 'true' : 'false';  // Outputs: false
```

In this case, a vector starting at position `10` and extending towards positive infinity is checked for intersection with a segment spanning from position `5` to `7`. Since the vector starts beyond the end of the segment, there is no intersection, and the method returns `false`.

## Summary

The `intersectsShapes` method provides a straightforward way to determine the intersection status between various geometric shapes, such as points, segments, and vectors. By leveraging the `Shape` helper class, shapes can be easily defined and passed to the `intersectsShapes` method for intersection checks.
