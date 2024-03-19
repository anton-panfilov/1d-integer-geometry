# Examples of Using the `Exclude`

This document provides examples of using the `Exclude` from a geometry library to calculate the geometric difference
between two shapes.

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

<?xml version="1.0" ?>
<svg xmlns="http://www.w3.org/2000/svg" width="500" height="150">
	<line x1="10" y1="50" x2="490" y2="50" stroke="black"/>
	<text x="25" y="65" fill="black" style="font: 12px sans-serif;">-10</text>
	<text x="72.5" y="65" fill="black" style="font: 12px sans-serif;">-9</text>
	<text x="275" y="65" fill="black" style="font: 12px sans-serif;">5</text>
	<text x="327.5" y="65" fill="black" style="font: 12px sans-serif;">6</text>
	<text x="475" y="65" fill="black" style="font: 12px sans-serif;">10</text>
	<line x1="25" y1="30" x2="475" y2="30" stroke="blue"/>
	<text x="250" y="20" fill="blue" style="font: italic 13px sans-serif;">Original</text>
	<line x1="72.5" y1="75" x2="275" y2="75" stroke="red"/>
	<text x="170" y="95" fill="red" style="font: italic 13px sans-serif;">Excluded</text>
	<circle cx="25" cy="120" r="3" fill="green"/>
	<line x1="327.5" y1="120" x2="475" y2="120" stroke="green"/>
	<text x="400" y="110" fill="green" style="font: italic 13px sans-serif;">Result</text>
</svg>


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

<?xml version="1.0"?>
<svg width="500" height="200" xmlns="http://www.w3.org/2000/svg">
  <line x1="10" y1="50" x2="490" y2="50" stroke="black"/>
  <text x="125" y="65" fill="black" style="font: 12px sans-serif;">5</text>
  <text x="223" y="65" fill="black" style="font: 12px sans-serif;">9</text>
  <text x="244" y="65" fill="black" style="font: 12px sans-serif;">10</text>
  <text x="272" y="65" fill="black" style="font: 12px sans-serif;">11</text>
  <line x1="125" y1="30" x2="475" y2="30" stroke="blue"/>
  <polyline points="465,25 475,30 465,35" stroke="blue" fill="blue"/>
  <text x="360" y="20" fill="blue" style="font: italic 13px sans-serif;">Original</text>
  <circle cx="250" cy="75" r="3" fill="red"/>
  <text x="230" y="95" fill="red" style="font: italic 13px sans-serif;">Excluded</text>
  <line x1="125" y1="120" x2="225" y2="120" stroke="green"/>
  <line x1="275" y1="120" x2="475" y2="120" stroke="green"/>
  <polyline points="465,115 475,120 465,125" stroke="green" fill="green"/>
  <text x="400" y="110" fill="green" style="font: italic 13px sans-serif;">Result</text>
</svg>

A `ShapesCollection` containing a segment from `5` to `9` and a vector starting from `11` towards positive infinity.

```php
Shape::col([
   Shape::s(5, 9),
   Shape::vp(11)
])
```
