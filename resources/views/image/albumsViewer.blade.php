<x-layout>

<div>
    <div class="displayFlexForMainPage">
                @foreach ($albums as $album)
        <div class="displayElementsFlexForMainPage">
            <p>Id: {{$album->id}}</p>
            <p>Name: {{$album->name}}</p>
            <p>HashTag: {{$album->hashtag}}</p>
            <div class="displayFlexForMainPage">

                <form action="{{route('albums.edit', ['id'=>$album->id])}}" method="GET">
                    <button>Edit</button>
                </form>

                <form action="{{ route('albums.destroy', ['id'=>$album->id])}}" method="POST">
                    @csrf
                    @method("DELETE")
                    <button>Delete</button>
                </form>

                <form action="{{ route('album.show', ['id'=>$album->id])}}" method="GET">
                    <button>Show</button>
                </form>

            </div>
        </div>
                @endforeach
    </div>
</div>
<form action="{{ route('albums.create')}}" method="GET">       
    <button>create album</button>
</form>

</x-layout>