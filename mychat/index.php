<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Chat</title>
    <link rel="stylesheet" href="css/index.css">
</head>

<body>
    <div id="wrapper">
        
        <div id="left_pannel">

            <div id="user_pannel" style="padding:10px;">    
                <img id="profile_image" src="ui/images/user_male.jpg" alt="" style="height:100px; width:100px;">
                <br>
                <span id="username">Username</span>
                <br>
                <span id="email" style="font-size:12px; opacity: 0.5;">email@gmail.com</span>

                <br>
                <br>
                <br>
                <div>
                    <label id="label_chats" for="radio_chat">Chat <img  src="ui/icons/chat.png" alt="">
                    </label>
                   
                    <label id="label_contacts" for="radio_contacts">Contacts <img  src="ui/icons/contacts.png" alt="">
                    </label>
                   
                    <label id="label_settings" for="radio_settings">Settings <img  src="ui/icons/settings.png" alt="">
                    </label>

                    <label id="logout" for="radio_logout">Logout <img  src="ui/icons/logoutt.png" alt="">
                    </label>
                </div>
            </div>

        </div>
        <div id="right_pannel">
            <div id="header">
             <!--Gif animation loader--->
             <div id="loader_holder" class="loader_on"><img style="width:70px;"  src="ui/icons/giphy.gif" alt=""></div>

                <div id="image_viewer" class="image_off" onclick="close_image(event)"></div>
            My Chat
            </div>

            <div id="container" style="display:flex;">
           
                    <div id="inner_left_pannel">
                        
                    </div>
 
                    <input type="radio" name="myradio" id="radio_chat" style="display: none;">
                    <input type="radio" name="myradio" id="radio_contacts" style="display: none;">
                    <input type="radio" name="myradio" id="radio_settings" style="display: none;">    

                
                <div id="inner_right_pannel">
                
                
                </div>

            </div>
        </div>

    </div>
</body>
</html>


<script src="js/index.js"></script>

