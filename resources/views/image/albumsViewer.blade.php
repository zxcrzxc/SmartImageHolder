<x-layout>

<div>
    <div class="displayFlexForMainPage">
                @foreach ($albums as $album)
        <div class="displayElementsFlexForMainPage">
            <!--<p>Id: {{$album->id}}</p>-->
            <p>Название: {{$album->name}}</p>
            <p>Описание: {{$album->hashtag}}</p>

            @if ($images[$count])
            <img class="imageView" src="{{ asset('images/'.$images[$count++][0]->name) }}" alt="tag">
            @else
            <img class="imageView" src="{{ asset('images/noimage.jpg') }}" alt="tag">
            @endif
            

            <div class="displayFlexForMainPage">

                <form action="{{route('albums.edit', ['id'=>$album->id])}}" method="GET">
                    <button>Редактировать</button>
                </form>

                <form action="{{ route('albums.destroy', ['id'=>$album->id])}}" method="POST">
                    @csrf
                    @method("DELETE")
                    <button>Удалить</button>
                </form>

                <form action="{{ route('album.show', ['id'=>$album->id])}}" method="GET">
                    <button>Посмотреть</button>
                </form>

            </div>
        </div>
                @endforeach
    </div>
</div>
<form action="{{ route('albums.create')}}" method="GET">       
    <button>Создать альбом</button>
</form>

</x-layout>