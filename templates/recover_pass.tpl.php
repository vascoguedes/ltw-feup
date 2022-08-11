<?php function drawRecoverPass() { ?>

    <section id="recoverpass">
        <h1>THE MENU</h1>
        <form>
            <input required name='email' type='email' pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$" placeholder='Email' />
            <error></error>
            <button id='recoverPassButton' type="button">Send email</button>
            <a href='index.php?page=login'>Login</a>
        </form>
    </section>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@3/dist/email.min.js"></script>
    <script>
        document.getElementById("recoverPassButton").addEventListener("click", async function() {

            email = document.querySelector('input').value;
            error = document.querySelector('error');

            if (email) {
                const response = await fetch('../api/api_getusertoken.php?csrf=<?=$_SESSION['csrf']?>&email=' + email);
                const token = await response.json();

                if (token != 'NULL') {
                    emailjs.init("zbTqTeI80_Kye7si9");
                    emailjs.send("service_1nn0vga","template_ac5bv4f", {email: email, token: token});
                    error.innerHTML = '(Confirma a tua caixa de spam)';
                } else {
                    error.innerHTML = 'Email não atribuído';
                }
            } else {
                error.innerHTML = 'Introduz um email';
            }            
        });
    </script>
<?php } ?>