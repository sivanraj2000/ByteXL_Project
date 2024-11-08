function sendMessage() {
    const userInput = document.getElementById("user-input").value;
    if (!userInput.trim()) return; // Ignore empty messages

    // Display the user message
    appendMessage("user", userInput);

    // Send the message to the PHP server
    fetch("chatbot.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ message: userInput })
    })
    .then(response => response.json())
    .then(data => {
        // Display the bot response
        appendMessage("bot", data.response);
    })
    .catch(error => {
        console.error("Error:", error);
        appendMessage("bot", "Sorry, I couldn't connect to the server.");
    });

    // Clear the input field
    document.getElementById("user-input").value = "";
}

function appendMessage(sender, message) {
    const chatBox = document.getElementById("chat-box");
    const messageDiv = document.createElement("div");
    messageDiv.className = `chat-message ${sender}-message`;
    messageDiv.innerText = message;
    chatBox.appendChild(messageDiv);
    chatBox.scrollTop = chatBox.scrollHeight; // Auto-scroll to the bottom
}
