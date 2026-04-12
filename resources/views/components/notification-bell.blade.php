<!-- Dropdown Notifications dans la navigation -->
@auth
    <div class="relative" id="notificationDropdown">
        <button 
            type="button"
            id="notificationBell"
            class="relative inline-flex items-center text-gray-600 hover:text-gray-900 transition-colors"
            title="Notifications"
        >
            <i class="fas fa-bell text-xl"></i>
            <span 
                id="notificationBadge"
                class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full hidden"
            >
                0
            </span>
        </button>

        <!-- Dropdown Panel -->
        <div 
            id="notificationPanel"
            class="absolute right-0 mt-2 w-96 max-h-96 overflow-y-auto rounded-2xl border border-gray-200 bg-white shadow-xl hidden z-50"
        >
            <!-- Header -->
            <div class="sticky top-0 border-b border-gray-200 bg-white px-4 py-3 flex items-center justify-between">
                <h3 class="font-bold text-gray-900">Notifications</h3>
                <button 
                    type="button"
                    id="closeNotif"
                    class="text-gray-400 hover:text-gray-600"
                >
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Notifications List -->
            <div id="notificationsList" class="space-y-2 p-3">
                <p class="text-xs text-gray-500 text-center py-3">Chargement...</p>
            </div>

            <!-- Footer -->
            <div class="border-t border-gray-200 bg-gray-50 px-4 py-3 text-center">
                <a 
                    href="{{ route('notifications.index') }}"
                    class="text-xs font-semibold text-primary hover:text-primary-dark transition-colors"
                >
                    <i class="fas fa-arrow-right mr-1"></i>
                    Voir toutes les notifications
                </a>
            </div>
        </div>
    </div>

    <script>
        const bell = document.getElementById('notificationBell');
        const panel = document.getElementById('notificationPanel');
        const badge = document.getElementById('notificationBadge');
        const list = document.getElementById('notificationsList');
        const closeBtn = document.getElementById('closeNotif');

        // Charger les notifications
        async function loadNotifications() {
            try {
                const response = await fetch('{{ route("api.notifications.unread") }}');
                const data = await response.json();

                // Mettre à jour le badge
                if (data.unread_count > 0) {
                    badge.textContent = data.unread_count > 99 ? '99+' : data.unread_count;
                    badge.classList.remove('hidden');
                } else {
                    badge.classList.add('hidden');
                }

                // Mettre à jour la liste
                if (data.notifications.length > 0) {
                    list.innerHTML = data.notifications.map(n => `
                        <div class="rounded-lg border border-blue-200 bg-blue-50 p-3 hover:shadow-sm transition-all">
                            <div class="flex items-start gap-2">
                                <div class="flex-1">
                                    ${getNotificationIcon(n.type)}
                                    <p class="text-sm font-semibold text-gray-900">${n.message}</p>
                                    <p class="mt-1 text-xs text-gray-600">${n.created_at}</p>
                                </div>
                            </div>
                        </div>
                    `).join('');
                } else {
                    list.innerHTML = '<p class="text-xs text-gray-500 text-center py-6">Aucune notification</p>';
                }
            } catch (error) {
                console.error('Erreur lors du chargement des notifications:', error);
                list.innerHTML = '<p class="text-xs text-red-600 text-center py-3">Erreur de chargement</p>';
            }
        }

        function getNotificationIcon(type) {
            if (type === 'new_answer') {
                return '<div class="inline-flex items-center gap-2 mb-1"><i class="fas fa-comment text-blue-600 text-sm"></i></div>';
            } else if (type === 'answer_accepted') {
                return '<div class="inline-flex items-center gap-2 mb-1"><i class="fas fa-check-circle text-green-600 text-sm"></i></div>';
            } else if (type === 'content_deleted') {
                return '<div class="inline-flex items-center gap-2 mb-1"><i class="fas fa-trash-alt text-red-600 text-sm"></i></div>';
            }
            return '';
        }

        // Ouvrir/fermer le dropdown
        bell.addEventListener('click', (e) => {
            e.stopPropagation();
            panel.classList.toggle('hidden');
            if (!panel.classList.contains('hidden')) {
                loadNotifications();
            }
        });

        closeBtn.addEventListener('click', () => {
            panel.classList.add('hidden');
        });

        // Fermer quand on clique en dehors
        document.addEventListener('click', (e) => {
            if (!document.getElementById('notificationDropdown').contains(e.target)) {
                panel.classList.add('hidden');
            }
        });

        // Recharger toutes les 15 secondes
        setInterval(loadNotifications, 15000);

        // Charger initialement
        loadNotifications();
    </script>
@endauth
