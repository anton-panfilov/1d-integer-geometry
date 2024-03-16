# 1D Integer Geometry Library

The 1D Integer Geometry Library, `anton-panfilov/1d-integer-geometry`, provides a comprehensive set of tools for performing geometric operations on 1-dimensional integer shapes. This includes functionality for determining intersections, exclusions, and sorting of geometric shapes such as points, segments, and vectors. The library is designed to be intuitive and easy to use, catering to a wide range of applications in computational geometry, computer graphics, and related fields.

## Key Features

- **Exclusion**: Compute the geometric difference between shapes, effectively excluding one shape from another.
- **Intersection**: Determine whether two shapes intersect and calculate the intersection points.
- **Shapes**: Create and manipulate basic 1D geometric shapes, including points, segments, and vectors.
- **Sorting**: Sort collections of geometric shapes based on their positions.

## Installation

The library can be installed using Composer, a dependency manager for PHP. To add the 1D Integer Geometry Library to your project, run the following command in your project's root directory:

```bash
composer require anton-panfilov/1d-integer-geometry
```

## Usage

### Excluding Shapes

```php
$result = Exclude::exclude(
    Shape::s(-9, 5),
    Shape::s(-10, 10)
);
```

### Intersecting Shapes

```php
$result = Intersects::intersectsShapes(
    Shape::p(10),
    Shape::s(5, 34)
);
// true

$result = Intersects::intersectsShapes(
    Shape::vp(10),
    Shape::s(5, 7)
);
// false
```

### Creating Shapes

```php
$point = Shape::p(10);
$segment = Shape::s(-9, 5);
```

### Sorting Shapes

Refer to the `Sort.md` documentation for detailed examples and usage.

For more detailed documentation on each feature, refer to the respective files in the `docs` directory:

- [Exclude](docs/Exclude.md)
- [Intersects](docs/Intersects.md)
- [Shapes](docs/Shapes.md)
- [Sort](docs/Sort.md)

## Contributing

Contributions to the 1D Integer Geometry Library are welcome. Please refer to the contributing guidelines for more information.

## License

This library is released under the MIT License. See the LICENSE file for details.
