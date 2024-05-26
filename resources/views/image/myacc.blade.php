<x-layout>
    <div>
        <p>ФИО: {{$dataFromDB->fname}} {{$dataFromDB->sname}} {{$dataFromDB->tname}}</p>
        <p>Дата рождения: {{$bdate}}</p>
        <!--    
        <p>Дата создания аккаунта: {{$dataFromDB->created_at}}</p>
        -->
        <div class="displayFlexForMainPage">
            <form action="{{route('changeMyAcc')}}" method="GET"><button>Изменить данные</button></form>
            <form action="{{route('my_albums')}}" method="GET"><button>Мои альбомы</button></form>
            <form action="{{route('albums.create')}}" method="GET"><button>Создать альбомы</button></form>
        </div>
    </div>       
</div>
</body>
</html>
</x-layout>