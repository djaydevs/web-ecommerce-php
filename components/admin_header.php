<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../styles/admin_header.css">
<body>
    <header>
        <nav>
            <div class="logo-container">
                <!-- <img src="logo.png" alt="Logo"> -->
            </div>
            <!-- <ul class="nav-links">
                <li><a href="#">Home</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Contact</a></li>
            </ul> -->
            <div class="account-container">
                <a href="#">Account</a>
            </div>
        </nav>
    </header>

    <script>
        let prevScrollPos = window.pageYOffset;
        const header = document.querySelector('header');

        window.addEventListener('scroll', () => {
            const currentScrollPos = window.pageYOffset;

            if (prevScrollPos > currentScrollPos) {
                header.classList.remove('hidden');
            } else {
                header.classList.add('hidden');
            }
            prevScrollPos = currentScrollPos;
        });
    </script>
</body>
</html>