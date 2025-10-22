<x-layout>
    @if (\Session::has('emailExist'))
        {{ Session::get('emailExist') }}
    @endif
    @session('emailExist')
        {{ $value }}    
    @endsession

    <form action="{{ route('register.store') }}" method="POST">
        @csrf
        <div>
            <label>Имя</label>
            <input type="text" name="name">
            @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label>Почта</label>
            <input type="email" name="email">
            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label>Пароль</label>
            <input type="password" name="password">
            @error('password')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label>Подтверждение пароля</label>
            <input type="password" name="password_confirmation">
            @error('password_confirmation')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        
        
        <button type="submit">Регистрация</button>
    </form>
</x-layout>