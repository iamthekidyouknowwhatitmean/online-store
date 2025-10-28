<x-layout>
    <table>
        <thead><tr><th>Product</th><th>Qty</th><th>Price</th><th>Total</th><th></th></tr></thead>
        <tbody>
            <tr>
                @foreach ($cart as $id => $value)
                    <td>{{ $value['name'] }}</td>
                    <td>
                        <form action="/cart/{{ $id }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="number" name="quantity" value="{{ $value['quantity'] }}" min="1" />
                            <button>Update</button>
                        </form>
                    </td>
                    <td>{{ $value['price'] }}</td>
                    <td>{{ $value['quantity']*$value['price'] }}</td>
                    <td>
                        <form action="/cart/{{ $id }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button>Delete</button>
                        </form>    
                    </td>                    
                    
                @endforeach    
            </tr>
        </tbody>
    </table>
    {{-- @dd($products); --}}
    

    <div>
        <p>Итоговая сумма = {{ $sum }}</p>
    </div>

</x-layout>
    
