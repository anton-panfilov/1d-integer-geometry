# Excludes in 1D Integer Geometry

The **`Exclude`** class is part of the **`AP\Geometry\Int1D\Geometry`** namespace and provides static methods for excluding points, segments, and vectors from one another. The results are returned in a **`ShapesCollection`**.

## Methods Overview

- **`excludePointFromSegment`**: Excludes a point from a segment, potentially splitting the segment into two.
- **`excludePointFromVector`**: Excludes a point from a vector, potentially altering the vector's start or splitting it into a segment and a vector.
- **`excludeSegmentFromSegment`**: Excludes a segment from another segment, potentially splitting the original segment into two.
- **`excludeSegmentFromVector`**: Excludes a segment from a vector, potentially altering the vector or splitting it into a segment and a vector.
- **`excludeVectorFromSegment`**: Excludes a vector from a segment, potentially shortening the segment or splitting it.
- **`excludeVectorFromVector`**: Excludes a vector from another vector, potentially altering the vector or converting it into a segment.

## Method Details

### `excludePointFromSegment`

- **Description**: Excludes a point from a segment, which may result in the segment being shortened or split into two new segments.
- **Parameters**:
    - `Point $excludePoint`: The point to be excluded from the segment.
    - `Segment $originalSegment`: The segment from which the point is to be excluded.
- **Returns**: A `ShapesCollection` containing 0 to 2 shapes (either `Segment` or `Point`).
- **Throws**: `NoIntersectsException` if the point does not intersect with the segment.
- **Example**:
  ```php
  $excludePoint = new Point(5);
  $originalSegment = new Segment(new Point(3), new Point(8));
  $result = Exclude::excludePointFromSegment($excludePoint, $originalSegment);
  // Result: ShapesCollection containing two segments [3,4] and [6,8]
  ```

### `excludePointFromVector`

- **Description**: Excludes a point from a vector, which may result in the vector's start being changed or the vector being split into a segment and a vector.
- **Parameters**:
    - `Point $excludePoint`: The point to be excluded.
    - `Vector $originalVector`: The original vector from which the point is to be excluded.
- **Returns**: A `ShapesCollection` containing 1 to 2 shapes (either `Vector`, `Point`, or `Segment`).
- **Throws**: `NoIntersectsException` if the point does not intersect with the vector.
- **Example**:
  ```php
  $excludePoint = new Point(10);
  $originalVector = new Vector(new Point(5), true);
  $result = Exclude::excludePointFromVector($excludePoint, $originalVector);
  // Result: ShapesCollection containing a new vector starting from point 11
  ```

### `excludeSegmentFromSegment`

- **Description**: Excludes a segment from another segment, potentially splitting the original segment into two.
- **Parameters**:
    - `Segment $excludeSegment`: The segment to be excluded.
    - `Segment $originalSegment`: The segment from which to exclude the other segment.
- **Returns**: A `ShapesCollection` containing 0 to 2 shapes (either `Segment` or `Point`).
- **Throws**: `NoIntersectsException` if the segments do not intersect.
- **Example**:
  ```php
  $excludeSegment = new Segment(new Point(4), new Point(6));
  $originalSegment = new Segment(new Point(2), new Point(8));
  $result = Exclude::excludeSegmentFromSegment($excludeSegment, $originalSegment);
  // Result: ShapesCollection containing two segments [2,3] and [7,8]
  ```

### `excludeSegmentFromVector`

- **Description**: Excludes a segment from a vector, which may result in the vector's start being changed or the vector being split into a segment and a vector.
- **Parameters**:
    - `Segment $excludeSegment`: The segment to be excluded.
    - `Vector $originalVector`: The vector from which to exclude the segment.
- **Returns**: A `ShapesCollection` containing 1 to 2 shapes (either `Vector` or `Segment`).
- **Throws**: `NoIntersectsException` if the segment does not intersect with the vector.
- **Example**:
  ```php
  $excludeSegment = new Segment(new Point(10), new Point(12));
  $originalVector = new Vector(new Point(5), true);
  $result = Exclude::excludeSegmentFromVector($excludeSegment, $originalVector);
  // Result: ShapesCollection containing a segment [5,9] and a vector starting from 13
  ```

### `excludeVectorFromSegment`

- **Description**: Excludes a vector from a segment, potentially shortening the segment or splitting it into two. If the vector's direction and position completely overlap with the segment, the segment might be entirely removed.
- **Parameters**:
  - `Vector $excludeVector`: The vector to be excluded from the segment.
  - `Segment $originalSegment`: The segment from which the vector is to be excluded.
- **Returns**: A `ShapesCollection` containing 0 to 1 shape (either `Segment` or `Point`), depending on the exclusion result.
- **Throws**: `NoIntersectsException` if the vector does not intersect with the segment.
- **Example**:
  ```php
  $excludeVector = new Vector(new Point(3), true); // Vector starting at 3 and extending towards positive infinity
  $originalSegment = new Segment(new Point(1), new Point(5));
  $result = Exclude::excludeVectorFromSegment($excludeVector, $originalSegment);
  // Result: ShapesCollection containing one segment [1,2]

### `excludeVectorFromVector`

- **Description**: Excludes a vector from another vector. Depending on the vectors' directions and starting points, the operation might shorten the original vector, convert it into a segment, or leave it unchanged if there is no meaningful overlap.
- **Parameters**:
  - `Vector $excludeVector`: The vector to be excluded from the original vector.
  - `Vector $originalVector`: The vector from which the exclusion is to be made.
- **Returns**: A `ShapesCollection` containing 0 to 1 shape (either `Vector`, `Segment`, or `Point`), depending on the exclusion's outcome.
- **Throws**: `NoIntersectsException` if the vectors do not intersect or if the exclusion does not result in a meaningful change.
- **Example**:
  ```php
  $excludeVector = new Vector(new Point(4), true); // Vector starting at 4 and extending towards positive infinity
  $originalVector = new Vector(new Point(2), true); // Vector starting at 2 and extending towards positive infinity
  $result = Exclude::excludeVectorFromVector($excludeVector, $originalVector);
  // Result: ShapesCollection containing one segment [2,3]