<?php
require_once __DIR__ . '/../middlewares/AuthMiddleware.php';
?>


<?php
require_once __DIR__ . '/../controllers/InterestController.php';

$interestController = new InterestController();
$interestsFromDB = $interestController->index();
?>


<?php if (!empty($error)): ?>
    <div class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
        <?php echo htmlspecialchars($error); ?>
    </div>
<?php endif; ?>

<?php if (!empty($success)): ?>
    <div class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
        <?php echo htmlspecialchars($success); ?>
    </div>
<?php endif; ?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cadastro de Usuário</title>
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

        .input-focus:focus {
            transform: translateY(-1px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .floating-label {
            transform: translateY(-50%) scale(0.85);
            color: #6366f1;
        }

        .photo-preview {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .photo-container {
            position: relative;
            display: inline-block;
        }

        .photo-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .photo-container:hover .photo-overlay {
            opacity: 1;
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

    <div class="relative z-10 min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-4xl glass-effect rounded-3xl shadow-2xl overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 p-8 text-center">
                <div class="text-left">
                    <a href="/formulario/src/views/home.php"
                        class="inline-flex items-center space-x-2 bg-white text-indigo-600 px-8 py-4 rounded-2xl font-semibold shadow hover:shadow-md transition-all duration-300 hover:-translate-y-0.5 hover:scale-105">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                        <span>Voltar</span>
                    </a>
                </div>

                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <svg class="w-10 h-10 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-white mb-2"><?= isset($editUser) ? 'Editar Dados' : 'Criar Conta' ?></h1>
                <p class="text-indigo-100"><?= isset($editUser) ? 'Utilize esse espaço para editar os dados do usuário, é importante preencher todos os campos.' : 'Junte-se a nossa comunidade hoje mesmo!' ?></p>
            </div>

            <form action="/formulario/src/views/home.php" method="POST" enctype="multipart/form-data" class="p-8 space-y-8">
                <?php if (!empty($editUser)): ?>
                    <input type="hidden" name="id" value="<?= htmlspecialchars($editUser['user_id']) ?>">
                <?php endif; ?>
                <!-- Informações Pessoais -->
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-lg border border-white/30">
                    <div class="flex items-center mb-6">
                        <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-800">Informações Pessoais</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="relative">
                            <input type="text" name="name" required minlength="5"
                                value="<?= isset($editUser) ? htmlspecialchars($editUser['name']) : (isset($_SESSION['form_data']['name']) ? htmlspecialchars($_SESSION['form_data']['name']) : '') ?>"
                                pattern="^[A-Za-zÀ-ÿ\s]+\s+[A-Za-zÀ-ÿ\s]+$"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:outline-none transition-all duration-300 input-focus bg-white/50 backdrop-blur-sm"
                                placeholder="Nome Completo (ex: João Silva)"
                                title="Digite seu nome completo (nome e sobrenome)" />
                        </div>

                        <div class="relative">
                            <input type="email" name="email" required
                                value="<?= isset($editUser) ? htmlspecialchars($editUser['email']) : (isset($_SESSION['form_data']['email']) ? htmlspecialchars($_SESSION['form_data']['email']) : '') ?>"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:outline-none transition-all duration-300 input-focus bg-white/50 backdrop-blur-sm"
                                placeholder="seu@email.com" />
                        </div>

                        <div class="relative">
                            <input type="date" name="birth_date" required max="<?php echo date('Y-m-d'); ?>"
                                value="<?= isset($editUser) ? htmlspecialchars($editUser['birth_date']) : (isset($_SESSION['form_data']['birth_date']) ? htmlspecialchars($_SESSION['form_data']['birth_date']) : '') ?>"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:outline-none transition-all duration-300 input-focus bg-white/50 backdrop-blur-sm" />
                        </div>

                        <div class="relative">
                            <select name="state" required
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:outline-none transition-all duration-300 input-focus bg-white/50 backdrop-blur-sm">
                                <option value="">Selecione o estado</option>
                                <option value="Santa Catarina" <?= (isset($editUser) && $editUser['state'] == 'Santa Catarina') || (isset($_SESSION['form_data']['state']) && $_SESSION['form_data']['state'] == 'Santa Catarina') ? 'selected' : '' ?>>Santa Catarina</option>
                                <option value="São Paulo" <?= (isset($editUser) && $editUser['state'] == 'São Paulo') || (isset($_SESSION['form_data']['state']) && $_SESSION['form_data']['state'] == 'São Paulo') ? 'selected' : '' ?>>São Paulo</option>
                                <option value="Rio de Janeiro" <?= (isset($editUser) && $editUser['state'] == 'Rio de Janeiro') || (isset($_SESSION['form_data']['state']) && $_SESSION['form_data']['state'] == 'Rio de Janeiro') ? 'selected' : '' ?>>Rio de Janeiro</option>
                                <option value="Minas Gerais" <?= (isset($editUser) && $editUser['state'] == 'Minas Gerais') || (isset($_SESSION['form_data']['state']) && $_SESSION['form_data']['state'] == 'Minas Gerais') ? 'selected' : '' ?>>Minas Gerais</option>
                            </select>
                        </div>

                        <div class="md:col-span-2 relative">
                            <input type="text" name="address" required
                                value="<?= isset($editUser) ? htmlspecialchars($editUser['address']) : (isset($_SESSION['form_data']['address']) ? htmlspecialchars($_SESSION['form_data']['address']) : '') ?>"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:outline-none transition-all duration-300 input-focus bg-white/50 backdrop-blur-sm"
                                placeholder="Endereço completo" />
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Sexo</label>
                            <div class="flex flex-wrap gap-4">
                                <label class="flex items-center space-x-3 cursor-pointer group">
                                    <input type="radio" name="gender" value="Masculino" required
                                        <?= (isset($editUser) && $editUser['gender'] == 'Masculino') || (isset($_SESSION['form_data']['gender']) && $_SESSION['form_data']['gender'] == 'Masculino') ? 'checked' : '' ?>
                                        class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500" />
                                    <span class="text-gray-700 group-hover:text-indigo-600 transition-colors">Masculino</span>
                                </label>
                                <label class="flex items-center space-x-3 cursor-pointer group">
                                    <input type="radio" name="gender" value="Feminino"
                                        <?= (isset($editUser) && $editUser['gender'] == 'Feminino') || (isset($_SESSION['form_data']['gender']) && $_SESSION['form_data']['gender'] == 'Feminino') ? 'checked' : '' ?>
                                        class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500" />
                                    <span class="text-gray-700 group-hover:text-indigo-600 transition-colors">Feminino</span>
                                </label>
                                <label class="flex items-center space-x-3 cursor-pointer group">
                                    <input type="radio" name="gender" value="Outro"
                                        <?= (isset($editUser) && $editUser['gender'] == 'Outro') || (isset($_SESSION['form_data']['gender']) && $_SESSION['form_data']['gender'] == 'Outro') ? 'checked' : '' ?>
                                        class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500" />
                                    <span class="text-gray-700 group-hover:text-indigo-600 transition-colors">Outro</span>
                                </label>
                            </div>
                        </div>

                        <!-- Seção de foto melhorada -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-4">Foto de Perfil</label>

                            <!-- Foto atual (se existir) -->
                            <?php if (!empty($editUser['photo'])): ?>
                                <div class="mb-4 text-center">
                                    <div class="photo-container inline-block">
                                        <img src="/formulario/public/<?= htmlspecialchars($editUser['photo']) ?>"
                                            alt="Foto atual" class="photo-preview">
                                        <div class="photo-overlay">
                                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-2">Foto atual</p>
                                </div>
                            <?php endif; ?>

                            <!-- Input para nova foto -->
                            <div class="flex items-center justify-center w-full">
                                <label for="photo" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-8 h-8 mb-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500">
                                            <span class="font-semibold"><?= isset($editUser) ? 'Clique para alterar' : 'Clique para enviar' ?></span>
                                        </p>
                                        <p class="text-xs text-gray-500">PNG, JPG, GIF ou WEBP (MAX. 5MB)</p>
                                    </div>
                                    <input id="photo" type="file" name="photo" accept="image/jpeg,image/png,image/gif,image/webp" class="hidden" />
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Preferências -->
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-lg border border-white/30">
                    <div class="flex items-center mb-6">
                        <div class="w-8 h-8 bg-gradient-to-r from-green-500 to-teal-500 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-800">Preferências</h2>
                    </div>


                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-4">Categorias de interesse</label>
                        <?php if (empty($interestsFromDB)): ?>
                            <div class="text-center py-8 bg-gray-50 rounded-xl border-2 border-dashed border-gray-300">
                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                                <p class="text-gray-500 mb-2">Nenhum interesse disponível</p>
                                <a href="interests.php" class="text-indigo-600 hover:text-indigo-800 font-medium">
                                    Gerenciar interesses
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                <?php
                                // Obter interesses do usuário (se estiver editando)
                                $userInterests = [];
                                if (isset($editUser) && !empty($editUser['interests'])) {
                                    $userInterests = (is_array($editUser['interests']) ? $editUser['interests'] : json_decode($editUser['interests'], true)) ?: [];
                                } elseif (isset($_SESSION['form_data']['interests'])) {
                                    $userInterests = $_SESSION['form_data']['interests'];
                                }

                                foreach ($interestsFromDB as $interest):
                                ?>
                                    <label class="flex items-center space-x-3 p-3 rounded-xl border-2 border-gray-200 hover:border-indigo-300 hover:bg-indigo-50 transition-all duration-300 cursor-pointer group">
                                        <input type="checkbox"
                                            name="interests[]"
                                            value="<?= $interest['interest_id'] ?>"
                                            <?= in_array($interest['interest_id'], $userInterests) ? 'checked' : '' ?>
                                            class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" />
                                        <span class="text-gray-700 group-hover:text-indigo-600 transition-colors font-medium">
                                            <?= htmlspecialchars($interest['name']) ?>
                                        </span>
                                        <span class="text-xs text-gray-500 ml-auto">
                                            (<?= $interest['user_count'] ?>)
                                        </span>
                                    </label>
                                <?php endforeach; ?>
                            </div>

                            <!-- Link para gerenciar interesses -->
                            <div class="mt-4 text-center">
                                <a href="interests.php" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                                    ✨ Gerenciar interesses disponíveis
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Login -->
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-lg border border-white/30">
                    <div class="flex items-center mb-6">
                        <div class="w-8 h-8 bg-gradient-to-r from-red-500 to-pink-500 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-800">Credenciais de Acesso</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="relative">
                            <input type="text" name="username" required minlength="3"
                                value="<?= isset($editUser) ? htmlspecialchars($editUser['username']) : (isset($_SESSION['form_data']['username']) ? htmlspecialchars($_SESSION['form_data']['username']) : '') ?>"
                                pattern="^[a-zA-Z0-9_]+$"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:outline-none transition-all duration-300 input-focus bg-white/50 backdrop-blur-sm"
                                placeholder="Nome de usuário"
                                title="Use apenas letras, números e underscore" />
                        </div>

                        <div class="relative">
                            <input type="password" name="password"
                                <?= isset($editUser) ? '' : 'required' ?>
                                minlength="6"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:outline-none transition-all duration-300 input-focus bg-white/50 backdrop-blur-sm"
                                placeholder="<?= isset($editUser) ? 'Nova senha (deixe em branco para manter)' : 'Senha segura' ?>" />
                            <?php if (isset($editUser)): ?>
                                <input type="hidden" name="current_password" value="<?= htmlspecialchars($editUser['password']) ?>">
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="text-center pt-4 space-y-4">
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <button type="submit"
                            class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 text-white px-8 py-4 rounded-2xl font-semibold text-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 hover:scale-105">
                            <span class="flex items-center justify-center space-x-2">
                                <span><?= isset($editUser) ? 'Atualizar Dados' : 'Criar Conta' ?></span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </span>
                        </button>

                        <button type="reset"
                            class="bg-gradient-to-r from-gray-500 to-gray-600 text-white px-8 py-4 rounded-2xl font-semibold text-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 hover:scale-105">
                            <span class="flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                <span>Limpar Campos</span>
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Preview da foto antes do upload
        document.getElementById('photo').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Validar tipo de arquivo
                const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Tipo de arquivo não permitido. Use apenas JPG, PNG, GIF ou WEBP.');
                    this.value = '';
                    return;
                }

                // Validar tamanho (5MB)
                if (file.size > 5 * 1024 * 1024) {
                    alert('Arquivo muito grande. Tamanho máximo: 5MB.');
                    this.value = '';
                    return;
                }

                // Preview da imagem
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Criar ou atualizar preview
                    let preview = document.querySelector('.photo-preview-new');
                    if (!preview) {
                        preview = document.createElement('img');
                        preview.className = 'photo-preview photo-preview-new mt-4';
                        document.querySelector('label[for="photo"]').parentNode.appendChild(preview);
                    }
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        });

        // Auto-hide notificações após 5 segundos
        setTimeout(() => {
            const notifications = document.querySelectorAll('.fixed.top-4.right-4');
            notifications.forEach(notification => {
                notification.style.opacity = '0';
                setTimeout(() => notification.remove(), 300);
            });
        }, 5000);
    </script>
</body>

</html>