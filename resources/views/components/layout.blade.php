<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tactical Pro - Online Shop</title>
    @vite('resources/css/app.css')
</head>
<body>
    <header>
        <div class="flex justify-between">
            <ul class="flex gap-3">
                <li><a href="/">Главная</a></li>
                <li><a href="{{ route('news.index') }}">Новости</a></li>
                <li><a href="{{ route('products.index') }}">Товары</a></li> 
            </ul>  
            <ul class="flex gap-3">
                <li><a href="#">Личный кабинет</a></li>
                <li><a href="{{ route('cart.index') }}">Корзина</a></li>
            </ul>
        </div>    
    </header>
    
        
    <div class="container">
        {{ $slot }}
    </div>
</body>
</html>