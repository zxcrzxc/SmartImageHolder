
<x-layout>
<div>    
    <p>Name: {{$album->name}}</p>
    <p>HashTag: {{$album->hashtag}}</p> 

    <div>
    @foreach ($img as $im)
    
        <img src="{{ asset('images/'.$im->name) }}" alt="tag" class="imageViewInAlbum">
    
    @endforeach
    </div>
    <div class="displayFlexForMainPage">
        
        <form action="{{route('albums.edit', ['id'=>$album->id])}}" method="GET"><button>Edit</button></form>
        <form action="{{ route('albums_main')}}" method="GET"><button>go back to reality</button></form>
    </div>
</div>
</x-layout>