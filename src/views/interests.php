<?php
session_start();
require_once __DIR__ . '/../controllers/InterestController.php';

$controller = new InterestController();
$action = $_GET['action'] ?? 'list';
$id = $_GET['id'] ?? null;

// Processar ações POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'store':
                $controller->store($_POST);
                break;
            case 'update':
                $controller->update($_POST['interest_id'], $_POST);
                break;
            case 'delete':
                $controller->destroy($_POST['interest_id']);
                break;
        }
    }
}

// Buscar dados para exibição
$interests = $controller->index();
$editingInterest = null;
$usersForInterest = [];

if ($action === 'edit' && $id) {
    $editingInterest = $controller->find($id);
}

if ($action === 'view' && $id) {
    $usersForInterest = $controller->getUsersByInterest($id);
    $editingInterest = $controller->find($id);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Interesses - Sistema</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-up': 'slideUp 0.6s ease-out',
                        'slide-down': 'slideDown 0.3s ease-out',
                        'shake': 'shake 0.5s ease-in-out',
                        'bounce-in': 'bounceIn 0.6s ease-out',
                        'scale-in': 'scaleIn 0.3s ease-out',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': {
                                opacity: '0'
                            },
                            '100%': {
                                opacity: '1'
                            }
                        },
                        slideUp: {
                            '0%': {
                                transform: 'translateY(20px)',
                                opacity: '0'
                            },
                            '100%': {
                                transform: 'translateY(0)',
                                opacity: '1'
                            }
                        },
                        slideDown: {
                            '0%': {
                                transform: 'translateY(-20px)',
                                opacity: '0'
                            },
                            '100%': {
                                transform: 'translateY(0)',
                                opacity: '1'
                            }
                        },
                        shake: {
                            '0%, 100%': {
                                transform: 'translateX(0)'
                            },
                            '25%': {
                                transform: 'translateX(-5px)'
                            },
                            '75%': {
                                transform: 'translateX(5px)'
                            }
                        },
                        bounceIn: {
                            '0%': {
                                transform: 'scale(0.3)',
                                opacity: '0'
                            },
                            '50%': {
                                transform: 'scale(1.05)'
                            },
                            '70%': {
                                transform: 'scale(0.9)'
                            },
                            '100%': {
                                transform: 'scale(1)',
                                opacity: '1'
                            }
                        },
                        scaleIn: {
                            '0%': {
                                transform: 'scale(0.9)',
                                opacity: '0'
                            },
                            '100%': {
                                transform: 'scale(1)',
                                opacity: '1'
                            }
                        }
                    }
                }
            }
        }
    </script>
</head>

