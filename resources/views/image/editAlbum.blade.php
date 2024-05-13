<x-layout>
    <h2>Изменение</h2>
    <form action="{{route('albums.update', ['id'=>$album->id])}}" method="POST">
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
    <div class="displayFlexForMainPage">
    @foreach ($img as $im)
        <div>
            <div>{{$im->name}}</div>
            <img src="{{ asset('images/'.$im->name) }}" alt="tag" class="imageViewInAlbum">
            <form action="{{route('albums.deleteImage', ['name'=>$im->name])}}" method="POST">
                @csrf
                @method("POST")
                <button>Удалить</button>
            </form>
        </div>
    @endforeach
</div>
    <form action="{{route('albums.addImages', ['id'=>$album->id])}}" method="get">
        <button>Добавить изображения</button>
    </form>
    <!--
        <form action="{{ route('albums_main')}}" method="GET"><button>go back to reality</button></form>
    -->
</x-layout>