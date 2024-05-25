<x-layout>
    
<form action="{{route('loginPagePost')}}" method="POST">
    <div class="registrDiv">
        <div class="registrRow">
            <p      class="registrCell">eMail:</p>
            <input  id="eMail" class="registrCell" type="text" name="eMail" required>
        </div>
        <div class="registrRow">
            <p      class="registrCell">Пароль:</p>
            <input  id="telNumber" class="registrCell" type="password" name="password">
        </div>
        <!--
        <div class="registrRow">
            <p      class="registrCell">Номер телефона:</p>
            <input  id="telNumber" class="registrCell" type="tel" name="phone" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" required>
        </div>
        -->
        @csrf
        @method("POST")
        <input type="submit" id="submitLog">
        <!--<p id="demo"></p>-->
    </div>
</form>
</body>
</html>
</x-layout>