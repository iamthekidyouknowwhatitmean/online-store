<x-layout>
    <div class="w-[300px] border border-black/10 rounded-[20px] px-6 py-5">
        <div class="flex justify-between items-center">
            <x-subtitle>Filters</x-subtitle>
            <img src="{{ asset('icons/filter.svg') }}" alt="">
        </div>
        <hr class="border-0 h-px bg-black/10 my-6">
        {{-- Price тут --}}
        {{-- <div>
            <h3 class="font-satoshi-bold text-xl">Price</h3>
            <div class="relative w-full max-w-md mx-auto">
                <!-- Фоновая линия -->
                <div class="range-track"></div>

                <!-- Заполненная часть между ползунками -->
                <div class="range-progress" id="range-progress"></div>

                <!-- Ползунок минимум -->
                <input type="range" min="0" max="1000" value="200" class="range-slider z-10"
                    id="min-price">

                <!-- Ползунок максимум -->
                <input type="range" min="0" max="1000" value="800" class="range-slider z-20"
                    id="max-price">
            </div>

            <!-- Отображение значений -->
            <div class="range-values">
                <span id="min-value">200</span>
                <span id="max-value">800</span>
            </div>
        </div> --}}
        <div class="">
            <div>
                <div class="flex justify-between items-center cursor-pointer" onclick="toggleFilter(this)">
                    <x-subtitle>Size</x-subtitle>
                    <img class="arrow transform transition-transform duration-300"
                        src="{{ asset('icons/arrow-top.svg') }}" alt="">
                </div>
                <div
                    class="filter-item-content transition-all duration-200 flex flex-wrap gap-2 max-h-0 opacity-0 invisible overflow-hidden">
                    @foreach ($sizes as $size)
                        <div>
                            <input id="size-{{ $size }}" type="radio" name="size" class="sr-only peer">
                            <label for="size-{{ $size }}"
                                class="cursor-pointer px-[20px] bg-[#F0F0F0] rounded-[62px] h-10 flex items-center justify-center text-black/60 text-[14px] peer-checked:bg-black peer-checked:text-white">
                                {{ $size }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
            <hr class="border-0 h-px bg-black/10 my-6">

            <div>
                <div class="flex justify-between items-center cursor-pointer" onclick="toggleFilter(this)">
                    <x-subtitle>Brand</x-subtitle>
                    <img class="arrow transform transition-transform duration-300"
                        src="{{ asset('icons/arrow-top.svg') }}" alt="">
                </div>
                <div class="filter-item-content h-0 overflow-hidden">
                    Content Here!
                </div>
            </div>
            <hr class="border-0 h-px bg-black/10 my-6">

            <div>
                <div class="flex justify-between items-center cursor-pointer" onclick="toggleFilter(this)">
                    <x-subtitle>Category</x-subtitle>
                    <img class="arrow transform transition-transform duration-300"
                        src="{{ asset('icons/arrow-top.svg') }}" alt="">
                </div>
                <div class="filter-item-content h-0 overflow-hidden">
                    Content Here!
                </div>
            </div>
            <hr class="border-0 h-px bg-black/10 my-6">

            <div>
                <div class="flex justify-between items-center cursor-pointer" onclick="toggleFilter(this)">
                    <x-subtitle>Color</x-subtitle>
                    <img class="arrow transform transition-transform duration-300"
                        src="{{ asset('icons/arrow-top.svg') }}" alt="">
                </div>
                <div class="filter-item-content h-0 overflow-hidden">
                    Content Here!
                </div>
            </div>
            <hr class="border-0 h-px bg-black/10 my-6">

            <div>
                <div class="flex justify-between items-center cursor-pointer" onclick="toggleFilter(this)">
                    <x-subtitle>Material</x-subtitle>
                    <img class="arrow transform transition-transform duration-300"
                        src="{{ asset('icons/arrow-top.svg') }}" alt="">
                </div>
                <div class="filter-item-content h-0 overflow-hidden">
                    Content Here!
                </div>
            </div>
            <hr class="border-0 h-px bg-black/10 my-6">

            <div>
                <div class="flex justify-between items-center cursor-pointer" onclick="toggleFilter(this)">
                    <x-subtitle>Gender</x-subtitle>
                    <img class="arrow transform transition-transform duration-300"
                        src="{{ asset('icons/arrow-top.svg') }}" alt="">
                </div>
                <div class="filter-item-content h-0 overflow-hidden">
                    Content Here!
                </div>
            </div>

        </div>
    </div>
    {{-- <!-- Уведомление -->
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
            <img src="{{ $product->thumbnail }}" alt="" width="100px" height="100px">
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

    {{ $products->links() }} --}}
</x-layout>



<script>
    function toggleFilter(element) {
        const content = element.nextElementSibling;
        const arrow = element.querySelector('.arrow');

        // Переключаем высоту контента
        if (content.classList.contains('max-h-0')) {
            content.classList.remove('max-h-0', 'opacity-0', 'invisible', 'overflow-hidden');
            content.classList.add('h-auto', 'opacity-100', 'visible', 'pt-[20px]', 'pb-[24px]');
        } else {
            content.classList.remove('h-auto', 'opacity-100', 'visible', 'pt-[20px]', 'pb-[24px]');
            content.classList.add('max-h-0', 'opacity-0', 'invisible', 'overflow-hidden');
        }

        // Переворачиваем стрелку
        arrow.classList.toggle('rotate-180');
    }


    // const minPrice = document.getElementById('min-price');
    // const maxPrice = document.getElementById('max-price');
    // const minValue = document.getElementById('min-value');
    // const maxValue = document.getElementById('max-value');
    // const rangeProgress = document.getElementById('range-progress');

    // function updateRange() {
    //     const minVal = parseInt(minPrice.value);
    //     const maxVal = parseInt(maxPrice.value);

    //     // Ограничение, чтобы min не превышал max
    //     if (minVal > maxVal) {
    //         minPrice.value = maxVal;
    //         return;
    //     }

    //     // Обновление отображаемых значений
    //     minValue.textContent = minVal;
    //     maxValue.textContent = maxVal;

    //     // Обновление заполненной части
    //     const minPercent = (minVal / parseInt(minPrice.max)) * 100;
    //     const maxPercent = (maxVal / parseInt(maxPrice.max)) * 100;

    //     rangeProgress.style.left = `${minPercent}%`;
    //     rangeProgress.style.width = `${maxPercent - minPercent}%`;
    // }

    // minPrice.addEventListener('input', updateRange);
    // maxPrice.addEventListener('input', updateRange);

    // // Инициализация
    // updateRange();
    // setTimeout(() => {
    //     const flash = document.getElementById('flash-message');
    //     if (flash) flash.style.display = 'none';
    // }, 1500);
</script>
