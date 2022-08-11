<?php function drawRegisterOne() { ?>

    <section id="register">
        <h1>THE MENU</h1>
        <form>
            <input name='Username' placeholder='Username' />
            <input name='Email' placeholder='Email' />
            <input type='password' name='Password' placeholder='Password' />
            <input type='password' name='ConfirmPassword' placeholder='Confirm password' />
            <input name='Address' placeholder='Adress' />
            <input name='Phone_number' type='number' placeholder='Phone Number' />
            <input type='date' name='Birthdate' />
            <error></error>
            <button id='registerButton' type="button">Register</button>
            <a href='index.php?page=login'>Login</a>
        </form>
    </section>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@3/dist/email.min.js"></script>
    <script>
        document.getElementById("registerButton").addEventListener("click", async function() {

            username = document.querySelector('input[name=Username]').value;
            email = document.querySelector('input[name=Email]').value;
            password = document.querySelector('input[name=Password]').value;
            confirmPassword = document.querySelector('input[name=ConfirmPassword]').value;
            address = document.querySelector('input[name=Address]').value;
            phone_number = document.querySelector('input[name=Phone_number]').value;
            birthdate = document.querySelector('input[name=Birthdate]').value;
            error = document.querySelector('error');
            error.innerHTML = '';

            if (!username || !email || !password || !confirmPassword || !address || !phone_number || !birthdate) {
                error.innerHTML = 'Elementos em falta';
            } else if (!String(email).toLowerCase().match(/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/)) {
                error.innerHTML = 'Email inválido';
            } else if (password != confirmPassword) {
                error.innerHTML = 'Passwords não correspondem';
            } else if (phone_number.length != 9) {
                error.innerHTML = 'Número de telemóvel inválido';
            } else if (new Date() < new Date(birthdate)) {
                error.innerHTML = 'Introduz uma data de nascimento válida';
            } else {

                const response = await fetch('../api/api_register.php?csrf=<?=$_SESSION['csrf']?>&Username=' + username + '&Password=' + password + '&Email=' + email + '&Address=' + address + '&Phone_number=' + phone_number + '&Birthdate=' + birthdate);
                const answer = await response.json();

                if (answer == 'SUCCESS') {
                    const response = await fetch('../api/api_getusertoken.php?csrf=<?=$_SESSION['csrf']?>&email=' + email);
                    const token = await response.json();
                    if (token != 'NULL') {
                        emailjs.init("zbTqTeI80_Kye7si9");
                        emailjs.send("service_1nn0vga","template_5eowcf6", {email: email, token: token});
                        error.innerHTML = 'Verifica a tua caixa de correio para validares a tua conta (Confirma a tua caixa de spam)';
                    } else {
                        error.innerHTML = 'Erro inesperado, tente mais tarde';
                    }                    
                }
                else {
                    error.innerHTML = answer;
                }                    
            }                 
        });
    </script>
<?php } ?>