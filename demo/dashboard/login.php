<?php
session_start();
if(isset($_SESSION['user']))
{
header("location:index.php");
}
else
{
?>
<!DOCTYPE html>
<html>
<head>
	<title>Slide Navbar</title>
	<link rel="stylesheet" type="text/css" href="slide navbar style.css">
<link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
<style>
    body{
	margin: 0;
	padding: 0;
    margin-right:10%;
	display: flex;
	justify-content:end;
	align-items: center;
	min-height: 100vh;
	font-family: 'Jost', sans-serif;
	/* background: linear-gradient(to bottom, #0f0c29, #302b63, #24243e); */
    background-color: whitesmoke;
}
.main{
	width: 350px;
	height: 500px;
	background: red;
	overflow: hidden;
	background: url("https://doc-08-2c-docs.googleusercontent.com/docs/securesc/68c90smiglihng9534mvqmq1946dmis5/fo0picsp1nhiucmc0l25s29respgpr4j/1631524275000/03522360960922298374/03522360960922298374/1Sx0jhdpEpnNIydS4rnN4kHSJtU1EyWka?e=view&authuser=0&nonce=gcrocepgbb17m&user=03522360960922298374&hash=tfhgbs86ka6divo3llbvp93mg4csvb38") no-repeat center/ cover;
	border-radius: 10px;
	box-shadow: 5px 20px 50px #000;
}
#chk{
	display: none;
}
.signup{
	position: relative;
	/* display: block; */
	width:100%;
	height: 100%;
}
label{
	color:black;
	font-size: 2.3em;
	justify-content: center;
	display: flex;
	margin: 60px;
	font-weight: bold;
	cursor: pointer;
	transition: .5s ease-in-out;
}
input{
	width: 60%;
	height: 20px;
	background: #e0dede;
	justify-content: center;
	display: flex;
	margin: 20px auto;
	padding: 10px;
	border: none;
	outline: none;
	border-radius: 5px;
}
.button1{
	width: 60%;
	height: 40px;
	margin: 10px auto;
	justify-content: center;
	display: block;
	color: #fff;
	background: blue;
	font-size: 1em;
	font-weight: bold;
	margin-top: 20px;
	outline: none;
	border: none;
	border-radius: 5px;
	transition: .2s ease-in;
	cursor: pointer;
}
.button2{
	width: 60%;
	height: 40px;
	margin: 10px auto;
	justify-content: center;
	display: block;
	color:black;
	background:white;
	font-size: 1em;
	font-weight: bold;
	margin-top: 20px;
	outline: none;
	border: none;
	border-radius: 5px;
	transition: .2s ease-in;
	cursor: pointer;
}
.button1:hover{
	background:grey;
}
.button2:hover{
	background:grey;
}
.login{
	height: 460px;
	background:blue;
	border-radius: 60% / 10%;
	transform: translateY(-180px);
	transition: .8s ease-in-out;
}
.login label{
	color:white;
	transform: scale(.6);
}

#chk ~ .login{
	transform: translateY(-500px);
}
#chk:checked ~ .login label{
	transform: scale(1);
}
#chk:checked ~ .signup label{
	transform: scale(.6);
}
.login-left-div-img{
    width:380px;
    height:85%;
    /* padding-left:30px; */
    margin-right:270px;
    /* filter: hue-rotate(90deg); */
}


</style>
</head>
<body>
    <div class="col-lg-7 col-md-8 col-sm-12 login-left-div">
                 <img class="login-left-div-img" src="assets/images/logo.png" alt="Image">
            </div>
	<div class="main">
		<input type="checkbox" id="chk" aria-hidden="true">

			<div class="signup">
				<form action="signup_process.php" method="POST">
					<label for="chk" aria-hidden="true" style="font-size: 20px;">KODEV GLOBAL</label>
					<input type="text"  name="first_name" placeholder="User name" required="">
					<input type="email" name="email" placeholder="Email" required="">
					<input type="password" name="password" placeholder="Password" required="">
					<button class="button1" type="submit" name="signup" value="Sign up" >Sign up</button>
				</form>
			</div>

			<div class="login">
            <?php
                        if(isset($_SESSION['msg'])){
                            echo '<br><span id="msg" class="alert alert-danger" style="position: absolute;right: 1px;">'.$_SESSION['msg'].'</span>';
                            unset($_SESSION["msg"]);?>
                        <script>
                            $(document).ready(function(){
                                setTimeout(function() {
                                    $('#msg').hide(5000);
                                }, 2000);
                            });
                        </script>
                        <?php
                        }
                    ?>
				<form action="login_process.php" method="POST">
					<label for="chk" aria-hidden="true">Login</label>
					<input type="email" id="formEmailField"  name="email" name="email" placeholder="Email" required/>
					<input type="password"  id="formPasswordField" name="password" placeholder="Password" required/>
					<button class="button2" type="submit" name="login" value="Login">Login</button>
				</form>
			</div>
	</div>
</body>
</html>
<?php
}
?>