<body class="min-h-screen bg-gradient-to-br from-purple-900 via-purple-800 to-indigo-900 p-4 animate-fade-in">

    <!-- Background decorativo -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-purple-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-pulse"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-indigo-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-pulse"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-pink-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-pulse"></div>
    </div>

    <div class="relative max-w-7xl mx-auto">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-center mb-8 animate-slide-down">
            <div class="flex items-center mb-4 sm:mb-0">
                <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center shadow-lg mr-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-white">Gerenciar Interesses</h1>
                    <p class="text-purple-200">Administre os interesses do sistema</p>
                </div>
            </div>
            <a href="home.php" class="bg-white/10 backdrop-blur-lg border border-white/20 text-white px-6 py-2 rounded-lg hover:bg-white/20 transition-all duration-200 flex items-center space-x-2 transform hover:scale-105">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Voltar</span>
            </a>
        </div>

        <!-- Mensagens de Feedback -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="mb-6 p-4 bg-green-500/20 border border-green-500/30 rounded-lg backdrop-blur-sm animate-bounce-in">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-300 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="text-green-200"><?php echo $_SESSION['success'];
                                                unset($_SESSION['success']); ?></p>
                </div>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="mb-6 p-4 bg-red-500/20 border border-red-500/30 rounded-lg backdrop-blur-sm animate-shake">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-red-300 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="text-red-200"><?php echo $_SESSION['error'];
                                            unset($_SESSION['error']); ?></p>
                </div>
            </div>
        <?php endif; ?>

        <div class="grid lg:grid-cols-3 gap-8">

            <!-- Formulário para Adicionar/Editar -->
            <div class="lg:col-span-1">
                <div class="bg-white/10 backdrop-blur-lg rounded-2xl shadow-2xl border border-white/20 p-6 animate-slide-up">
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-500 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <?php if ($editingInterest): ?>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                <?php else: ?>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                <?php endif; ?>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-white">
                            <?php echo $editingInterest ? 'Editar Interesse' : 'Novo Interesse'; ?>
                        </h2>
                    </div>

                    <form method="POST" action="" class="space-y-6">
                        <input type="hidden" name="action" value="<?php echo $editingInterest ? 'update' : 'store'; ?>">
                        <?php if ($editingInterest): ?>
                            <input type="hidden" name="interest_id" value="<?php echo $editingInterest['interest_id']; ?>">
                        <?php endif; ?>

                        <div>
                            <label for="name" class="block text-sm font-medium text-purple-200 mb-2">Nome do Interesse</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                </div>
                                <input type="text"
                                    class="block w-full pl-10 pr-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-purple-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 backdrop-blur-sm"
                                    id="name"
                                    name="name"
                                    value="<?php echo $editingInterest['name'] ?? ($_SESSION['form_data']['name'] ?? ''); ?>"
                                    required
                                    placeholder="Ex: Programação, Esportes, Música...">
                            </div>
                        </div>

                        <div class="space-y-3">
                            <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white font-semibold py-3 px-4 rounded-lg hover:from-purple-700 hover:to-pink-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 focus:ring-offset-transparent transition-all duration-200 transform hover:scale-105 hover:shadow-lg active:scale-95">
                                <span class="flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <?php echo $editingInterest ? 'Atualizar' : 'Adicionar'; ?>
                                </span>
                            </button>
                            <?php if ($editingInterest): ?>
                                <a href="interests.php" class="w-full bg-white/10 backdrop-blur-lg border border-white/20 text-white py-3 px-4 rounded-lg hover:bg-white/20 transition-all duration-200 flex items-center justify-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    <span>Cancelar</span>
                                </a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Lista de Interesses -->
            <div class="lg:col-span-2">
                <div class="bg-white/10 backdrop-blur-lg rounded-2xl shadow-2xl border border-white/20 overflow-hidden animate-slide-up">

                    <!-- Header da lista -->
                    <div class="bg-gradient-to-r from-purple-600/50 to-pink-600/50 px-6 py-4 border-b border-white/10">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                                </svg>
                                <h2 class="text-xl font-bold text-white">Lista de Interesses</h2>
                            </div>
                            <span class="bg-white/20 text-white px-3 py-1 rounded-full text-sm font-medium">
                                <?php echo count($interests); ?> total
                            </span>
                        </div>
                    </div>

                    <!-- Conteúdo da lista -->
                    <div class="p-6">
                        <?php if (empty($interests)): ?>
                            <div class="text-center py-12 animate-scale-in">
                                <div class="w-20 h-20 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full mx-auto mb-4 flex items-center justify-center opacity-50">
                                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </div>
                                <p class="text-purple-200 text-lg">Nenhum interesse cadastrado ainda.</p>
                                <p class="text-purple-300 text-sm mt-2">Adicione o primeiro interesse usando o formulário ao lado.</p>
                            </div>
                        <?php else: ?>
                            <div class="space-y-4">
                                <?php foreach ($interests as $index => $interest): ?>
                                    <div class="bg-white/5 backdrop-blur-sm rounded-lg p-4 border border-white/10 hover:bg-white/10 transition-all duration-200 animate-scale-in" style="animation-delay: <?php echo $index * 0.1; ?>s">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-4">
                                                <div class="w-8 h-8 bg-gradient-to-r from-purple-500 to-pink-500 rounded-lg flex items-center justify-center text-white font-bold text-sm">
                                                    #<?php echo $interest['interest_id']; ?>
                                                </div>
                                                <div>
                                                    <h3 class="text-white font-semibold"><?php echo htmlspecialchars($interest['name']); ?></h3>
                                                    <p class="text-purple-300 text-sm">
                                                        <?php if ($interest['user_count'] > 0): ?>
                                                            <?php echo $interest['user_count']; ?> usuário(s) interessado(s)
                                                        <?php else: ?>
                                                            Nenhum usuário ainda
                                                        <?php endif; ?>
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="flex items-center space-x-2">
                                                <?php if ($interest['user_count'] > 0): ?>
                                                    <a href="?action=view&id=<?php echo $interest['interest_id']; ?>"
                                                        class="bg-blue-500/20 text-blue-300 hover:bg-blue-500/30 px-3 py-2 rounded-lg transition-all duration-200 flex items-center space-x-1">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                        </svg>
                                                        <span class="text-xs"><?php echo $interest['user_count']; ?></span>
                                                    </a>
                                                <?php endif; ?>

                                                <a href="?action=edit&id=<?php echo $interest['interest_id']; ?>"
                                                    class="bg-yellow-500/20 text-yellow-300 hover:bg-yellow-500/30 p-2 rounded-lg transition-all duration-200">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </a>

                                                <?php if ($interest['user_count'] == 0): ?>
                                                    <button onclick="confirmDelete(<?php echo $interest['interest_id']; ?>, '<?php echo htmlspecialchars($interest['name']); ?>')"
                                                        class="bg-red-500/20 text-red-300 hover:bg-red-500/30 p-2 rounded-lg transition-all duration-200">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                <?php else: ?>
                                                    <button disabled class="bg-gray-500/20 text-gray-400 p-2 rounded-lg cursor-not-allowed" title="Não pode ser excluído (tem usuários vinculados)">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"></path>
                                                        </svg>
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para mostrar usuários do interesse -->
        <?php if ($action === 'view' && $id && $editingInterest): ?>
            <div class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4 z-50 animate-fade-in">
                <div class="bg-white/10 backdrop-blur-lg rounded-2xl shadow-2xl border border-white/20 max-w-2xl w-full max-h-[80vh] overflow-hidden animate-bounce-in">

                    <!-- Header do modal -->
                    <div class="bg-gradient-to-r from-purple-600/50 to-pink-600/50 px-6 py-4 border-b border-white/10">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                                <h3 class="text-xl font-bold text-white">
                                    Usuários interessados em "<?php echo htmlspecialchars($editingInterest['name']); ?>"
                                </h3>
                            </div>
                            <a href="interests.php" class="text-white hover:text-purple-200 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Conteúdo do modal -->
                    <div class="p-6 overflow-y-auto max-h-96">
                        <?php if (empty($usersForInterest)): ?>
                            <div class="text-center py-8">
                                <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full mx-auto mb-4 flex items-center justify-center opacity-50">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <p class="text-purple-200">Nenhum usuário possui este interesse ainda.</p>
                            </div>
                        <?php else: ?>
                            <div class="space-y-3">
                                <?php foreach ($usersForInterest as $index => $user): ?>
                                    <div class="bg-white/5 backdrop-blur-sm rounded-lg p-4 border border-white/10 animate-scale-in" style="animation-delay: <?php echo $index * 0.1; ?>s">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white font-bold">
                                                <?php echo strtoupper(substr($user['name'], 0, 1)); ?>
                                            </div>
                                            <div class="flex-1">
                                                <h4 class="text-white font-semibold"><?php echo htmlspecialchars($user['name']); ?></h4>
                                                <p class="text-purple-300 text-sm"><?php echo htmlspecialchars($user['email']); ?></p>
                                            </div>
                                            <span class="text-purple-200 text-sm">ID: <?php echo $user['user_id']; ?></span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Footer do modal -->
                    <div class="px-6 py-4 border-t border-white/10 flex justify-end">
                        <a href="interests.php" class="bg-white/10 backdrop-blur-lg border border-white/20 text-white px-6 py-2 rounded-lg hover:bg-white/20 transition-all duration-200">
                            Fechar
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Footer -->
        <div class="text-center mt-8">
            <p class="text-purple-300 text-sm">© 2025 - Analice Sistema. Todos os direitos reservados.</p>
        </div>
    </div>

    <!-- Formulário oculto para deletar -->
    <form id="deleteForm" method="POST" style="display: none;">
        <input type="hidden" name="action" value="delete">
        <input type="hidden" name="interest_id" id="deleteId">
    </form>

    <script>
        function confirmDelete(id, name) {
            if (confirm(`Tem certeza que deseja excluir o interesse "${name}"?\n\nEsta ação não pode ser desfeita.`)) {
                document.getElementById('deleteId').value = id;
                document.getElementById('deleteForm').submit();
            }
        }

        // Auto-dismiss alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('[class*="animate-bounce-in"], [class*="animate-shake"]');
            alerts.forEach(function(alert) {
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-20px)';
                setTimeout(() => alert.remove(), 300);
            });
        }, 5000);

        // Focus no campo nome ao carregar
        document.addEventListener('DOMContentLoaded', function() {
            const nameField = document.getElementById('name');
            if (nameField) {
                nameField.focus();
            }
        });
    </script>

</body>

</html>

<?php
// Limpar dados do formulário da sessão
unset($_SESSION['form_data']);
?>