<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <!-- Уведомление -->
    @if(session('success'))
        <div id="flash-message" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div id="flash-message" class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @foreach ($products as $product)
        <p>{{ $product['name'] }}</p>
        <form action="/cart/{{ $product['id'] }}" method="POST">
            @csrf
            <button>Add To Cart</button>
        </form>
    @endforeach
</body>
</html>

<script>
    setTimeout(() => {
        const flash = document.getElementById('flash-message');
        if (flash) flash.style.display = 'none';
    }, 1500);
</script>
