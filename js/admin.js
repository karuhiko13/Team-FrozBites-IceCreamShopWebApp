document.addEventListener('DOMContentLoaded', function() {
        const userBtn = document.querySelector('#user-btn');
        if (userBtn) {
            userBtn.addEventListener('click', function() {
                const userBox = document.querySelector('.profile-detail');
                if (userBox) {
                    userBox.classList.toggle('active');
                }
            });
        }

        const toggle = document.querySelector('.toggle-btn');
        if (toggle) {
            toggle.addEventListener('click', function() {
                const sidebar = document.querySelector('.sidebar');
                if (sidebar) {
                    sidebar.classList.toggle('active');
                }
            });
        }
    });
