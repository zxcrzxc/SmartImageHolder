<x-layout>
    <h2>Изменение</h2>
    <form action="{{route('albums.update', ['id'=>$album->id])}}" method="post">
        @method('PUT')
        @csrf 
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <br>
        <div>
            Name: <input type="text" name="name" id="" value="{{ $album->name }}">
        </div>
        <br>
        <div> 
            Hashtag: <textarea type="text" name="hashtag" id="">{{ $album->hashtag }}</textarea>
        </div>
        <br>
        <button>Готово</button>
    </form>
    <form action="{{route('albums.addImages', ['id'=>$album->id])}}" method="get">
        <button>Добавить изображиния</button>
    </form>
    <form action="{{ route('albums_main')}}" method="GET"><button>go back to reality</button></form>
</x-layout>