

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

  <!-- https://kodevfusion.com/NTDC/ -->
 <style>
    /*@import url('https://fonts.googleapis.com/css2?family=Lobster&display=swap');*/
/* +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
/* Style for the thinking bubble message */

.thinking-bubble {
            position: fixed;
            bottom: 120px; /* Added margin from the bottom */
            right: 20px;
            background: #f0f0f0;
            border-radius: 15px;
            padding: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 300px;
            font-size: 14px;
            color: #333;
            z-index: 1000;
            display: none; /* Hidden by default */
        }

        .thinking-bubble::after {
            content: "";
            position: absolute;
            bottom: -10px; /* Adjusted to align vertically centered with bubble */
            right: 5%; /* Position the arrow to the right of the bubble */
            width: 0;
            height: 0;
            border-left: 10px solid transparent;
            border-right: 10px solid transparent;
            border-top: 10px solid #f0f0f0; /* Arrow color matches the bubble */
        }

* {
    margin: 0;
    padding: 0;
    /* font-size: 11px; */
    box-sizing: border-box;
    /* overflow: hidden; */
}
body {
    background: none;
}


/* +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
        
#chat-container{
                  display: none; /* Initially hide the chat section */
                  position: fixed;
                  bottom: 90px;
                  right: 20px;
                  width: 370px;
                  height: 440px; /* Reduced height */
                  border: 2px solid #e30613;
                  background-color: white;
                  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                  border-radius: 10px;
                  overflow: hidden;
                  z-index: 111111111111111111111000;
              }

              .rounded-btn {
                  border-radius: 50%;
                  width:50px;
                  height:50px;
                  position: fixed;
                  bottom: 33px;
                  right: 20px;
                  background-color:/* #0084ff */ #e30613;
                  color: #fff;
                  display: flex;
                  align-items: center;
                  justify-content: center;
                  box-shadow: 0 -2px 16px rgba(0, 0, 0, 0.06), 0 4px 16px rgba(0, 0, 0, 0.06), 2px 1px 32px rgba(0, 0, 0, 0.06);
                  cursor: pointer;
                  transition: transform 0.3s;
                  z-index: 1001;
              }
          .rounded-btn:hover {
              transform: scale(1.1);
          }

              #chat2 .card-body {
                  position: relative;
                  height: 340px; /* Adjusted height */
                  overflow-x: auto;
              }
              #chat2 .card-footer {
                  margin-top: -25px; /* Adjusted margin to fit in reduced height */
              }
              .card-header{
                color: #fff;
                background-color: #e30613;
                border: 2px solid #e30613;
                margin-top: -1px;
                margin-left: -2px;
                margin-right: -2px;

              }
              .card-header h5{
                font-weight: bold;
              }
/* +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
        
        /* Scrollbar overall container */
::-webkit-scrollbar {
    width: 7px; /* Scrollbar ki width set karein */
}

/* Scrollbar track */
::-webkit-scrollbar-track {
    background: #f1f1f1; /* Track ki background color set karein */
    border-radius: 10px; /* Track ko rounded look dene ke liye */
}

/* Scrollbar thumb */
::-webkit-scrollbar-thumb {
    background-color: #e30613; /* Scrollbar ki thumb ki color set karein */
    border-radius: 10px; /* Thumb ko rounded look dene ke liye */
    border: 2px solid #e30613; /* Thumb ke ird gird space set karein */
}

/* Scrollbar thumb on hover */
::-webkit-scrollbar-thumb:hover {
    background-color: #e30613; /* Hover par thumb ka color change ho jaye */
}

.form-control:focus {
            box-shadow: 0 0 5px #e30613; /* Change color as needed */
            border-color: #e30613; /* Change border color when focused */
        }
 </style>

<style>
.loader-dots {
  display: inline-flex;
  gap: 4px;
  height: 18px;
  align-items: center;
  justify-content: center;
}

.loader-dots span {
  width: 7px;
  height: 7px;
  background-color: #aaa;
  border-radius: 50%;
  animation: loaderBounce 1.2s infinite ease-in-out;
}

.loader-dots span:nth-child(2) {
  animation-delay: 0.2s;
}
.loader-dots span:nth-child(3) {
  animation-delay: 0.4s;
}

@keyframes loaderBounce {
  0%, 80%, 100% {
    transform: scale(0);
  }
  40% {
    transform: scale(1);
  }
}


.fade-in-char {
  opacity: 0;
  animation: fadeInChar 0.3s ease forwards;
  display: inline;
  word-break: break-word;
  white-space: pre-wrap;
}


