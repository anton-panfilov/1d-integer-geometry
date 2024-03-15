# Intersections in 1D Integer Geometry

The **`Intersects`** class is part of the **`AP\Geometry\Int1D\Geometry`** namespace and provides static methods to determine if various geometric shapes (points, segments, and vectors) intersect with each other in 1D space.

## Methods Overview

- **`intersectsPoints`**: Determines if two points intersect (i.e., if they are the same point).
- **`intersectsPointAndSegment`**: Checks if a point intersects with a segment.
- **`intersectsPointAndVector`**: Determines if a point intersects with a vector.
- **`intersectsSegments`**: Checks if two segments intersect.
- **`intersectsSegmentAndVector`**: Determines if a segment and a vector intersect.
- **`intersectsVectors`**: Checks if two vectors intersect.

## Method Details

### `intersectsPoints`

- **Description**: Determines if two points intersect, which occurs if they have the same value.
- **Parameters**:
  - `Point $point1`: The first point.
  - `Point $point2`: The second point.
- **Returns**: `bool` - `true` if the points intersect, `false` otherwise.

### `intersectsPointAndSegment`

- **Description**: Checks if a point intersects with a segment. Intersection occurs if the point's value is within the segment's range.
- **Parameters**:
  - `Point $point`: The point to check.
  - `Segment $segment`: The segment to check against.
- **Returns**: `bool` - `true` if the point intersects with the segment, `false` otherwise.

### `intersectsPointAndVector`

- **Description**: Determines if a point intersects with a vector. Intersection depends on the vector's direction and starting point.
- **Parameters**:
  - `Point $point`: The point to check.
  - `Vector $vector`: The vector to check against.
- **Returns**: `bool` - `true` if the point intersects with the vector, `false` otherwise.

### `intersectsSegments`

- **Description**: Checks if two segments intersect. This occurs if the segments have at least one point in common.
- **Parameters**:
  - `Segment $segment1`: The first segment.
  - `Segment $segment2`: The second segment.
- **Returns**: `bool` - `true` if the segments intersect, `false` otherwise.

### `intersectsSegmentAndVector`

- **Description**: Determines if a segment and a vector intersect. Intersection depends on the vector's direction and the segment's range.
- **Parameters**:
  - `Segment $segment`: The segment to check.
  - `Vector $vector`: The vector to check against.
- **Returns**: `bool` - `true` if the segment and vector intersect, `false` otherwise.

### `intersectsVectors`

- **Description**: Checks if two vectors intersect. Two vectors always intersect if they are in the same direction. If they are in opposite directions, they intersect if their starting points are in a specific order.
- **Parameters**:
  - `Vector $vector1`: The first vector.
  - `Vector $vector2`: The second vector.
- **Returns**: `bool` - `true` if the vectors intersect, `false` otherwise.