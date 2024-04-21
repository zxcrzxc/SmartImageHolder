<x-layout>
<div>

<form action="/create_album" method="post">
    @csrf
    <input type = "hidden" name = "_token" value = "{{csrf_token()}}" />
    <div>
        Title:<input type="text" name="title"><br>
        hashtag:<input type="text" name="hashtag"><br>
        <button>send</button>
    </div>
</form>
<form action="{{ route('albums_main')}}" method="GET"><button>go back to reality</button></form>
</div>
</x-layout>