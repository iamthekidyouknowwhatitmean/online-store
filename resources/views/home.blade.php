<x-layout>
    Главная страница
    @if (Auth::check())
        <div>
            Привет, пользователь {{ Auth::user()->name }}
        </div>    
    @endif
    
</x-layout>