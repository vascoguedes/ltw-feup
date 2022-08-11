<?php function drawLogin() { ?>

    <section id="login">
        <h1>THE MENU</h1>
        <form>
            <input required name='email' type='email' placeholder='Email' />
            <input required name='password' type='password' placeholder='Password' />
            <error></error>
            <button type='button' id='loginButton'>Log In</button>
            <a href='index.php?page=recoverpass'>Recover password</a>
            <a href='index.php?page=register'>Register</a>
        </form>
    </section>

    <script>
        document.getElementById("loginButton").addEventListener("click", async function() {

            email = document.querySelector('input[type=email]').value;
            password = document.querySelector('input[type=password]').value;
            error = document.querySelector('error');

            if (!email || !password) {
                error.innerHTML = 'Email/password em falta';
            } else if (!String(email).toLowerCase().match(/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/)) {
                error.innerHTML = 'Email inválido';
            } else {
                const response = await fetch('../api/api_login.php?csrf=<?=$_SESSION['csrf']?>&email=' + email + '&password=' + password);
                const answer = await response.json();

                if (answer == 'SUCCESS') {
                    window.location = 'index?page=feed';
                } else {
                    email.innerHTML = '';
                    password.innerHTML = '';
                    if (answer == 'NOT VERIFIED') {
                        error.innerHTML = 'Conta não validada. Confirme a sua caixa de email';
                    } else {
                        error.innerHTML = 'Combinação email/password incorreta';
                    }                    
                }
                                
            }                 
        });
    </script>
<?php } ?>