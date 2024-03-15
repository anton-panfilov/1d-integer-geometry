# 1D Geometry Sorting

The **`Sort`** class is part of the **`AP\Geometry\Int1D\Geometry`** namespace and provides static methods for sorting shapes based on certain criteria in 1D space. The sorting is performed on a collection of shapes and returns a new collection in the sorted order.

## Methods Overview

- **`sortByMin`**: Sorts shapes by their minimum value.
- **`sortByMinAndLength`**: Sorts shapes by their minimum value and then by their length.

## Method Details

### `sortByMin`

- **Description**: Sorts a collection of shapes based on the minimum value of each shape. It is designed to handle shapes where calculating the minimum value requires additional computation, which is cached to improve efficiency.
- **Parameters**:
  - `ShapesCollection $shapes`: The collection of shapes to be sorted.
- **Returns**: `ShapesCollection` - A new collection of shapes sorted by their minimum value.
- **Throws**: `UnexpectedValueException` if any element in the collection is not an instance of `AbstractShape`.
- **Example**:
  ```php
  $shapes = new ShapesCollection([new Segment(new Point(2), new Point(5)), new Point(1)]);
  $sortedShapes = Sort::sortByMin($shapes);
  // $sortedShapes will be a ShapesCollection sorted by the minimum value of each shape, in this case starting with the Point(1)


### `sortByMinAndLength`

**Description**: Sorts a collection of shapes first by their minimum value and then by their length. This method is useful when shapes need to be ordered not just by position but also by size, with special handling for vectors that might have infinite length.

**Parameters**:
- `ShapesCollection $shapes`: The collection of shapes to be sorted.

**Returns**: `ShapesCollection` - A new collection of shapes sorted first by their minimum value and then by their length.

**Throws**: `UnexpectedValueException` if any element in the collection is not an instance of `AbstractShape`.

**Example**:
```php
$shapes = new ShapesCollection([
    new Segment(new Point(2), new Point(5)),
    new Segment(new Point(2), new Point(6)),
    new Point(1)
]);
$sortedShapes = Sort::sortByMinAndLength($shapes);
// $sortedShapes will be a ShapesCollection sorted first by the minimum value of each shape and then by their length. The order will be Point(1), Segment([2,5]), and Segment([2,6]).