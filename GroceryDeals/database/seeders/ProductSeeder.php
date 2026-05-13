<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Deal;
use App\Models\User;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // ── 1. Seed Demo User ──────────────────────────────────────────
        User::updateOrCreate(['email' => 'demo@grocerydeals.com'], [
            'name'     => 'Demo User',
            'email'    => 'demo@grocerydeals.com',
            'password' => Hash::make('password'),
        ]);

        // ── 2. Seed Categories ─────────────────────────────────────────
        $categories = [
            ['name' => 'Fruits',     'slug' => 'fruits',     'icon' => '🍎', 'color' => '#ef4444', 'description' => 'Fresh seasonal fruits from local farms'],
            ['name' => 'Vegetables', 'slug' => 'vegetables', 'icon' => '🥦', 'color' => '#16a34a', 'description' => 'Farm-fresh organic vegetables daily'],
            ['name' => 'Dairy',      'slug' => 'dairy',      'icon' => '🥛', 'color' => '#3b82f6', 'description' => 'Milk, cheese, butter & yogurt'],
            ['name' => 'Bakery',     'slug' => 'bakery',     'icon' => '🍞', 'color' => '#f59e0b', 'description' => 'Freshly baked bread & pastries'],
            ['name' => 'Beverages',  'slug' => 'beverages',  'icon' => '🧃', 'color' => '#06b6d4', 'description' => 'Juices, water & soft drinks'],
            ['name' => 'Meat',       'slug' => 'meat',       'icon' => '🥩', 'color' => '#dc2626', 'description' => 'Fresh chicken, mutton & fish'],
            ['name' => 'Snacks',     'slug' => 'snacks',     'icon' => '🍿', 'color' => '#8b5cf6', 'description' => 'Chips, biscuits & namkeen'],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }

        // ── 3. Seed 35 Products with Indian Pricing ────────────────────
        $products = [
            // FRUITS
            ['name'=>'Fresh Red Apples (1 kg)',       'category'=>'fruits',     'price'=>149,'original_price'=>199,'discount_percentage'=>25,'description'=>'Crisp and juicy Shimla apples, handpicked from Himachal Pradesh orchards. Rich in fibre and antioxidants.','image_url'=>'https://images.unsplash.com/photo-1567306226416-28f0efdc88ce?w=400&h=250&fit=crop'],
            ['name'=>'Organic Bananas (1 dozen)',      'category'=>'fruits',     'price'=>59, 'original_price'=>79, 'discount_percentage'=>25,'description'=>'Sweet and ripe Kerala bananas. A great energy booster – perfect for breakfast or post-workout snack.','image_url'=>'https://images.unsplash.com/photo-1571771894821-ce9b6c11b08e?w=400&h=250&fit=crop'],
            ['name'=>'Green Seedless Grapes (500g)',   'category'=>'fruits',     'price'=>129,'original_price'=>179,'discount_percentage'=>28,'description'=>'Plump, seedless Nasik grapes. Naturally sweet with a refreshing crunch. Low calorie and high in vitamins.','image_url'=>'https://images.unsplash.com/photo-1537640538966-79f369143f8f?w=400&h=250&fit=crop'],
            ['name'=>'Sweet Oranges (4 pcs)',          'category'=>'fruits',     'price'=>89, 'original_price'=>109,'discount_percentage'=>18,'description'=>'Juicy Nagpur oranges bursting with Vitamin C. Great for fresh juice or eating as-is.','image_url'=>'https://images.unsplash.com/photo-1582979512210-99b6a53386f9?w=400&h=250&fit=crop'],
            ['name'=>'Watermelon (whole)',             'category'=>'fruits',     'price'=>79, 'original_price'=>99, 'discount_percentage'=>20,'description'=>'Sweet, chilled summer watermelon. Hydrating and delicious – a must-have for hot days.','image_url'=>'https://images.unsplash.com/photo-1563114773-84221bd62daa?w=400&h=250&fit=crop'],
            ['name'=>'Alphonso Mangoes (6 pcs)',       'category'=>'fruits',     'price'=>349,'original_price'=>449,'discount_percentage'=>22,'description'=>'The king of mangoes! Premium Ratnagiri Alphonso with rich aroma and buttery texture.','image_url'=>'https://images.unsplash.com/photo-1553279768-865429fa0078?w=400&h=250&fit=crop'],
            // VEGETABLES
            ['name'=>'Baby Spinach (250g)',            'category'=>'vegetables', 'price'=>49, 'original_price'=>69, 'discount_percentage'=>29,'description'=>'Tender baby spinach leaves, triple-washed and ready to use. Rich in iron, calcium and folate.','image_url'=>'https://images.unsplash.com/photo-1576045057995-568f588f82fb?w=400&h=250&fit=crop'],
            ['name'=>'Fresh Carrots (500g)',           'category'=>'vegetables', 'price'=>39, 'original_price'=>59, 'discount_percentage'=>34,'description'=>'Crunchy, sweet Ooty carrots. Perfect for curries, soups, salads and juices. High in beta-carotene.','image_url'=>'https://images.unsplash.com/photo-1598170845058-32b9d6a5da37?w=400&h=250&fit=crop'],
            ['name'=>'Red Bell Pepper (2 pcs)',        'category'=>'vegetables', 'price'=>79, 'original_price'=>99, 'discount_percentage'=>20,'description'=>'Vibrant red capsicum with a sweet, mild flavour. Great for stir-fries, salads and sandwiches.','image_url'=>'https://images.unsplash.com/photo-1563565375-f3fdfdbefa83?w=400&h=250&fit=crop'],
            ['name'=>'Broccoli (1 head)',              'category'=>'vegetables', 'price'=>89, 'original_price'=>129,'discount_percentage'=>31,'description'=>'Fresh green broccoli florets. A powerhouse of nutrition packed with Vitamin C, K and fibre.','image_url'=>'https://images.unsplash.com/photo-1459411621453-7b03977f4bfc?w=400&h=250&fit=crop'],
            ['name'=>'White Onions (1 kg)',            'category'=>'vegetables', 'price'=>35, 'original_price'=>49, 'discount_percentage'=>29,'description'=>'Farm-fresh Nashik onions. The backbone of Indian cooking. Pungent, flavourful and essential.','image_url'=>'https://images.unsplash.com/photo-1518977822534-7049a61ee0c2?w=400&h=250&fit=crop'],
            ['name'=>'Tomatoes (500g)',                'category'=>'vegetables', 'price'=>29, 'original_price'=>45, 'discount_percentage'=>36,'description'=>'Ripe, vine-grown tomatoes perfect for curries, chutneys, salads and sandwiches.','image_url'=>'https://images.unsplash.com/photo-1592841200221-a6898f307baa?w=400&h=250&fit=crop'],
            ['name'=>'Fresh Garlic (100g)',            'category'=>'vegetables', 'price'=>25, 'original_price'=>35, 'discount_percentage'=>29,'description'=>'Aromatic fresh garlic bulbs. Essential for flavouring dals, curries and sabzis.','image_url'=>'https://images.unsplash.com/photo-1540148426945-6cf22a6b2383?w=400&h=250&fit=crop'],
            // DAIRY
            ['name'=>'Full Cream Milk (1 litre)',      'category'=>'dairy',      'price'=>68, 'original_price'=>75, 'discount_percentage'=>9, 'description'=>'Fresh, pasteurised full cream cow milk. Rich, creamy and nutritious for the whole family.','image_url'=>'https://images.unsplash.com/photo-1563636619-e9143da7973b?w=400&h=250&fit=crop'],
            ['name'=>'Greek Yogurt (400g)',            'category'=>'dairy',      'price'=>129,'original_price'=>159,'discount_percentage'=>19,'description'=>'Thick, probiotic-rich Greek yogurt. High in protein and great for smoothies or as a dip.','image_url'=>'https://images.unsplash.com/photo-1488477181946-6428a0291777?w=400&h=250&fit=crop'],
            ['name'=>'Amul Butter (500g)',             'category'=>'dairy',      'price'=>249,'original_price'=>275,'discount_percentage'=>9, 'description'=>'The iconic Amul butter – salted, creamy and perfect on toast, parathas or in baking.','image_url'=>'https://images.unsplash.com/photo-1550583724-b2692b85b150?w=400&h=250&fit=crop'],
            ['name'=>'Mozzarella Cheese (200g)',       'category'=>'dairy',      'price'=>199,'original_price'=>249,'discount_percentage'=>20,'description'=>'Stretchy, fresh mozzarella cheese. Perfect for pizzas, pasta, bruschetta and salads.','image_url'=>'https://images.unsplash.com/photo-1486297678162-eb2a19b0a32d?w=400&h=250&fit=crop'],
            ['name'=>'Dahi / Curd (500ml)',            'category'=>'dairy',      'price'=>49, 'original_price'=>55, 'discount_percentage'=>11,'description'=>'Thick, creamy set curd made from fresh cow milk. Great with meals, as raita or a lassi.','image_url'=>'https://images.unsplash.com/photo-1570696516188-ade861b84a49?w=400&h=250&fit=crop'],
            // BAKERY
            ['name'=>'Multigrain Bread (400g)',        'category'=>'bakery',     'price'=>69, 'original_price'=>85, 'discount_percentage'=>19,'description'=>'Hearty multigrain loaf with oats, flax seeds and sesame. High fibre, low GI – great for a healthy breakfast.','image_url'=>'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=400&h=250&fit=crop'],
            ['name'=>'Butter Croissant (2 pcs)',       'category'=>'bakery',     'price'=>99, 'original_price'=>129,'discount_percentage'=>23,'description'=>'Flaky, buttery French croissants baked fresh every morning. Perfect with jam or a cup of chai.','image_url'=>'https://images.unsplash.com/photo-1555507036-ab1f4038808a?w=400&h=250&fit=crop'],
            ['name'=>'Blueberry Muffins (4 pcs)',      'category'=>'bakery',     'price'=>149,'original_price'=>199,'discount_percentage'=>25,'description'=>'Soft, fluffy muffins bursting with real blueberries. A sweet treat for any time of day.','image_url'=>'https://images.unsplash.com/photo-1607958996333-41aef7caefaa?w=400&h=250&fit=crop'],
            ['name'=>'Garlic Baguette',               'category'=>'bakery',     'price'=>79, 'original_price'=>99, 'discount_percentage'=>20,'description'=>'Crispy on the outside, soft inside – loaded with garlic butter. Great as a soup accompaniment.','image_url'=>'https://images.unsplash.com/photo-1549931319-a545dcf3bc73?w=400&h=250&fit=crop'],
            ['name'=>'Whole Wheat Pav (6 pcs)',        'category'=>'bakery',     'price'=>45, 'original_price'=>55, 'discount_percentage'=>18,'description'=>'Soft whole wheat dinner rolls. Healthy swap for white pav. Perfect for vada pav or bhaji.','image_url'=>'https://images.unsplash.com/photo-1620921568790-c1cf8983bc62?w=400&h=250&fit=crop'],
            // BEVERAGES
            ['name'=>'Fresh Orange Juice (1L)',        'category'=>'beverages',  'price'=>129,'original_price'=>159,'discount_percentage'=>19,'description'=>'Cold-pressed, 100% natural orange juice with no added sugar, preservatives or colours.','image_url'=>'https://images.unsplash.com/photo-1621506289937-a8e4df240d0b?w=400&h=250&fit=crop'],
            ['name'=>'Sparkling Mineral Water (1L)',   'category'=>'beverages',  'price'=>45, 'original_price'=>55, 'discount_percentage'=>18,'description'=>'Natural sparkling mineral water with gentle bubbles. Refreshing and hydrating.','image_url'=>'https://images.unsplash.com/photo-1548839140-29a749e1cf4d?w=400&h=250&fit=crop'],
            ['name'=>'Masala Chai Pack (250g)',        'category'=>'beverages',  'price'=>249,'original_price'=>299,'discount_percentage'=>17,'description'=>'Premium Assam CTC tea blended with cardamom, ginger and cloves. Brew the perfect cup of chai.','image_url'=>'https://images.unsplash.com/photo-1571934811356-5cc061b6821f?w=400&h=250&fit=crop'],
            ['name'=>'Mango Lassi (500ml)',            'category'=>'beverages',  'price'=>89, 'original_price'=>109,'discount_percentage'=>18,'description'=>'Thick, creamy mango lassi made with real Alphonso mango pulp and fresh curd. Chilled to perfection.','image_url'=>'https://images.unsplash.com/photo-1553530666-ba11a7da3888?w=400&h=250&fit=crop'],
            ['name'=>'Coconut Water (330ml)',          'category'=>'beverages',  'price'=>55, 'original_price'=>65, 'discount_percentage'=>15,'description'=>'Pure, natural coconut water – nature\'s electrolyte drink. No added sugar, preservatives or flavours.','image_url'=>'https://images.unsplash.com/photo-1560493676-04071c5f467b?w=400&h=250&fit=crop'],
            // MEAT
            ['name'=>'Fresh Chicken Breast (500g)',   'category'=>'meat',       'price'=>299,'original_price'=>379,'discount_percentage'=>21,'description'=>'Boneless, skinless fresh chicken breast. Lean, high-protein and perfect for grilling or curries.','image_url'=>'https://images.unsplash.com/photo-1587593810167-a84920ea0781?w=400&h=250&fit=crop'],
            ['name'=>'Mutton Keema (500g)',            'category'=>'meat',       'price'=>549,'original_price'=>649,'discount_percentage'=>15,'description'=>'Freshly minced mutton from free-range goats. Great for keema matar, biryani and seekh kebabs.','image_url'=>'https://images.unsplash.com/photo-1607623814075-e51df1bdc82f?w=400&h=250&fit=crop'],
            ['name'=>'Rohu Fish (1 kg)',               'category'=>'meat',       'price'=>299,'original_price'=>349,'discount_percentage'=>14,'description'=>'Fresh Rohu fish, cleaned and cut. A staple of Bengali cooking – great for curries and fry.','image_url'=>'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=400&h=250&fit=crop'],
            // SNACKS
            ['name'=>'Aloo Bhujia Namkeen (400g)',    'category'=>'snacks',     'price'=>149,'original_price'=>175,'discount_percentage'=>15,'description'=>'Crispy, spiced Bikaneri-style aloo bhujia. The perfect tea-time companion. Light and crunchy.','image_url'=>'https://images.unsplash.com/photo-1555949258-eb67b1ef0ceb?w=400&h=250&fit=crop'],
            ['name'=>'Dark Chocolate (100g)',          'category'=>'snacks',     'price'=>199,'original_price'=>249,'discount_percentage'=>20,'description'=>'70% dark chocolate made with single-origin Ghana cocoa beans. Rich, intense and antioxidant-packed.','image_url'=>'https://images.unsplash.com/photo-1481391319762-47dff72954d9?w=400&h=250&fit=crop'],
            ['name'=>'Roasted Almonds (200g)',         'category'=>'snacks',     'price'=>249,'original_price'=>299,'discount_percentage'=>17,'description'=>'Lightly salted, dry-roasted California almonds. A healthy snack rich in healthy fats and protein.','image_url'=>'https://images.unsplash.com/photo-1508061253366-f7da158b6d46?w=400&h=250&fit=crop'],
        ];

        $product_ids = [];
        foreach ($products as $p) {
            $catModel = Category::where('slug', $p['category'])->first();
            $data = [
                'name'                => $p['name'],
                'slug'                => Str::slug($p['name']),
                'description'         => $p['description'],
                'price'               => $p['price'],
                'original_price'      => $p['original_price'],
                'discount_percentage' => $p['discount_percentage'],
                'category'            => $p['category'],
                'category_id'         => $catModel?->_id,
                'stock'               => rand(15, 200),
                'unit'                => 'piece',
                'is_featured'         => rand(0, 1) == 1,
                'is_active'           => true,
                'rating'              => round(rand(35, 50) / 10, 1),
                'reviews_count'       => rand(12, 340),
                'image_url'           => $p['image_url'] ?? null,
                'tags'                => [$p['category'], 'fresh', 'deal'],
            ];

            $product = Product::updateOrCreate(['slug' => $data['slug']], $data);
            $product_ids[] = $product->_id;
        }

        // Update Category product_counts
        foreach (Category::all() as $cat) {
            $cat->update(['product_count' => Product::where('category', $cat->slug)->count()]);
        }

        // ── 4. Seed Deals ──────────────────────────────────────────────
        Deal::truncate();
        Deal::create([
            'title'            => '🍎 Fruit Bonanza Week',
            'description'      => 'Save big on all fresh fruits this week! Stock up on seasonal goodness.',
            'product_ids'      => array_slice($product_ids, 0, 6),
            'discount_percent' => 25,
            'starts_at'        => Carbon::now(),
            'expires_at'       => Carbon::now()->addDays(7),
            'is_active'        => true,
            'banner_color'     => '#ef4444',
        ]);

        Deal::create([
            'title'            => '🥛 Dairy Delights Sale',
            'description'      => 'Exclusive discounts on selected dairy products. Fresh from the farm to your table.',
            'product_ids'      => array_slice($product_ids, 13, 5),
            'discount_percent' => 15,
            'starts_at'        => Carbon::now(),
            'expires_at'       => Carbon::now()->addDays(5),
            'is_active'        => true,
            'banner_color'     => '#3b82f6',
        ]);

        Deal::create([
            'title'            => '🍞 Bakery Flash Sale',
            'description'      => 'Grab your favourite bakery items at incredible prices for the next 24 hours only!',
            'product_ids'      => array_slice($product_ids, 18, 5),
            'discount_percent' => 30,
            'starts_at'        => Carbon::now(),
            'expires_at'       => Carbon::now()->addHours(24),
            'is_active'        => true,
            'banner_color'     => '#f59e0b',
        ]);

        Deal::create([
            'title'            => '🥩 Weekend Meat Fest',
            'description'      => 'Fresh cuts at unbeatable prices every weekend. Limited stock available!',
            'product_ids'      => array_slice($product_ids, 28, 3),
            'discount_percent' => 20,
            'starts_at'        => Carbon::now(),
            'expires_at'       => Carbon::now()->addDays(2),
            'is_active'        => true,
            'banner_color'     => '#dc2626',
        ]);
    }
}
