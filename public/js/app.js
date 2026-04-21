// 3D UI Interactions for Wachemo Dating

// Swipe functionality
function likeUser(userId, type) {
    fetch('index.php?page=match&action=like', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `to_user=${userId}&type=${type}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Animate card out
            const card = document.querySelector(`[data-user="${userId}"]`);
            card.style.transform = type === 'like' ? 'translateX(100%) rotate(30deg)' : 'translateX(-100%) rotate(-30deg)';
            setTimeout(() => card.remove(), 300);
        }
    });
}

// Chat functionality
let currentChatUser = null;

function openChat(userId) {
    currentChatUser = userId;
    document.getElementById('chat-window').style.display = 'flex';
    loadMessages();
    // Polling for new messages
    setInterval(loadMessages, 5000);
}

function loadMessages() {
    if (!currentChatUser) return;
    fetch(`index.php?page=chat&action=conversation&with=${currentChatUser}`)
    .then(response => response.json())
    .then(messages => {
        const container = document.getElementById('messages');
        container.innerHTML = '';
        messages.forEach(msg => {
            const div = document.createElement('div');
            div.textContent = `${msg.from_user_id}: ${msg.message}`;
            container.appendChild(div);
        });
    });
}

function sendMessage() {
    const input = document.getElementById('message-input');
    const message = input.value;
    if (!message || !currentChatUser) return;
    fetch('index.php?page=chat&action=send', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `to=${currentChatUser}&message=${encodeURIComponent(message)}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            input.value = '';
            loadMessages();
        }
    });
}

// Admin functions
function banUser(userId) {
    if (confirm('Ban this user?')) {
        fetch('index.php?page=admin&action=ban', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `user_id=${userId}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) location.reload();
        });
    }
}

function resolveReport(reportId) {
    fetch('index.php?page=admin&action=resolveReport', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `report_id=${reportId}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) location.reload();
    });
}

// 3D Tilt effect for cards
document.addEventListener('DOMContentLoaded', () => {
    const cards = document.querySelectorAll('.card-3d, .profile-card-3d, .match-card-3d');
    cards.forEach(card => {
        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            const rotateX = (y - centerY) / 10;
            const rotateY = (centerX - x) / 10;
            card.style.transform = `rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
        });
        card.addEventListener('mouseleave', () => {
            card.style.transform = '';
        });
    });
});

// Language switch (simple)
function switchLang(lang) {
    document.cookie = `lang=${lang}; path=/`;
    location.reload();
}