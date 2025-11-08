<x-layout>
    <!-- Уведомление -->
    @if (session('success'))
        <div id="flash-message" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div id="flash-message" class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @foreach ($products as $product)
        <div class="pb-[20px]">
            <p>{{ $product['title'] }}</p>
            <div class="flex gap-5 items-center">
                <form action="{{ route('cart.store',$product->id) }}" method="POST">
                    @csrf
                    <button class="bg-blue-500 rounded-xl p-1.5 font-bold cursor-pointer">Add To Cart</button>
                </form>
                <form action="{{ route('product.store',$product->id) }}" method="POST">
                    @csrf
                    <button class="cursor-pointer">Like</button>
                </form>
            </div>

        </div>
    @endforeach

    {{ $products->links() }}
</x-layout>



<script>
    setTimeout(() => {
        const flash = document.getElementById('flash-message');
        if (flash) flash.style.display = 'none';
    }, 1500);
</script>
