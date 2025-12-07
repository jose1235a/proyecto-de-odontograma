class ChatManager {
    constructor(userId, receiverId) {
        this.userId = userId;
        this.receiverId = receiverId;
        this.ws = null;
        this.messagesContainer = document.getElementById('chat-messages');
        this.messageInput = document.getElementById('message-input');
        this.sendButton = document.getElementById('send-button');
        this.isConnected = false;

        this.init();
    }

    init() {
        this.bindEvents();
        this.scrollToBottom();
        // Use WebSocket for real-time communication
        this.connectWebSocket();
    }

    connectWebSocket() {
        try {
            this.ws = new WebSocket('ws://localhost:8080');

            this.ws.onopen = (event) => {
                this.isConnected = true;
                this.registerUser();
                // Load initial messages
                this.loadInitialMessages();
            };

            this.ws.onmessage = (event) => {
                const data = JSON.parse(event.data);
                if (data.type === 'message') {
                    this.handleIncomingMessage(data);
                } else if (data.type === 'user_status') {
                    this.handleUserStatusUpdate(data);
                } else if (data.type === 'online_users_list') {
                    this.handleOnlineUsersList(data);
                }
            };

            this.ws.onclose = (event) => {
                this.isConnected = false;
                // Attempt to reconnect after 5 seconds
                setTimeout(() => this.connectWebSocket(), 5000);
            };

            this.ws.onerror = (error) => {
                this.isConnected = false;
                alert('Error de conexión WebSocket. Verifica que el servidor esté ejecutándose.');
            };
        } catch (error) {
            alert('Error: No se pudo conectar al servidor WebSocket. Verifica que esté ejecutándose.');
        }
    }

    registerUser() {
        if (this.ws && this.isConnected) {
            const registerMessage = {
                type: 'register',
                user_id: this.userId
            };
            this.ws.send(JSON.stringify(registerMessage));
        }
    }

    loadInitialMessages() {
        fetch(window.routes.getMessages)
        .then(response => response.json())
        .then(data => {
            this.messagesContainer.innerHTML = '';
            data.forEach((message) => {
                this.appendMessage(message, message.sender_id == this.userId);
            });
            this.scrollToBottom();
        })
        .catch(error => {
            // Error loading initial messages - could add user notification
        });
    }

    bindEvents() {
        if (this.sendButton) {
            this.sendButton.addEventListener('click', () => {
                this.sendMessage();
            });
        }

        if (this.messageInput) {
            this.messageInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    this.sendMessage();
                }
            });
        }
    }

    sendMessage() {
        if (!this.messageInput) {
            return;
        }

        const message = this.messageInput.value.trim();

        if (message === '') {
            return;
        }

        if (this.isConnected && this.ws) {
            // Send via WebSocket only
            this.ws.send(JSON.stringify({
                type: 'message',
                sender_id: this.userId,
                receiver_id: this.receiverId,
                message: message
            }));
            this.messageInput.value = '';
        } else {
            alert('Error: No hay conexión WebSocket. Verifica que el servidor esté ejecutándose.');
        }
    }


    handleIncomingMessage(data) {
        // Only show messages between current user and receiver
        if ((data.sender_id == this.userId && data.receiver_id == this.receiverId) ||
            (data.sender_id == this.receiverId && data.receiver_id == this.userId)) {
            // Create message object for appendMessage
            const message = {
                sender: { name: data.sender_id == this.userId ? 'Tú' : 'Usuario' },
                message: data.message,
                created_at: new Date().toISOString()
            };
            this.appendMessage(message, data.sender_id == this.userId);
            this.scrollToBottom();
        }
    }

    handleUserStatusUpdate(data) {
        // Update user status in the user list (index page)
        const userElements = document.querySelectorAll(`[data-user-id="${data.user_id}"]`);

        userElements.forEach((element) => {
            const statusElement = element.querySelector('.user-status');
            if (statusElement) {
                const newStatus = data.status === 'online' ? 'ACTIVO' : 'DESCONECTADO';
                statusElement.textContent = newStatus;
                statusElement.className = `user-status status-${data.status}`;
            }
        });

        // Update chat header status if it's the user we're chatting with
        if (data.user_id == this.receiverId) {
            const chatHeader = document.querySelector('.card-title');
            if (chatHeader) {
                const statusText = data.status === 'online' ? 'ACTIVO' : 'DESCONECTADO';
                const statusClass = data.status === 'online' ? 'text-success' : 'text-danger';

                // Remove existing status indicator
                const existingStatus = chatHeader.querySelector('.user-status-header');
                if (existingStatus) {
                    existingStatus.remove();
                }

                // Add new status indicator
                const statusSpan = document.createElement('span');
                statusSpan.className = `user-status-header ${statusClass}`;
                statusSpan.innerHTML = ` <small>(${statusText})</small>`;
                chatHeader.appendChild(statusSpan);
            }
        }
    }

    handleOnlineUsersList(data) {
        // Update all user statuses based on the online users list
        const allUserElements = document.querySelectorAll('[data-user-id]');

        allUserElements.forEach(element => {
            const userId = parseInt(element.getAttribute('data-user-id'));
            const statusElement = element.querySelector('.user-status');

            if (statusElement) {
                const isOnline = data.online_users.includes(userId);
                const newStatus = isOnline ? 'ACTIVO' : 'DESCONECTADO';

                statusElement.textContent = newStatus;
                statusElement.className = `user-status status-${isOnline ? 'online' : 'offline'}`;
            }
        });
    }

    appendMessage(message, isSent) {
        const messageClass = isSent ? 'sent' : 'received';
        const senderName = isSent ? 'Tú' : (message.sender ? message.sender.name : 'Usuario');
        const time = message.created_at ? new Date(message.created_at).toLocaleTimeString() : new Date().toLocaleTimeString();

        const messageHtml = `
            <div class="message ${messageClass}">
                <strong>${senderName}:</strong> ${message.message}
                <small class="text-muted">${time}</small>
            </div>
        `;

        this.messagesContainer.insertAdjacentHTML('beforeend', messageHtml);
    }

    scrollToBottom() {
        this.messagesContainer.scrollTop = this.messagesContainer.scrollHeight;
    }

}

