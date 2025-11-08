<x-layout>
    <section class="">
        <h2 class="text-center">My Wishlist</h2>
        <div class="px-5 pt-4 pb-5 border border-black/10 rounded-[20px]">
            <table class="w-full">
                <thead>
                    <tr class="text-left">
                        <th>Product</th>
                        <th>Price</th>
                        <th>Stock status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($favorites as $favorite)
                        <tr>
                            <td class="flex items-center">
                                <img src="{{ $favorite->thumbnail }}" alt="" width="100px" height="100px">
                                <p>{{ $favorite->title }}</p>
                               
                            </td>
                            <td class="w-[25%]">${{ $favorite->price }}</td>
                            <td class="w-[25%]">In Stock</td>
                            <td class="w-[10%]">
                                <button>Add to Cart</button>
                                X
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

    </section>

</x-layout>