@keyframes fadeInChar {
  from { opacity: 0; transform: translateY(2px); }
  to { opacity: 1; transform: translateY(0); }
}

</style>

<!-- ------------------------------------Chat-section------------------------------------------ -->
   
   
<div id="chat-container">
            <div class="card rounded-chat" id="chat2">
                <div class="card-header d-flex justify-content-between align-items-center p-3"
                style="
                 color: #fff;
                        background-color: #e30613;
                        border: 2px solid #e30613;
                        margin-top: -3px;
                        margin-left: -2px;
                        margin-right: -2px;

                ">
                    <h5 class="mb-0" style="color: white">Chat</h5>
                </div>
                <div class="card-body" data-mdb-perfect-scrollbar-init id="chat-box">
                    <!-- Existing chat messages -->
                            </div>
                <div class="card-footer text-muted d-flex justify-content-start align-items-center p-2" style="z-index:1;">
                    <input type="text" class="form-control form-control-lg" id="user-input" placeholder="Type message" style="font-size:12px;">
                    <button id="send-btn" style="margin-right:7px; font-size: 12px; background-color: #e30613; padding:8px 6px; margin-top: 4px !important;" class="btn btn-sm btn-danger ms-1 m-1">Send</button>
                    <!-- <a class="ms-1 text-muted m-1" href="#!"><i class="fas fa-paperclip"></i></a>
                    <a class="ms-3 text-muted m-1" href="#!"><i class="fas fa-smile"></i></a> -->
                </div>
            </div>
        </div>

        <div class="rounded-btn" id="floatingChatBtn">
            <i class="fas fa-comments"></i>
        </div>
        <div class="thinking-bubble" id="thinkingBubble">
            Welcome to the Salim Habib University chat Bot! Click me to experience our chat bot.
        </div>
        <script>

window.addEventListener('DOMContentLoaded', function () {
    const timestamp = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

    // Directly queue welcome messages
    queueBotMessage("Welcome to Salim Habib University!", timestamp);
    queueBotMessage("Please provide your cell number so I can look up your account.", timestamp);

    // Optionally update PHP session stage to awaiting_email_phone
    fetch('callcenter/notify_operator.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ auto_start: true }) // let PHP update session
    });
});


            function handleReload() {
                    const isPageReloaded = localStorage.getItem('isPageReloaded');

                    if (isPageReloaded) {
                        // Reset the flag
                        localStorage.removeItem('isPageReloaded');
                    } else {
                        // Set the flag for the next reload
                        localStorage.setItem('isPageReloaded', 'true');

                        // Handle normal reload
                        fetch('callcenter/destroy_session.php', {
                            method: 'POST'
                        });
                    }
                }

                // Call handleReload on page load
                window.onload = function() {
                    handleReload();
                };

                // Ensure the flag is not set on page navigation
                window.onbeforeunload = function() {
                    localStorage.removeItem('isPageReloaded');
                };
            // window.onload = function() {
            //     var perfEntries = performance.getEntriesByType("navigation");
            //     if (perfEntries[0].type === "reload") {
            //         // Agar page reload kiya gaya hai
            //         fetch('callcenter/destroy_session.php', {
            //             method: 'POST'
            //         });
            //     }
            // };



            document.addEventListener('DOMContentLoaded', (event) => {
                setTimeout(() => {
                        var thinkingBubble = document.getElementById('thinkingBubble');
                        thinkingBubble.style.display = 'block';

                        // Hide the thinking bubble after 5 seconds
                        setTimeout(() => {
                            thinkingBubble.style.display = 'none';
                        }, 10000);
                    }, 3000);
                loadMessagesFromLocalStorage();
                setInterval(fetchMessagesFromServer, 3000); // Fetch new messages every 5 seconds
            });

            document.getElementById('floatingChatBtn').addEventListener('click', function() {
                var chatSection = document.getElementById('chat-container');
                var floatingChatBtn = document.getElementById('floatingChatBtn');
                if (chatSection.style.display === 'none' || chatSection.style.display === '') {
                    chatSection.style.display = 'block';
                    floatingChatBtn.innerHTML = '<i class="fas fa-times"></i>';
                } else {
                    chatSection.style.display = 'none';
                    floatingChatBtn.innerHTML = '<i class="fas fa-comments"></i>';
                }
            });

            document.getElementById('send-btn').addEventListener('click', sendMessage);

            document.getElementById('user-input').addEventListener('keydown', function(event) {
                if (event.key === 'Enter') {
                    sendMessage();
                }
            });

            function saveMessageToLocalStorage(message, sender) {
                let chatHistory = JSON.parse(localStorage.getItem('chatHistory')) || [];
                chatHistory.push({ message, sender, timestamp: new Date().toISOString() });
                localStorage.setItem('chatHistory', JSON.stringify(chatHistory));
            }
            function loadMessagesFromLocalStorage() {
                let chatHistory = JSON.parse(localStorage.getItem('chatHistory')) || [];
                let oneDayAgo = new Date();
                oneDayAgo.setDate(oneDayAgo.getDate() - 0);

                chatHistory = chatHistory.filter(msg => new Date(msg.timestamp) > oneDayAgo);

                localStorage.setItem('chatHistory', JSON.stringify(chatHistory)); // Update localStorage after removing old messages

                chatHistory.forEach(msg => {
                    displayMessage(msg.message, msg.sender, new Date(msg.timestamp).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }));
                });
            }



            // function displayMessage(message, sender, timestamp) {
            //     var chatBox = document.getElementById('chat-box');
            //     var newMessageDiv = document.createElement('div');
            //     newMessageDiv.classList.add('d-flex', 'flex-row', sender === 'user' ? 'justify-content-end' : 'justify-content-start', 'mb-2', 'pt-1', 'chat-message');
            //     newMessageDiv.innerHTML = `
            //         <div>
            //             <p class=" p-2 ${sender === 'user' ? 'me-3 text-white bg-danger' : 'ms-3 bg-light'} mb-1 rounded-3" style="border-radius:5px;font-size:13px;">${message}</p>

            //         </div>
            //     `;
            //     // <p class="small ${sender === 'user' ? 'me-3' : 'ms-3'} mb-2 rounded-3 text-muted">${timestamp}</p> message time stamp
            //     chatBox.appendChild(newMessageDiv);
            //     chatBox.scrollTop = chatBox.scrollHeight;
            // }
