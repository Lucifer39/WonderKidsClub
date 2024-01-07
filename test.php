<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WebSocket Chat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        #chat-box {
            border: 1px solid #ccc;
            padding: 10px;
            max-height: 300px;
            overflow-y: scroll;
        }

        #inputMessage {
            width: 70%;
            padding: 5px;
        }

        #roomInput {
            margin-bottom: 10px;
            padding: 5px;
        }

        #sendButton {
            padding: 5px;
        }
    </style>
</head>
<body>
    <div>
        <h2>WebSocket Chat</h2>
        <input type="text" id="roomInput" placeholder="Enter room name">
        <button onclick="connectToWebSocket()">Connect to WebSocket</button>
        <div id="chat-box"></div>
        <input type="text" id="inputMessage" placeholder="Type a message">
        <button id="sendButton" onclick="sendMessage()">Send</button>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        var roomName;
        var socket;

        function connectToWebSocket() {
            roomName = $('#roomInput').val();
            if (roomName.trim() !== '') {
                // WebSocket connection with room name
                socket = new WebSocket('ws://localhost:8080?room=' + roomName);

                // Connection opened
                socket.addEventListener('open', function (event) {
                    console.log('WebSocket connection opened:', event);
                });

                // Listen for messages
                socket.addEventListener('message', function (event) {
                    var message = event.data;
                    console.log('Received message:', message);

                    // Display the received message in the chat box
                    $('#chat-box').append('<p>' + message + '</p>');
                });

                // Connection closed
                socket.addEventListener('close', function (event) {
                    console.log('WebSocket connection closed:', event);
                });

                // Handle errors
                socket.addEventListener('error', function (event) {
                    console.error('WebSocket error:', event);
                });

                // Enable UI elements
                $('#inputMessage').prop('disabled', false);
                $('#sendButton').prop('disabled', false);
            } else {
                alert('Please enter a room name.');
            }
        }

        // Send a message to the server
        function sendMessage() {
            var message = $('#inputMessage').val();
            if (message.trim() !== '') {
                socket.send(message);
                $('#inputMessage').val('');
            }
        }
    </script>
</body>
</html>
