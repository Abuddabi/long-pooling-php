function $(selector) {
    return document.querySelector(selector)
}

function getQueryString(formData){
  var pairs = [];
  for (var [key, value] of formData.entries()) {
    pairs.push(encodeURIComponent(key) + '=' + encodeURIComponent(value));
  }
  return pairs.join('&');
}

function renderMessages(data) {
    $('#messages').innerHTML = ``;
    data.forEach(item => {
        $('#messages').innerHTML += `
        <li class="chat__item chat-item">
            <span class="chat-item__name">${item.name}</span>
            ${item.message}
            <span class="chat-item__time">${item.created_at}</span>
        </li>`;
    })
}

function getMessages() {
    fetch('/ajax.php?get_messages=1')
        .then(res => res.json())
        .then(data => {
            renderMessages(data);
            listenMessages(data.length);
        })
}

function listenMessages(count) {
    fetch(`/ajax.php?rows_count=${count}&listen=1`)
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