// Initialize when document is ready
document.addEventListener('DOMContentLoaded', function() {
    if (typeof window.chatConfig !== 'undefined') {
        if (window.chatConfig.isIndexPage) {
            initializeStatusOnly();
        } else {
            new ChatManager(
                window.chatConfig.userId,
                window.chatConfig.receiverId
            );
        }
    }
});

// Status-only initialization for index page
function initializeStatusOnly() {
    const ws = new WebSocket('ws://localhost:8080');

    ws.onopen = (event) => {
        // Register current user for status updates
        ws.send(JSON.stringify({
            type: 'register',
            user_id: window.chatConfig.userId
        }));
    };

    ws.onmessage = (event) => {
        const data = JSON.parse(event.data);
        if (data.type === 'user_status') {
            updateUserStatus(data);
        } else if (data.type === 'online_users_list') {
            updateAllUserStatuses(data);
        }
    };

    ws.onclose = (event) => {
        setTimeout(() => initializeStatusOnly(), 5000);
    };

    ws.onerror = (error) => {
        // WebSocket error occurred
    };

    function updateUserStatus(data) {
        const userElements = document.querySelectorAll(`[data-user-id="${data.user_id}"]`);

        userElements.forEach((element) => {
            const statusElement = element.querySelector('.user-status');
            if (statusElement) {
                const newStatus = data.status === 'online' ? 'ACTIVO' : 'DESCONECTADO';
                statusElement.textContent = newStatus;
                statusElement.className = `user-status status-${data.status}`;
            }
        });
    }

    function updateAllUserStatuses(data) {
        const allUserElements = document.querySelectorAll('[data-user-id]');

        allUserElements.forEach(element => {
            const userId = parseInt(element.getAttribute('data-user-id'));
            const statusElement = element.querySelector('.user-status');

            if (statusElement) {
                const isOnline = data.online_users.includes(userId);
                const newStatus = isOnline ? 'ACTIVO' : 'DESCONECTADO';

                statusElement.textContent = newStatus;
                statusElement.className = `user-status status-${isOnline ? 'online' : 'offline'}`;
            }
        });
    }
}