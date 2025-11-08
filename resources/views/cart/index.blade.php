<x-layout>
    <section>
        <h2 class="font-integral text-[20px] py-6">Your cart</h2>
        @if (!(count($cart) === 0))
            <div class="flex gap-5">
                <div class="grid gap-6 py-5 px-6 border border-black/10 rounded-[20px] w-[715px]">
                    @foreach ($cart as $key => $cartItem)
                        <div class="cart-item flex justify-between" data-id="{{ $key }}">
                            <div class="flex gap-4">
                                <img src="https://placehold.co/124x124" alt="">
                                <div class="grid items-start justify-items-start">
                                    <h3 class="font-satoshi-bold text-[20px]">{{ $cartItem['title'] }}</h3>
                                    <p class="font-satoshi-bold text-[24px]">${{ $cartItem['price'] }}</p>
                                </div>
                            </div>
                            <div class="w-[225px] grid justify-items-end gap-[56px]">
                                <button class="cart-remove-btn cursor-pointer">
                                    <img class="h-6 w-6" src="{{ asset('icons/trash.svg') }}" alt="">
                                </button>

                                <div
                                    class="flex items-center gap-[20px] w-[126px] h-[44px] px-[20px] py-[12px] bg-[#F0F0F0] rounded-[62px]">
                                    <button class="cart-minus-btn cursor-pointer" type="button" name="button">
                                        <img class="h-5 w-5 block" src="{{ asset('icons/minus.svg') }}"
                                            alt="" />
                                    </button>
                                    <span class="quantity font-satoshi-medium text-[14px]">1</span>
                                    <button class="cart-plus-btn cursor-pointer" type="button" name="button">
                                        <img class="h-5 w-5 block" src="{{ asset('icons/plus.svg') }}" alt="" />
                                    </button>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="py-5 px-6 border border-black/10 rounded-[20px] w-[505px]">
                    <table class="w-full">
                        <thead>
                            <tr>
                                <td class="font-satoshi-bold text-2xl">Order Summary</td>
                            </tr>
                        </thead>
                        <tbody class="order-table border-spacing-[20px]">
                            <tr>
                                <td>Subtotal</td>
                                <td>$XXX</td>
                            </tr>
                            <tr>
                                <td>Discount(-20%)</td>
                                <td class="text-[#FF3333]">-$YYY</td>
                            </tr>
                            <tr>
                                <td>Delivery Fee</td>
                                <td>$ZZZ</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td>Total</td>
                                <td>${{ $total }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        @else
            <div
                class="w-full h-[420px] border border-black/10 rounded-[20px] flex flex-col items-center justify-center">
                <h3 class="font-satoshi-medium text-6xl pb-1.5">Cart is empty </h3>
                <p>If you had items in your cart, <a href="{{ route('login.index') }}">log in</a> to your profile.</p>
            </div>
        @endif
    </section>
</x-layout>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Обработчик для увеличения количества
        document.body.addEventListener('click', function(e) {
            if (e.target.closest('.cart-plus-btn')) {
                const quantityElement = e.target.closest('.cart-item').querySelector('.quantity');
                quantityElement.textContent = parseInt(quantityElement.textContent) + 1;
            }
        });

        // Обработчик для уменьшения количества
        document.body.addEventListener('click', function(e) {
            if (e.target.closest('.cart-minus-btn')) {
                const quantityElement = e.target.closest('.cart-item').querySelector('.quantity');
                const currentValue = parseInt(quantityElement.textContent);
                if (currentValue > 1) {
                    quantityElement.textContent = currentValue - 1;
                }
            }
        });


        document.body.addEventListener('click', async function(e) {
            if (e.target.closest('.cart-remove-btn')) {
                const cartItem = e.target.closest('.cart-item');
                const productId = cartItem.dataset.id;

                try {
                    const response = await fetch(`/cart/${productId}`, {
                        method: "DELETE",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector(
                                'meta[name="csrf-token"]').content,
                            "Accept": "application/json" // ← Добавлено
                        }
                    });

                    // Проверяем статус ответа
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    const data = await response.json();

                    if (data.success) {
                        // Плавно скрываем товар
                        cartItem.style.transition = "opacity 0.3s";
                        cartItem.style.opacity = "0";
                        setTimeout(() => {
                            cartItem.remove();
                            // Обновляем общую сумму и количество
                            updateCartTotals(data);
                        }, 300);
                    } else {
                        console.error("Ошибка при удалении товара:", data.message);
                        alert("Не удалось удалить товар: " + (data.message ||
                        'Неизвестная ошибка'));
                    }
                } catch (error) {
                    console.error("Ошибка запроса:", error);
                    alert("Произошла ошибка при удалении товара");
                }
            }
        });
    });
</script>
