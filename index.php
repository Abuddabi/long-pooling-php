<?php

function out($arg, $method = 1) {
    echo "<pre>";
    if ($method === 1) var_dump($arg);
    else print_r($arg);
    exit();
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Polling</title>
</head>
<body>

<style>
    html, body {
        min-height: 100vh;
        margin: 0;
        padding: 0;
        font-family: 'Arial', sans-serif;
    }
    .container {
        height: 100vh;
        max-width: 1200px;
        margin: 0 auto;
        outline: 1px solid #000;
        padding: 0 40px;

        display: flex;
        flex-direction: column;
    }
    #messages {
        flex: 1 1 auto;
    }
    .form {
        margin-bottom: 150px;
    }
    .form__input {
        display: block;
        width: 280px;
        padding: 8px 10px;

        font-size: 15px;
        line-height: 120%;
    }
    .form__input + .form__input {
        margin-top: 15px;
    }
    .form__submit {
        margin-top: 15px;
    }
    .form__input_text {
        resize: none;
        height: 80px;
        font-family: 'Arial', sans-serif;
    }
    .chat {
        padding: 20px 0;
    }
    .chat__item {
        list-style: none;
        font-size: 21px;
        font-weight: normal;
    }
    .chat-item__name {
        font-size: 12px;
        font-weight: bold;
    }
    .chat-item__time {
        font-size: 12px;
    }
    .form__error {
        color: red;
        font-size: 14px;
        line-height: 100%;
        font-weight: bold;
        height: 14px;
        margin-top: 10px;
    }
</style>

<div class="container">
    <ul id="messages" class="chat">

    </ul>
    <form action="" class="form" method="POST" data-username="">
        <input type="text" class="form__input form__input_name" name="name" placeholder="Имя">
        <textarea class="form__input form__input_text" name="message" placeholder="Текст сообщения"></textarea>
        <button class="form__submit" type="submit" >Отправить</button>
        <p class="form__error"></p>
    </form>
</div>

<script src="/main.js"></script>
<script>
    getMessages();

    var form = $('.form');
    form.addEventListener('submit', function(event){
        event.preventDefault();

        var errors = false;
        var form_error = $('.form__error');
        var username = form.getAttribute('data-username');
        if (!username.length) {
            var input_name = $('.form__input[name="name"]');
            var name_val = input_name.value;
            if (!name_val.length) {
                errors = true;
                form_error.textContent = 'Пожалуйста, заполните имя';
            }
            else {
                form.setAttribute('data-username', name_val);
                // input_name.value = '';
                input_name.remove();
            }
        }

        var message_val = $('.form__input[name="message"]').value;
        if (!message_val.length) {
            errors = true;
            form_error.textContent = 'Пожалуйста, заполните текст сообщения';
        }

        if (!errors) {
            // var data = new FormData(form);
            // var request = new XMLHttpRequest();
            // request.open('POST', '/ajax.php?send=1');
            // request.send(data);
            var username_val = username.length ? username : name_val;
            var queryString = `message=${message_val}&name=${username_val}`;

            fetch('/ajax.php?send=1&'+queryString)
                .then(res => res.json())
                .then(data => {
                    if (data.status == "error") console.log(data.errorText)
                    else {
                        form.reset();
                    }
                })
        }
        
    });
</script>
</body>
</html>