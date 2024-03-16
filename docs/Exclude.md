# Examples of Using the `Exclude`

This document provides examples of using the `Exclude` from a geometry library to calculate the geometric difference between two shapes.

## Exclude One Segment from Another

```php
// Using direct instantiation
$exclude  = new Segment(new Point(-9), new Point(5));
$original = new Segment(new Point(-10), new Point(10));

// Using helper methods
$exclude  = Shape::s(-9, 5);
$original = Shape::s(-10, 10);

try {
    $result = Exclude::exclude(exclude: $exclude, original: $original);
} catch (NoIntersectsException $e) {
    // shapes do not intersect
    $result = new ShapesCollection($original);
}

var_export($result);
```

**Expected Result:**

A `ShapesCollection` containing a point at `-10` and a segment from `6` to `10`.

```php
Shape::col([
   Shape::p(-10),
   Shape::s(6, 10)
])
```

## Exclude Point from the Vector

```php
// Using direct instantiation
$exclude  = new Point(10);
$original = new Vector(new Point(5), directionTowardsPositiveInfinity: true);

// Using helper methods
$exclude  = Shape::p(10);
$original = Shape::vp(5);

try {
    $result = Exclude::exclude(exclude: $exclude, original: $original);
} catch (NoIntersectsException $e) {
    // shapes do not intersect
    $result = new ShapesCollection($original);
}

var_export($result);
```

**Expected Result:**

A `ShapesCollection` containing a segment from `5` to `9` and a vector starting from `11` towards positive infinity.

```php
Shape::col([
   Shape::s(5, 9),
   Shape::vp(11)
])
```
