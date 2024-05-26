<x-layout>
<div>
    <div class="create">
    <form action="/create_album" method="post">
        @csrf
        <input type = "hidden" name = "_token" value = "{{csrf_token()}}" />
        
            Название:<input type="text" name="title"><br>
            Описание:<textarea type="text" name="desc"></textarea>
            Хештеги: <textarea type="text" name="hashtag" ></textarea>
            <button>Готово</button>
    </form>
        <form action="{{ route('albums_main')}}" method="GET"><button>Назад</button></form>
        </div>
</div>
</x-layout>