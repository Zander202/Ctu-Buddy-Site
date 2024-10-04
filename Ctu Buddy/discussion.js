function sendMessage() {
    const username = document.getElementById('username').value;
    const message = document.getElementById('messageInput').value;

    if (username && message) {
        const data = new FormData();
        data.append('username', username);
        data.append('message', message);

        fetch('sendMessage.php', {
            method: 'POST',
            body: data
        })
        .then(response => response.text())
        .then(result => {
            console.log(result);
            loadMessages(); // Reload messages after sending
        })
        .catch(error => {
            console.error('Error:', error);
        });

        document.getElementById('messageInput').value = ''; // Clear input after sending
    } else {
        alert('Please enter a username and message.');
    }
}

function loadMessages() {
    fetch('getMessages.php')
        .then(response => response.json())
        .then(messages => {
            const chatBox = document.getElementById('chat-box');
            chatBox.innerHTML = ''; // Clear the chat box

            messages.forEach(message => {
                const newMessage = document.createElement('div');
                newMessage.textContent = `${message.username}: ${message.message} (${message.timestamp})`;
                chatBox.appendChild(newMessage);
            });
        })
        .catch(error => {
            console.error('Error fetching messages:', error);
        });
}

// Automatically load messages every 3 seconds
setInterval(loadMessages, 3000);