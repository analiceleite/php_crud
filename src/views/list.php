<?php if (!empty($error)): ?>
    <div class="fixed top-4 right-4 bg-gradient-to-r from-red-500 to-red-600 text-white px-6 py-4 rounded-2xl shadow-2xl z-50 border border-red-400 backdrop-blur-sm">
        <div class="flex items-center space-x-3">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="font-medium"><?php echo htmlspecialchars($error); ?></span>
        </div>
    </div>
<?php endif; ?>

<?php if (!empty($success)): ?>
    <div class="fixed top-4 right-4 bg-gradient-to-r from-green-500 to-green-600 text-white px-6 py-4 rounded-2xl shadow-2xl z-50 border border-green-400 backdrop-blur-sm">
        <div class="flex items-center space-x-3">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="font-medium"><?php echo htmlspecialchars($success); ?></span>
        </div>
    </div>
<?php endif; ?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Usuários Cadastrados</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .action-button:hover {
            transform: scale(1.05);
        }

        .empty-state {
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(168, 85, 247, 0.1) 100%);
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .slide-in {
            animation: slideIn 0.5s ease-out forwards;
        }

        .table-row:hover {
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.05) 0%, rgba(168, 85, 247, 0.05) 100%);
        }

        .user-photo {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid white;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .user-photo-mobile {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .default-avatar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
    </style>
</head>

<body class="min-h-screen gradient-bg">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl animate-pulse"></div>
        <div class="absolute top-0 right-0 w-72 h-72 bg-yellow-300 rounded-full mix-blend-multiply filter blur-xl animate-pulse animation-delay-2000"></div>
        <div class="absolute bottom-0 left-0 w-72 h-72 bg-pink-300 rounded-full mix-blend-multiply filter blur-xl animate-pulse animation-delay-4000"></div>
    </div>

    <div class="relative z-10 min-h-screen p-4">
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
            <div class="glass-effect rounded-3xl shadow-2xl overflow-hidden mb-8 slide-in">
                <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 p-8">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                        <div class="flex items-center space-x-4 mb-4 lg:mb-0">
                            <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center shadow-lg">
                                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-3xl font-bold text-white">Usuários Cadastrados</h1>
                                <p class="text-indigo-100 mt-1">Gerencie sua comunidade de usuários</p>
                            </div>
                        </div>

                        <!-- Novo Usuário Button -->
                        <a href="home.php?action=form"
                            class="bg-white text-indigo-600 px-8 py-4 rounded-2xl font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 hover:scale-105 action-button flex items-center space-x-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            <span>Novo Usuário</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Users Table/Cards -->
            <div class="glass-effect rounded-3xl shadow-2xl overflow-hidden slide-in">
                <?php if (!empty($users)): ?>
                    <!-- Desktop Table View -->
                    <div class="hidden lg:block">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                                        <th class="text-left p-6 font-semibold text-gray-700 uppercase tracking-wider text-sm">
                                            <div class="flex items-center space-x-2">
                                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                                <span>Usuário</span>
                                            </div>
                                        </th>
                                        <th class="text-left p-6 font-semibold text-gray-700 uppercase tracking-wider text-sm">
                                            <div class="flex items-center space-x-2">
                                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                                </svg>
                                                <span>Email</span>
                                            </div>
                                        </th>
                                        <th class="text-left p-6 font-semibold text-gray-700 uppercase tracking-wider text-sm">
                                            <div class="flex items-center space-x-2">
                                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                <span>Estado</span>
                                            </div>
                                        </th>
                                        <th class="text-left p-6 font-semibold text-gray-700 uppercase tracking-wider text-sm">
                                            <div class="flex items-center space-x-2">
                                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                                </svg>
                                                <span>Interesses</span>
                                            </div>
                                        </th>
                                        <th class="text-right p-6 font-semibold text-gray-700 uppercase tracking-wider text-sm">Ações</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white/80 backdrop-blur-sm divide-y divide-gray-200">
                                    <?php foreach ($users as $index => $u): ?>
                                        <tr class="table-row transition-all duration-300" style="animation-delay: <?= $index * 0.1 ?>s">
                                            <td class="p-6">
                                                <div class="flex items-center space-x-4">
                                                    <?php if (!empty($u['photo'])): ?>
                                                        <img src="/formulario/public/<?php echo htmlspecialchars($u['photo']); ?>"
                                                            alt="Foto de <?= htmlspecialchars($u['name']) ?>"
                                                            class="user-photo"
                                                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                                        <div class="user-photo default-avatar" style="display: none;">
                                                            <?= strtoupper(substr(htmlspecialchars($u['name']), 0, 1)) ?>
                                                        </div>
                                                    <?php else: ?>
                                                        <div class="user-photo default-avatar">
                                                            <?= strtoupper(substr(htmlspecialchars($u['name']), 0, 1)) ?>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div>
                                                        <div class="font-semibold text-gray-900"><?= htmlspecialchars($u['name']) ?></div>
                                                        <div class="text-sm text-gray-500">@<?= htmlspecialchars($u['username']) ?></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="p-6">
                                                <div class="text-gray-900"><?= htmlspecialchars($u['email']) ?></div>
                                            </td>
                                            <td class="p-6">
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gradient-to-r from-blue-100 to-indigo-100 text-indigo-800 border border-indigo-200">
                                                    <?= htmlspecialchars($u['state']) ?>
                                                </span>
                                            </td>
                                            <td class="p-6">
                                                <div class="flex flex-wrap gap-1">
                                                    <?php if (!empty($u['interests']) && is_array($u['interests'])): ?>
                                                        <?php foreach (array_slice($u['interests'], 0, 3) as $interest): ?>
                                                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-gradient-to-r from-purple-100 to-pink-100 text-purple-800 border border-purple-200">
                                                                <?= htmlspecialchars($interest) ?>
                                                            </span>
                                                        <?php endforeach; ?>
                                                        <?php if (count($u['interests']) > 3): ?>
                                                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-gray-100 text-gray-600">
                                                                +<?= count($u['interests']) - 3 ?>
                                                            </span>
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                        <span class="text-gray-400 text-sm">Nenhum</span>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td class="p-6 text-right">
                                                <div class="flex justify-end space-x-3">
                                                    <a href="?edit=<?= $u['user_id'] ?>"
                                                        class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-4 py-2 rounded-xl font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 action-button flex items-center space-x-2">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                        </svg>
                                                        <span>Editar</span>
                                                    </a>
                                                    <a href="?delete=<?= $u['user_id'] ?>"
                                                        onclick="return confirm('Deseja excluir este usuário?')"
                                                        class="bg-gradient-to-r from-red-500 to-red-600 text-white px-4 py-2 rounded-xl font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 action-button flex items-center space-x-2">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                        <span>Excluir</span>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Mobile Cards View -->
                    <div class="lg:hidden p-6 space-y-4">
                        <?php foreach ($users as $index => $u): ?>
                            <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-lg border border-white/30 card-hover transition-all duration-300" style="animation-delay: <?= $index * 0.1 ?>s">
                                <div class="flex items-start space-x-4 mb-4">
                                    <?php if (!empty($u['photo'])): ?>
                                        <img src="<?= htmlspecialchars($u['photo']) ?>"
                                            alt="Foto de <?= htmlspecialchars($u['name']) ?>"
                                            class="user-photo-mobile flex-shrink-0"
                                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                        <div class="user-photo-mobile default-avatar flex-shrink-0" style="display: none;">
                                            <?= strtoupper(substr(htmlspecialchars($u['name']), 0, 1)) ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="user-photo-mobile default-avatar flex-shrink-0">
                                            <?= strtoupper(substr(htmlspecialchars($u['name']), 0, 1)) ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-semibold text-gray-900 text-lg"><?= htmlspecialchars($u['name']) ?></h3>
                                        <p class="text-gray-600">@<?= htmlspecialchars($u['username']) ?></p>
                                        <p class="text-gray-600"><?= htmlspecialchars($u['email']) ?></p>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gradient-to-r from-blue-100 to-indigo-100 text-indigo-800 border border-indigo-200">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        </svg>
                                        <?= htmlspecialchars($u['state']) ?>
                                    </span>
                                </div>

                                <?php if (!empty($u['interests']) && is_array($u['interests'])): ?>
                                    <div class="mb-4">
                                        <p class="text-sm font-medium text-gray-700 mb-2">Interesses:</p>
                                        <div class="flex flex-wrap gap-2">
                                            <?php foreach ($u['interests'] as $interest): ?>
                                                <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-gradient-to-r from-purple-100 to-pink-100 text-purple-800 border border-purple-200">
                                                    <?= htmlspecialchars($interest) ?>
                                                </span>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <div class="flex space-x-3">
                                    <a href="?edit=<?= $u['id'] ?>"
                                        class="flex-1 bg-gradient-to-r from-blue-500 to-blue-600 text-white px-4 py-3 rounded-xl font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 action-button text-center">
                                        <div class="flex items-center justify-center space-x-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            <span>Editar</span>
                                        </div>
                                    </a>
                                    <a href="?delete=<?= $u['id'] ?>"
                                        onclick="return confirm('Deseja excluir este usuário?')"
                                        class="flex-1 bg-gradient-to-r from-red-500 to-red-600 text-white px-4 py-3 rounded-xl font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 action-button text-center">
                                        <div class="flex items-center justify-center space-x-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            <span>Excluir</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                <?php else: ?>
                    <!-- Empty State -->
                    <div class="empty-state p-12 text-center">
                        <div class="w-24 h-24 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-700 mb-4">Nenhum usuário cadastrado</h3>
                        <p class="text-gray-600 mb-8 max-w-md mx-auto">Comece criando seu primeiro usuário para gerenciar sua comunidade de forma eficiente.</p>
                        <a href="home.php?action=form"
                            class="inline-flex items-center space-x-3 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 text-white px-8 py-4 rounded-2xl font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 hover:scale-105">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            <span>Criar Primeiro Usuário</span>
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Interests Footer -->
            <div class="mt-8 glass-effect rounded-3xl shadow-2xl overflow-hidden slide-in">
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-teal-500 rounded-xl flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 2L2 7l10 5 10-5-10-5zm0 7v13" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">Interesses</h3>
                                <p class="text-gray-600">Gerenciar interesses dos usuários</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <a href="interests.php"
                                class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-4 py-2 rounded-xl font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 action-button flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                <span>Editar</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Footer -->
            <div class="mt-8 glass-effect rounded-3xl shadow-2xl overflow-hidden slide-in">
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-teal-500 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">Estatísticas</h3>
                                <p class="text-gray-600">Resumo da sua base de usuários</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-3xl font-bold text-transparent bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text">
                                <?= count($users ?? []) ?>
                            </div>
                            <div class="text-sm text-gray-600">
                                <?= count($users ?? []) === 1 ? 'usuário cadastrado' : 'usuários cadastrados' ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-hide notificações após 5 segundos
        setTimeout(() => {
            const notifications = document.querySelectorAll('.fixed.top-4.right-4');
            notifications.forEach(notification => {
                notification.style.opacity = '0';
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => notification.remove(), 300);
            });
        }, 5000);

        // Smooth scroll para ações
        document.querySelectorAll('a[href^="?"]').forEach(link => {
            link.addEventListener('click', function(e) {
                if (this.getAttribute('href').includes('delete')) {
                    return; // Deixa o confirm dialog funcionar normalmente
                }

                // Adiciona uma pequena animação de loading para outras ações
                const button = this;
                const originalText = button.innerHTML;

                if (!button.classList.contains('loading')) {
                    button.classList.add('loading');
                    button.style.opacity = '0.7';
                    button.style.pointerEvents = 'none';

                    // Restaura após um tempo (caso a navegação falhe)
                    setTimeout(() => {
                        button.classList.remove('loading');
                        button.style.opacity = '';
                        button.style.pointerEvents = '';
                        button.innerHTML = originalText;
                    }, 3000);
                }
            });
        });
    </script>
</body>

</html>