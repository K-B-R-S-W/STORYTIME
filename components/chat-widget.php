<?php
// Chat widget component
?>
<div id="chat-widget" class="chat-widget">
    <button id="chat-toggle" class="chat-toggle">
        <img src="assets/images/pngwing.com-2-616x516.png" alt="Chat" class="chat-icon">
        <span class="close-icon" style="display: none;">×</span>
    </button>
    <div id="chat-container" class="chat-container" style="display: none;">
        <div class="chat-header">
            <h3>StoryTime AI</h3>
        </div>
        <div id="messages" class="messages"></div>
        <div id="input-container" class="input-container">
            <input type="text" id="user-input" placeholder="Ask about movies, bookings, or seats...">
            <button onclick="sendMessage()">Send</button>
        </div>
    </div>
</div>

<style>
.chat-widget {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 1000;
    font-family: Arial, sans-serif;
}

.chat-toggle {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: transparent;
    border: none;
    cursor: pointer;
    padding: 0;
    overflow: visible;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

.chat-toggle img.chat-icon {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 50%;
    position: relative;
    z-index: 2;
    transition: all 0.5s ease;
    box-shadow: 0 0 10px rgba(46, 204, 113, 0.2);
}

.chat-toggle:hover img.chat-icon {
    box-shadow: 0 0 20px #2ecc71,
               0 0 35px #2ecc71,
               0 0 50px #2ecc71;
}

.chat-toggle::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    border-radius: 50%;
    z-index: 1;
    transition: all 0.5s ease;
    background: rgba(46, 204, 113, 0.1);
    opacity: 0;
}

.chat-toggle:hover::after {
    opacity: 1;
    background: rgba(46, 204, 113, 0.2);
}

.close-icon {
    position: absolute;
    font-size: 24px;
    color: white;
}

.chat-container {
    position: absolute;
    bottom: 80px;
    right: 0;
    width: 350px;
    height: 500px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.15);
    display: flex;
    flex-direction: column;
}

.chat-header {
    padding: 15px;
    background: #2c3e50;
    color: white;
    border-radius: 12px 12px 0 0;
    display: flex;
    align-items: center;
}

.chat-header h3 {
    margin: 0;
    font-size: 16px;
}

.messages {
    flex-grow: 1;
    padding: 15px;
    overflow-y: auto;
    background: #f8f9fa;
}

.message {
    margin-bottom: 10px;
    padding: 8px 12px;
    border-radius: 15px;
    max-width: 80%;
    word-wrap: break-word;
}

.user-message {
    background: #007bff;
    color: white;
    margin-left: auto;
    border-radius: 15px 15px 0 15px;
}

.assistant-message {
    background: #e9ecef;
    color: #212529;
    margin-right: auto;
    border-radius: 15px 15px 15px 0;
}

.error-message {
    background: #ffebee;
    color: #c62828;
    margin-right: auto;
    border-radius: 15px 15px 15px 0;
}

.input-container {
    padding: 15px;
    border-top: 1px solid #dee2e6;
    display: flex;
    gap: 10px;
}

#user-input {
    flex-grow: 1;
    padding: 8px 12px;
    border: 1px solid #ced4da;
    border-radius: 20px;
    outline: none;
}

#user-input:focus {
    border-color: #80bdff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
}

.input-container button {
    padding: 8px 16px;
    background: #007bff;
    color: white;
    border: none;
    border-radius: 20px;
    cursor: pointer;
    transition: background-color 0.2s;
}

.input-container button:hover {
    background: #0056b3;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatToggle = document.getElementById('chat-toggle');
    const chatContainer = document.getElementById('chat-container');
    const chatIcon = document.querySelector('.chat-icon');
    const closeIcon = document.querySelector('.close-icon');

    chatToggle.addEventListener('click', function() {
        const isVisible = chatContainer.style.display === 'flex';
        chatContainer.style.display = isVisible ? 'none' : 'flex';
        chatIcon.style.display = isVisible ? 'inline' : 'none';
        closeIcon.style.display = isVisible ? 'none' : 'inline';
    });
});

// Get the backend URL based on the current environment
const BACKEND_URL = window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1'
    ? 'http://localhost:8000'
    : `http://${window.location.hostname}:8000`;

async function sendMessage() {
    const input = document.getElementById('user-input');
    const message = input.value.trim();
    if (!message) return;

    // Display user message
    displayMessage('You: ' + message, 'user-message');
    input.value = '';

    try {
        const response = await fetch(`${BACKEND_URL}/chat`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ message: message })
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        
        // Handle different response formats
        if (data.type === 'steps') {
            const steps = data.content.map((step, index) => 
                `${index + 1}. ${step}`
            ).join('\n');
            displayMessage('Assistant:\n' + steps, 'assistant-message');
        } else {
            displayMessage('Assistant: ' + data.content, 'assistant-message');
        }
    } catch (error) {
        console.error('Error:', error);
        displayMessage('Error: Unable to connect to the assistant. Please make sure the AI backend server is running.', 'error-message');
    }
}

function displayMessage(message, className) {
    const messagesDiv = document.getElementById('messages');
    const messageElement = document.createElement('div');
    messageElement.className = 'message ' + className;
    messageElement.innerText = message;
    messagesDiv.appendChild(messageElement);
    messagesDiv.scrollTop = messagesDiv.scrollHeight;
}

// Allow sending message with Enter key
document.getElementById('user-input').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        sendMessage();
    }
});
</script>