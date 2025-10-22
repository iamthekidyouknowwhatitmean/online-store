<x-layout>
    Страница авторизации

    <form action="{{ route('login.authenticate') }}" method="POST">
        
        @csrf
        @session('msg')
            {{ $value }}
        @endsession

        <div>
            <label>Почта</label>
            <input type="email" name="email">
        </div>
        <div>
            <label>Пароль</label>
            <input type="password" name="password">
        </div>
        <button type="submit">Войти</button>
    </form>
</x-layout>