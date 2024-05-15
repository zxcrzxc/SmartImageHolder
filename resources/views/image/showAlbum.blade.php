
<x-layout>
<div>    
    <p>Название: {{$album->name}}</p>
    <p>Описание: {{$album->hashtag}}</p> 

    <div>
    @foreach ($img as $im)
    
        
        <img src="{{ asset('images/'.$im->name) }}" alt="tag" class="imageViewInAlbum">
    
    @endforeach
    </div>
    <div class="displayFlexForMainPage">
        
        <form action="{{route('albums.edit', ['id'=>$album->id])}}" method="GET"><button>Изменить</button></form>
        <form action="{{ route('albums_main')}}" method="GET"><button>Назад</button></form>
    </div>
</div>
</x-layout>