function displayMessage(message, sender, timestamp) {
    const chatBox = document.getElementById('chat-box');
    const newMessageDiv = document.createElement('div');
    newMessageDiv.classList.add(
        'd-flex',
        'flex-row',
        sender === 'user' ? 'justify-content-end' : 'justify-content-start',
        'mb-2',
        'pt-1',
        'chat-message'
    );

    const messageBubble = document.createElement('p');
    messageBubble.className = `small p-2 ${sender === 'user' ? 'me-3 bg-danger text-white user' : 'ms-3 reply'} mb-1`;
    messageBubble.style.borderRadius = '20px';
    messageBubble.style.position = 'relative';
    messageBubble.style.backgroundColor = '#f0f0f0';
    messageBubble.innerHTML = ''; // InnerHTML needed for styled output

    const msgWrapper = document.createElement('div');
    msgWrapper.className = 'msg';
    msgWrapper.appendChild(messageBubble);
    newMessageDiv.appendChild(msgWrapper);
    chatBox.appendChild(newMessageDiv);
    chatBox.scrollTop = chatBox.scrollHeight;

    if (sender === 'bot') {
        message = message.replace(/<br\s*\/?>/gi, '\n'); // convert <br> to \n

        let index = 0;
        const typingSpeed = 20;

        const typeInterval = setInterval(() => {
            if (index < message.length) {
                const char = message.charAt(index);
                const span = document.createElement('span');

if (char === '\n') {
    messageBubble.appendChild(document.createElement('br'));
} else {
    const span = document.createElement('span');
    span.textContent = char;
    span.classList.add('fade-in-char');
    messageBubble.appendChild(span);
}
                index++;
                chatBox.scrollTop = chatBox.scrollHeight;
            } else {
                clearInterval(typeInterval);
            }
        }, typingSpeed);
    } else {
        messageBubble.textContent = message;
    }
}

