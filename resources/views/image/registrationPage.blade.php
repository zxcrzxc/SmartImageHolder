<x-layout>

<div class="registrDiv">
        <div class="registrRow">
            <p      class="registrCell">eMail:</p>
            <input  id="eMail" class="registrCell" type="text" required>
        </div>
        <div class="registrRow">
            <p      class="registrCell">Имя:</p>
            <input  id="fName" class="registrCell" type="text" required>
        </div>
        <div class="registrRow">
            <p      class="registrCell">Фамилия:</p>
            <input  id="sName" class="registrCell" type="text" required>
        </div>
        <div class="registrRow">
            <p      class="registrCell">Отчество:</p>
            <input  id="tName" class="registrCell" type="text" required>
        </div>
        <div class="registrRow">
            <p      class="registrCell">Дата рождения:</p>
            <input  id="DateOfBirth" class="registrCell" type="date" required>
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
        <input type="submit" id="submitReg">
        <!--<p id="demo"></p>-->
    </div>
</body>
</html>
</x-layout>