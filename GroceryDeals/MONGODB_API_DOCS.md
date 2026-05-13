# MongoDB Data Layer & REST API Documentation

This document summarizes the implementation of the MongoDB data layer and REST API for the **GroceryDeals** application.

## 1. MongoDB Models
All models extend `Jenssegers\Mongodb\Eloquent\Model`.

- **Product**: Manages grocery items with categories, prices, and stock.
- **Category**: Groups products with denormalized `product_count`.
- **Deal**: Manages active promotions with arrays of product IDs.
- **Order**: Handles customer purchases with embedded item objects.

## 2. Eloquent ORM vs. Query Builder

### Eloquent ORM (Recommended)
Eloquent provides a clean, expressive syntax and supports accessors, scopes, and relationships.

```php
// Fetch all products
$products = Product::all();

// Find by ID
$product = Product::find($id);

// Create new product
$product = Product::create(['name' => 'Apple', 'price' => 1.99]);

// Update
$product->update(['price' => 1.49]);

// Delete
$product->delete();

// Complex Query: Category filter, Sort, and Paginate
$fruits = Product::where('category', 'fruits')
    ->orderBy('price')
    ->paginate(12);

// Filter by array of IDs
$selected = Product::whereIn('_id', $ids)->get();
```

### Query Builder Equivalent
The Query Builder is useful for raw performance or when Eloquent features are not needed.

```php
use Illuminate\Support\Facades\DB;

// Fetch all
$products = DB::collection('products')->get();

// Find by ID (Must use ObjectId for native driver)
$product = DB::collection('products')->where('_id', new \MongoDB\BSON\ObjectId($id))->first();

// Paginated query
$fruits = DB::collection('products')
    ->where('category', 'fruits')
    ->orderBy('price', 'asc')
    ->paginate(12);
```

## 3. MongoDB Specific Features

### Array Operations
Adding an item to an embedded array without fetching the whole document:
```php
$product->push('images', 'products/new_angle.jpg');
```

### Array Queries
Finding documents that contain ALL specified tags:
```php
Product::where('tags', 'all', ['organic', 'fresh'])->get();
```

### Raw MongoDB Commands
Using the native MongoDB `$text` search:
```php
Product::raw(function($collection) {
    return $collection->find(['$text' => ['$search' => 'apple']]);
});
```

## 4. ObjectId Handling (`_id` vs `id`)

- **In Database**: MongoDB uses `_id` as the primary key, which is a `BSON\ObjectId`.
- **In Eloquent**:
    - `$product->_id` returns the raw ObjectId or its string representation depending on the driver version.
    - `$product->id` is usually aliased to `_id` for compatibility with standard Laravel logic.
- **In API Responses**: When using `response()->json($product)`, the `_id` is automatically serialized to a string.
- **Route Parameters**: Ensure route patterns account for the 24-character hex string:
  ```php
  Route::pattern('id', '[a-f0-9]{24}');
  ```

## 5. REST API Endpoints

| Method | Endpoint | Description | Auth |
|---|---|---|---|
| GET | `/api/products` | List all products (paginated) | No |
| GET | `/api/products/{id}` | Single product details | No |
| GET | `/api/deals` | Active deals with products | No |
| GET | `/api/categories` | All categories | No |
| POST | `/api/orders` | Create an order | Yes |
| GET | `/api/orders` | User's order history | Yes |

---
**Note:** To run the seeders and populate your database, execute:
```bash
php artisan db:seed --class=ProductSeeder
```