let botMessageQueue = [];
let isProcessingBotMessage = false;
function queueBotMessage(message, timestamp) {
    botMessageQueue.push({ message, timestamp });
    if (!isProcessingBotMessage) {
        processNextBotMessage();
    }
}
function processNextBotMessage() {
    if (botMessageQueue.length === 0) {
        isProcessingBotMessage = false;
        return;
    }

    isProcessingBotMessage = true;
    const { message, timestamp } = botMessageQueue.shift();
    const chatBox = document.getElementById('chat-box');

    // Create loader
    const loaderDiv = document.createElement('div');
    loaderDiv.classList.add('d-flex', 'flex-row', 'justify-content-start', 'mb-2', 'pt-1', 'chat-message');
    loaderDiv.innerHTML = `
        <div class='msg'>
            <p class="small p-2 ms-3 reply mb-1" style="border-radius: 20px; position: relative; display: flex; align-items: center; justify-content: center; min-height: 24px; min-width: 40px; background-color: #f0f0f0;">
    <span class="loader-dots">
        <span></span><span></span><span></span>
    </span>
</p>

        </div>
    `;
    loaderDiv.setAttribute('data-waiting-update', message ? 'false' : 'true');
    loaderDiv.setAttribute('data-timestamp', timestamp);

    chatBox.appendChild(loaderDiv);
    chatBox.scrollTop = chatBox.scrollHeight;

    // After 3s
    setTimeout(() => {
        if (message && message.trim() !== '') {
            loaderDiv.remove();
            displayMessage(message, 'bot', timestamp);
            saveMessageToLocalStorage(message, 'bot');
        }
        // If null, keep loader
        processNextBotMessage();
    }, 1000);
}
function updatePendingLoaderWithMessage(message, timestamp) {
    const loaders = document.querySelectorAll('[data-waiting-update="true"]');
    loaders.forEach(loader => {
        if (loader.getAttribute('data-timestamp') === timestamp) {
            loader.remove();
            displayMessage(message, 'bot', timestamp);
            saveMessageToLocalStorage(message, 'bot');
        }
    });
}



function sendMessage() {
    var messageInput = document.getElementById('user-input');
    var message = messageInput.value.trim();
    if (message !== '') {
        displayMessage(message, 'user', new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }));
        saveMessageToLocalStorage(message, 'user');

        messageInput.value = ''; // Clear input after sending message

        // Send user input to the server
        
        fetch('callcenter/notify_operator.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json'
    },
    body: JSON.stringify({ message: message })
})
.then(response => {
    return response.text(); // Change to text to capture full response (HTML or JSON)
})
.then(data => {
    console.log('Raw Response:', data);
    try {
        var jsonData = JSON.parse(data);
        console.log('Operator Response:', jsonData);

        const timestamp = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

        if (jsonData.answer && Array.isArray(jsonData.answer)) {
            jsonData.answer.forEach(answer => {
                queueBotMessage(answer, timestamp);
            });
        } else if (jsonData.answer === 'pdf' && jsonData.pdf_url) {
            window.location.href = jsonData.pdf_url;
        } else if (jsonData.answer) {
            queueBotMessage(jsonData.answer, timestamp);
        } else {
            // Response null hai – loader show karein
            // queueBotMessage(null, timestamp);

            // Simulate late response (optional: replace with actual fetch)
            // setTimeout(() => {
            //     // updatePendingLoaderWithMessage("Sorry for the delay, here’s your answer.", timestamp);
            // }, 2000);
        }
    } catch (error) {
        console.error('JSON Parsing Error:', error);
    }
})

.catch(error => {
    console.error('Error:', error);
});

    }
}


            let lastMessageTimestamp = null;

            function fetchMessagesFromServer() {
                fetch('api/get_messages.php', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Fetched Messages:', data); // Debugging line to log the fetched messages
                    data.messages.forEach(msg => {
                        // Only display and save new messages
                        if (!lastMessageTimestamp || new Date(msg.timestamp) > new Date(lastMessageTimestamp)) {
                            displayMessage(msg.message, msg.sender, new Date(msg.timestamp).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }));
                            saveMessageToLocalStorage(msg.message, msg.sender);
                            lastMessageTimestamp = msg.timestamp; // Update the timestamp of the last message
                        }
                    });
                })
                .catch(error => {
                    console.error('Error fetching messages:', error);
                });
                fetchAIMessagesFromServer(); // Fetch AI messages

            }


            function fetchAIMessagesFromServer() {
                fetch('api/get_ai_messages.php', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Fetched AI Messages:', data);
                    data.messages.forEach(msg => {
                        if (!lastMessageTimestamp || new Date(msg.timestamp) > new Date(lastMessageTimestamp)) {
                            displayMessage(msg.message, msg.sender, new Date(msg.timestamp).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }));
                            saveMessageToLocalStorage(msg.message, msg.sender);
                            lastMessageTimestamp = msg.timestamp; // Update the timestamp of the last message
                        }
                    });
                })
                .catch(error => {
                    console.error('Error fetching AI messages:', error);
                });
            }
                </script>
