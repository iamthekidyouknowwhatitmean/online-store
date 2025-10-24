<x-layout>
    @foreach ($news as $item)
        <a href="/news/details/{{ $item->id }}">{{ $item->id }}{{ $item->title }}</a>
        
    @endforeach
</x-layout>