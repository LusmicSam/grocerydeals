<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Deal Alert</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e0e0e0; border-radius: 5px; }
        .header { background-color: #28a745; color: #fff; padding: 10px 20px; border-radius: 5px 5px 0 0; text-align: center; }
        .content { padding: 20px; }
        .footer { font-size: 12px; text-align: center; color: #777; margin-top: 20px; }
        .price { font-size: 24px; color: #e53935; font-weight: bold; }
        .original-price { text-decoration: line-through; color: #999; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>New Deal Alert: {{ $deal->name }}!</h2>
        </div>
        <div class="content">
            <p>Hello {{ $user->name }},</p>
            <p>We have a great new deal for you!</p>
            
            <h3>{{ $deal->name }}</h3>
            
            @if($deal->image)
                <img src="{{ Storage::url($deal->image) }}" alt="{{ $deal->name }}" style="max-width: 100%; height: auto; margin-bottom: 15px;">
            @endif

            <p>
                <span class="price">${{ number_format($deal->price, 2) }}</span>
                @if($deal->original_price)
                    <span class="original-price">${{ number_format($deal->original_price, 2) }}</span>
                @endif
            </p>
            
            @if($deal->description)
                <p>{{ $deal->description }}</p>
            @endif

            <p>Hurry up and grab it before stock runs out ({{ $deal->stock }} left)!</p>
            
            <p>Click <a href="{{ route('products.show', $deal->_id) }}">here</a> to view the deal.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} GroceryDeals. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
