<x-layout>
    Личный кабинет
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button>Выйти из профиля</button>
    </form>
</x-layout>