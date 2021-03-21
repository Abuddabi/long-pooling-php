function $(selector) {
    return document.querySelector(selector)
}

function renderMessages(data) {
    $('#messages').innerHTML = ``;
    data.forEach(item => {
        $('#messages').innerHTML += `<li>${item.message} <b>${item.created_at}</b></li>`
    })
}

function getMessages() {
    fetch('/get.php')
        .then(res => res.json())
        .then(data => {
            renderMessages(data);
            listenMessages(data.length);
        })
}

function listenMessages(count) {
    fetch(`/listen.php?rows_count=${count}`)
        .then(res => res.json())
        .then(data => {
            if (data.status) {
                renderMessages(data.messages)
                listenMessages(data.messages.length)
            } else {
                listenMessages(count)
            }
        })
}

getMessages()