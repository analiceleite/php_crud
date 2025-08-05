<?php if (!empty($error)): ?>
    <div class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
        <?php echo htmlspecialchars($error); ?>
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
                    <a href="index.php"
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
                <!-- Novo Usuário Button -->
                <h1 class="text-3xl font-bold text-white mb-2"><?= isset($editUser) ? 'Editar Dados' : 'Criar Conta' ?></h1>
                <p class="text-indigo-100"><?= isset($editUser) ? 'Utilize esse espaço para editar os dados do usuário, é importante preencher todos os campos.' : 'Junte-se a nossa comunidade hoje mesmo!' ?></p>
            </div>

            <form action="index.php" method="POST" class="p-8 space-y-8">
                <?php if (!empty($editUser['id'])): ?>
                    <input type="hidden" name="id" value="<?= htmlspecialchars($editUser['id']) ?>">
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
                            <input type="text" name="name" required minlength="5" value pattern="^[A-Za-zÀ-ÿ\s]+\s+[A-Za-zÀ-ÿ\s]+$"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:outline-none transition-all duration-300 input-focus bg-white/50 backdrop-blur-sm"
                                placeholder="Nome Completo (ex: João Silva)"
                                title="Digite seu nome completo (nome e sobrenome)" />
                        </div>

                        <div class="relative">
                            <input type="email" name="email" required
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:outline-none transition-all duration-300 input-focus bg-white/50 backdrop-blur-sm"
                                placeholder="seu@email.com" />
                        </div>

                        <div class="relative">
                            <input type="date" name="birth_date" required max="<?php echo date('Y-m-d'); ?>"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:outline-none transition-all duration-300 input-focus bg-white/50 backdrop-blur-sm" />
                        </div>

                        <div class="relative">
                            <select name="state" required
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:outline-none transition-all duration-300 input-focus bg-white/50 backdrop-blur-sm">
                                <option value="">Selecione o estado</option>
                                <option value="Santa Catarina">Santa Catarina</option>
                                <option value="São Paulo">São Paulo</option>
                                <option value="Rio de Janeiro">Rio de Janeiro</option>
                                <option value="Minas Gerais">Minas Gerais</option>
                            </select>
                        </div>

                        <div class="md:col-span-2 relative">
                            <input type="text" name="address" required
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:outline-none transition-all duration-300 input-focus bg-white/50 backdrop-blur-sm"
                                placeholder="Endereço completo" />
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Sexo</label>
                            <div class="flex flex-wrap gap-4">
                                <label class="flex items-center space-x-3 cursor-pointer group">
                                    <input type="radio" name="gender" value="Masculino" required
                                        class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500" />
                                    <span class="text-gray-700 group-hover:text-indigo-600 transition-colors">Masculino</span>
                                </label>
                                <label class="flex items-center space-x-3 cursor-pointer group">
                                    <input type="radio" name="gender" value="Feminino"
                                        class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500" />
                                    <span class="text-gray-700 group-hover:text-indigo-600 transition-colors">Feminino</span>
                                </label>
                                <label class="flex items-center space-x-3 cursor-pointer group">
                                    <input type="radio" name="gender" value="Outro"
                                        class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500" />
                                    <span class="text-gray-700 group-hover:text-indigo-600 transition-colors">Outro</span>
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
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <label class="flex items-center space-x-3 p-3 rounded-xl border-2 border-gray-200 hover:border-indigo-300 hover:bg-indigo-50 transition-all duration-300 cursor-pointer group">
                                <input type="checkbox" name="interests[]" value="Moda"
                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" />
                                <span class="text-gray-700 group-hover:text-indigo-600 transition-colors font-medium">Moda</span>
                            </label>
                            <label class="flex items-center space-x-3 p-3 rounded-xl border-2 border-gray-200 hover:border-indigo-300 hover:bg-indigo-50 transition-all duration-300 cursor-pointer group">
                                <input type="checkbox" name="interests[]" value="Tecnologia"
                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" />
                                <span class="text-gray-700 group-hover:text-indigo-600 transition-colors font-medium">Tecnologia</span>
                            </label>
                            <label class="flex items-center space-x-3 p-3 rounded-xl border-2 border-gray-200 hover:border-indigo-300 hover:bg-indigo-50 transition-all duration-300 cursor-pointer group">
                                <input type="checkbox" name="interests[]" value="Esportes"
                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" />
                                <span class="text-gray-700 group-hover:text-indigo-600 transition-colors font-medium">Esportes</span>
                            </label>
                            <label class="flex items-center space-x-3 p-3 rounded-xl border-2 border-gray-200 hover:border-indigo-300 hover:bg-indigo-50 transition-all duration-300 cursor-pointer group">
                                <input type="checkbox" name="interests[]" value="Música"
                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" />
                                <span class="text-gray-700 group-hover:text-indigo-600 transition-colors font-medium">Música</span>
                            </label>
                        </div>
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
                            <input type="text" name="username" required
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:outline-none transition-all duration-300 input-focus bg-white/50 backdrop-blur-sm"
                                placeholder="Nome de usuário" />
                        </div>

                        <div class="relative">
                            <input type="password" name="password" required
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:outline-none transition-all duration-300 input-focus bg-white/50 backdrop-blur-sm"
                                placeholder="Senha segura" />
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="text-center pt-4 space-y-4">
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <button type="submit"
                            class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 text-white px-8 py-4 rounded-2xl font-semibold text-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 hover:scale-105">
                            <span class="flex items-center justify-center space-x-2">
                                <?= isset($editUser) ? 'Atualizar Dados' : 'Criar Conta' ?>
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
</body>

</html>