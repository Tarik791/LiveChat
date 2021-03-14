<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script
      src="https://kit.fontawesome.com/64d58efce2.js"
      crossorigin="anonymous"
    ></script>
    <link rel="stylesheet" href="css/signup.css">
    <title>My Chat</title>
</head>

<body>
<div id="wrapper">
    <div id="forms-container">

    
    <!--Error message-->
    <div id="error" style="">gwagagw</div>
    <div class="signin-signup">
        <form id="myform" class="sign-in-form">
            <div class="input-field">
              <i class="fas fa-user"></i>
            <input type="text" name="username" placeholder="Username" ><br>
            </div>
            <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="text" name="email" placeholder="Email" ><br>
            </div>
            <div style="padding:10px;">
            <br>Gender:<br>
            <input type="radio" value="Male" name="gender_male"> Male<br>
            <input type="radio" value="Female" name="gender_female"> Female<br>
            </div>
            <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" placeholder="Password" ><br>
            </div>
            <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" name="password2" placeholder="Retype Password" ><br>
            </div>
            <input type="button" class="btn" value="Sign up" id="signup_button"><br>

            <a href="login.php"  style="display:block; text-align:center; text-decoration:none;">
                Already have an Account? Login here!
            </a>
            <div class="social-media">
              <a href="#" class="social-icon">
                <i class="fab fa-facebook-f"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-twitter"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-google"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-linkedin-in"></i>
              </a>
            </div>
        </form>
        </div>
    </div>
</div>
<div class="panels-container">
        <div class="panel left-panel">
          <div class="content">
            <h3>New here ?</h3>
            <p>
              Lorem ipsum, dolor sit amet consectetur adipisicing elit. Debitis,
              ex ratione. Aliquid!
            </p>
            <button class="btn transparent" id="sign-up-btn">
              Sign up
            </button>
          </div>
          <img src="img/log.svg" class="image" alt="" />
        </div>
    </div>
</div>
</body>
</html>
<script src="js/signup.js"></script>