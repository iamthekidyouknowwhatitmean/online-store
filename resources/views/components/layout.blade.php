<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Tactical Pro - Online Shop</title>
    @vite('resources/css/app.css')
</head>
<body class="text-black font-satoshi-regular">
    <main class="max-w-[1240px] mx-auto">
       <header class="flex items-center gap-[40px] pt-[24px]">
            <a href="/"><h1 class="font-integral text-[22px]">Tactical pro</h1></a>
            <nav>
                <ul class="flex gap-[24px]">
                    <li><a href="{{ route('products.index') }}">Shop</a></li>
                    <li><a href="#" class="text-gray-500">On Sale</a></li>
                    <li><a href="#" class="text-gray-500">New Arrivals</a></li>
                    <li><a href="{{ route('news.index') }}">News</a></li>
                </ul>
            </nav>
            <div class="search-wrapper">
                <x-input placeholder="Search for products..."/> 
            </div>
            
            <div class="flex gap-3.5">
                <a href="{{ route('cart.index') }}">
                    <img src="{{ asset('icons/cart.svg') }}" alt="" class="w-[24px] h-[24px]">
                </a>
                <a href="{{ route('favorites') }}">
                    <img src="{{ asset('icons/heart.svg') }}" alt="" class="w-[24px] h-[24px]">
                </a> 
                <a href="{{ route('login.index') }}">
                    <img src="{{ asset('icons/profile.svg') }}" alt="" class="w-[24px] h-[24px]">
                </a>
                
            </div>
        
        </header>
    
        <div class="container">
            {{ $slot }}
        </div> 
    </main>
    
</body>
</html>