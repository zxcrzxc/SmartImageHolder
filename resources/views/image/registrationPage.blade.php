<x-layout>

<form action="{{route('registrationPagePost')}}" method="POST">
    <div class="registrDiv">
        <div class="registrRow">
            <p      class="registrCell">eMail:</p>
            <input  id="eMail" class="registrCell" type="email" name="eMail"required>
        </div>
        <div class="registrRow">
            <p      class="registrCell">Имя:</p>
            <input  id="fName" class="registrCell" type="text" name="fname" required>
        </div>
        <div class="registrRow">
            <p      class="registrCell">Фамилия:</p>
            <input  id="sName" class="registrCell" type="text" name="sname" required>
        </div>
        <div class="registrRow">
            <p      class="registrCell">Отчество:</p>
            <input  id="tName" class="registrCell" type="text" name="tname">
        </div>
        <div class="registrRow">
            <p      class="registrCell">Дата рождения:</p>
            <input  id="DateOfBirth" class="registrCell" type="date" name="birthdate" required>
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
        <input type="submit" id="submitReg">
        <!--<p id="demo"></p>-->
    </div>
</form>
</body>
</html>
</x-layout>