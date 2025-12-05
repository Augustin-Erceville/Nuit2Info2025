<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot - Nuit de l'Info</title>
    <link rel="stylesheet" href="../style/css/styleChatBot.css">
</head>
<body>
<!-- Header avec logo -->
<header class="main-header">
    <div class="header-content">
        <div class="logo">
            <span class="moon-icon">🌙</span>
            <h1>NUIT DE L'INFO</h1>
        </div>
        <nav class="header-nav">
            <a href="/Nuit2Info2025/index.php" class="nav-link">Accueil</a>
            <a href="#" class="nav-link active">Chatbot</a>
        </nav>
    </div>
</header>

<!-- Conteneur principal -->
<main class="main-container">
    <!-- Particules d'arrière-plan -->
    <div class="particles">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>

    <!-- Container du chat -->
    <div class="chat-container">
        <!-- En-tête du chat -->
        <div class="chat-header">
            <div class="chat-header-content">
                <div class="bot-avatar">🤖</div>
                <div class="bot-info">
                    <h2>Assistant a la pointe de la téchnologie</h2>
                    <span class="bot-status">
                            <span class="status-dot"></span>
                            En ligne
                        </span>
                </div>
            </div>
        </div>

        <!-- Zone des messages -->
        <div class="chat-messages" id="chatMessages">
            <div class="welcome-message">
                <div class="welcome-icon">👋</div>
                <h3>Bienvenue sur le Chatbot de la Nuit de l'Info !</h3>
                <p>Posez-moi n'importe quelle question et je vous répondrai... de manière totalement aléatoire et absurde ! 🎲</p>
            </div>
        </div>

        <!-- Indicateur de saisie -->
        <div class="typing-indicator" id="typingIndicator">
            <div class="typing-dots">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <span class="typing-text">Le bot réfléchit...</span>
        </div>

        <!-- Zone de saisie -->
        <div class="chat-input-container">
            <div class="input-wrapper">
                <input
                    type="text"
                    id="messageInput"
                    placeholder="Écrivez votre message..."
                    autocomplete="off"
                >
                <button id="sendButton" class="send-button">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M22 2L11 13M22 2L15 22L11 13M22 2L2 9L11 13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</main>

<script>
    const chatMessages = document.getElementById('chatMessages');
    const messageInput = document.getElementById('messageInput');
    const sendButton = document.getElementById('sendButton');
    const typingIndicator = document.getElementById('typingIndicator');

    function addMessage(text, isUser) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${isUser ? 'user' : 'bot'}`;

        const bubbleDiv = document.createElement('div');
        bubbleDiv.className = 'message-bubble';

        if (!isUser) {
            const avatarDiv = document.createElement('div');
            avatarDiv.className = 'message-avatar';
            avatarDiv.textContent = '🤖';
            messageDiv.appendChild(avatarDiv);
        }

        bubbleDiv.textContent = text;
        messageDiv.appendChild(bubbleDiv);

        chatMessages.appendChild(messageDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function showTypingIndicator() {
        typingIndicator.style.display = 'flex';
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function hideTypingIndicator() {
        typingIndicator.style.display = 'none';
    }

    async function sendMessage() {
        const message = messageInput.value.trim();

        if (message === '') return;

        addMessage(message, true);
        messageInput.value = '';

        showTypingIndicator();

        try {
            const response = await fetch('/Nuit2Info2025/src/treatment/treatmentChat/treatmentChatBot.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'message=' + encodeURIComponent(message)
            });

            if (!response.ok) {
                throw new Error('HTTP error! status: ' + response.status);
            }

            const data = await response.json();

            setTimeout(() => {
                hideTypingIndicator();
                addMessage(data.response, false);
            }, 800);

        } catch (error) {
            console.error('Erreur complète:', error);
            hideTypingIndicator();
            addMessage('Erreur de connexion au serveur: ' + error.message, false);
        }
    }

    sendButton.addEventListener('click', sendMessage);

    messageInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            sendMessage();
        }
    });

    // Animation du focus sur l'input
    messageInput.addEventListener('focus', () => {
        document.querySelector('.input-wrapper').classList.add('focused');
    });

    messageInput.addEventListener('blur', () => {
        document.querySelector('.input-wrapper').classList.remove('focused');
    });
</script>
</body>
</html>