<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles/login.css">
    <style>
        .login-container form{
            border: var(--border;);
            border: 1px solid black;
            margin: auto; 
            margin-top:100px;
            max-width: 350px;
            padding: 2rem;
        }
        .login-container form h3{
            font-size: 2.5rem;
            color: var(--black);
            margin-bottom: 1rem;
            text-align: center;

        }
        .login-container form .login-box{
            margin: 0.7rem 0;
            border: var(--border;);
            padding: 5px;
            font-size: 1rem;
        }

        /* ---------------------------------- */

        .wrap{
            max-width: 350px;
            margin: auto;
            padding: 2rem;
            background:#fff;
            margin-top:100px;
            border-radius: 20px;
        }
        form{
            margin-top: 20px;
        }
        input {
            width:100%;
            padding: 10px;
            box-sizing: border-box;
            margin-bottom: 5px;
            border: none;
            outline: none;
            border: 1px solid gray;
            font-size: 15px;
            border-radius: 5px;
        }
        h2{
            margin: 0;
            padding: 0;
            font-size: 2em;
            text-align: center;
        }
        input[type=submit]{
            font-size: 1em;
            margin-top: 5px;
            color: #fff;
            background: #1AA7EC;
            font-weight: bold;
            border: 1px solid #fff;
            cursor: pointer;
        }
        input[type=submit]:hover {
            background: #68BB59;
        }
        .open-btn{
            border:none;
            padding: 10px 15px;
            font-size: 20px;
            cursor: pointer;
            float: right;
        }
        .overlay{
            height:100%;
            width: 100%;
            display: none;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background: rgba(0,0,0,0.7)
        }
        .close-btn {
            position:absolute;
            top: 20px;
            right: 45px;
            font-size: 40px;
            cursor: pointer;
            color: #fff;
        }

    </style>
</head>
<body>
    <section class="login-container">
        <form action="" method="post">
            <h3>Login</h3>
            <input type="email" name="email" required placeholder="Enter your email" class="login-box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="pass" required placeholder="Enter your password" class="login-box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
            <a href="">Forgot password ?</a>
            <input type="submit" value="Login now" name="submit" class="btn-submit">
            <p>don't have an account?<a id="sign-up"href="#" onclick="openForm()"> Sign up now</a></p>
        </form>
    </section>

    <div id ="my-overlay" class ="overlay">
        <span class="close-btn" onclick="closeForm()" title="close-overlay">&#215</span>
        <div class="wrap">
            <h2>Sign Up</h2>
            <form>
                <input type="text" placeholder="Enter your Last Name">
                <input type="text" placeholder="Enter your First Name">
                <input type="text" placeholder="Enter your Email">
                <input type="text" placeholder="Enter your Mobile Number">
                <input type="password" placeholder="Enter your Password">
                <input type="password" placeholder="Confirm Password">
                <input type="submit" value="Save">
                <input type="submit" value="Back">   
            </form>
        </div>
    </div>
    <script>
        function openForm(){
            document.getElementById("my-overlay").style.display="block";
        }
    </script>
    <script>
        function closeForm(){
            document.getElementById("my-overlay").style.display="none";
        }
    </script>
</body>
</html>