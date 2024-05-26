<x-layout>
    <div class="posit">
        
    <div class="registrDiv">
    <h2>Изменение</h2>
        <form action="{{route('changeMyAccPost')}}" method="POST">
            @method('PUT')
            @csrf 
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="registrRow">
                    <p      class="registrCell">Имя:</p>
                    <input  id="fName" class="registrCell" type="text" name="fname" required value="{{$dataFromDB->fname}}">
                </div>
                <div class="registrRow">
                    <p      class="registrCell">Фамилия:</p>
                    <input  id="sName" class="registrCell" type="text" name="sname" required value="{{$dataFromDB->sname}}">
                </div>
                <div class="registrRow">
                    <p      class="registrCell">Отчество:</p>
                    <input  id="tName" class="registrCell" type="text" name="tname" value="{{$dataFromDB->tname}}">
                </div>
                <div class="registrRow">
                    <p      class="registrCell">Дата рождения:</p>
                    <input  id="DateOfBirth" class="registrCell" type="date" name="birthdate" required value="{{$dataFromDB->birth_date}}">
                </div>
                <input type="submit" id="submitReg">
        </form>
    
        <form action="{{route('changeMyAccPwd')}}" method="GET"><button>Изменить пароль</button></form>
        </div>
</x-layout>