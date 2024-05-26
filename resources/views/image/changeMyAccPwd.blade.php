<x-layout>
    <div class="posit">
    <h2>Изменение</h2>
    <form action="{{route('changeMyAccPwdPost')}}" method="POST">
        @method('PUT')
        @csrf 
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <div class="registrDiv">
            
            <div class="registrRow">
                <p      class="registrCell">Пароль:</p>
                <input  id="telNumber" class="registrCell" type="password" name="password">
            </div>
            <input type="submit" id="submitReg">
        </div>
    </form>
    
</x-layout>