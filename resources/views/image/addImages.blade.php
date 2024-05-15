<x-layout>
<div>

<form action="{{route('albums.addImages', ['id'=>$album->id])}}" method="post" enctype="multipart/form-data">
    
    @csrf
    <input type = "hidden" name = "_token" value = "{{csrf_token()}}" />

    <div>
    <label for="img">Выберите изображения:</label>
    <input type="hidden" name="id" value="{{$album->id}}">
    <input type="file" id="img" name="img[]" multiple accept="image/*">
    <input type="submit">
    </div>
    
</form>
<form action="{{ route('albums_main')}}" method="GET"><button>Назад</button></form>

</div>
</x-layout>