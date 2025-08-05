<?php
session_start();

// Recuperar dados da sessão
$greeting = $_SESSION['greeting'] ?? 'Olá';
$isMinor = $_SESSION['is_minor'] ?? false;
$age = $_SESSION['age'] ?? 0;

// Limpar dados da sessão
unset($_SESSION['greeting'], $_SESSION['is_minor'], $_SESSION['age']);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cadastro Realizado com Sucesso!</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
        
        .success-animation {
            animation: successPulse 2s ease-in-out infinite;
        }
        
        @keyframes successPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        .check-animation {
            animation: checkDraw 0.6s ease-in-out forwards;
            stroke-dasharray: 100;
            stroke-dashoffset: 100;
        }
        
        @keyframes checkDraw {
            to { stroke-dashoffset: 0; }
        }
        
        .fade-in {
            animation: fadeInUp 0.8s ease-out forwards;
            opacity: 0;
            transform: translateY(20px);
        }
        
        .fade-in-delay {
            animation: fadeInUp 0.8s ease-out 0.3s forwards;
            opacity: 0;
            transform: translateY(20px);
        }
        
        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .confetti {
            position: absolute;
            width: 10px;
            height: 10px;
            background: #f59e0b;
            animation: confetti-fall 3s linear infinite;
        }
        
        .confetti:nth-child(1) { left: 10%; animation-delay: 0s; background: #ef4444; }
        .confetti:nth-child(2) { left: 20%; animation-delay: 0.5s; background: #10b981; }
        .confetti:nth-child(3) { left: 30%; animation-delay: 1s; background: #3b82f6; }
        .confetti:nth-child(4) { left: 40%; animation-delay: 1.5s; background: #8b5cf6; }
        .confetti:nth-child(5) { left: 50%; animation-delay: 2s; background: #f59e0b; }
        .confetti:nth-child(6) { left: 60%; animation-delay: 0.3s; background: #ef4444; }
        .confetti:nth-child(7) { left: 70%; animation-delay: 0.8s; background: #10b981; }
        .confetti:nth-child(8) { left: 80%; animation-delay: 1.3s; background: #3b82f6; }
        .confetti:nth-child(9) { left: 90%; animation-delay: 1.8s; background: #8b5cf6; }
        
        @keyframes confetti-fall {
            0% {
                transform: translateY(-100vh) rotate(0deg);
                opacity: 1;
            }
            100% {
                transform: translateY(100vh) rotate(720deg);
                opacity: 0;
            }
        }
    </style>
</head>
<body class="min-h-screen gradient-bg overflow-hidden">
    <!-- Confetti Animation -->
    <div class="fixed inset-0 pointer-events-none z-0">
        <div class="confetti"></div>
        <div class="confetti"></div>
        <div class="confetti"></div>
        <div class="confetti"></div>
        <div class="confetti"></div>
        <div class="confetti"></div>
        <div class="confetti"></div>
        <div class="confetti"></div>
        <div class="confetti"></div>
    </div>

    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-72 h-72 bg-green-300 rounded-full mix-blend-multiply filter blur-xl animate-pulse"></div>
        <div class="absolute top-0 right-0 w-72 h-72 bg-blue-300 rounded-full mix-blend-multiply filter blur-xl animate-pulse animation-delay-2000"></div>
        <div class="absolute bottom-0 left-0 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl animate-pulse animation-delay-4000"></div>
    </div>

    <div class="relative z-10 min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-2xl glass-effect rounded-3xl shadow-2xl overflow-hidden text-center">
            <!-- Success Icon -->
            <div class="p-12 pb-8">
                <div class="w-24 h-24 bg-gradient-to-r from-green-400 to-emerald-500 rounded-full flex items-center justify-center mx-auto mb-8 shadow-2xl success-animation">
                    <svg class="w-12 h-12 text-white check-animation" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>

                <!-- Success Message -->
                <div class="fade-in">
                    <h1 class="text-4xl font-bold text-white mb-4">
                        🎉 <?php echo htmlspecialchars($greeting); ?>!
                    </h1>
                    <h2 class="text-2xl font-semibold text-white/90 mb-6">
                        Cadastro realizado com sucesso!
                    </h2>
                    <p class="text-lg text-white/80 mb-8 leading-relaxed">
                        <?php if ($isMinor): ?>
                            Como você é menor de idade (<?php echo $age; ?> anos), lembre-se de que algumas funcionalidades podem necessitar da autorização de um responsável.
                        <?php else: ?>
                            Sua conta foi criada com sucesso. Agora você faz parte da nossa comunidade!
                        <?php endif; ?>
                        <br>Seja bem-vindo(a) e aproveite todas as funcionalidades disponíveis.
                    </p>
                </div>

                <!-- Success Stats -->
                <div class="fade-in-delay grid grid-cols-3 gap-4 mb-8">
                    <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-4">
                        <div class="text-2xl font-bold text-white">✅</div>
                        <div class="text-sm text-white/80 mt-1">Dados Validados</div>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-4">
                        <div class="text-2xl font-bold text-white">🔐</div>
                        <div class="text-sm text-white/80 mt-1">Conta Segura</div>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-2xl p-4">
                        <div class="text-2xl font-bold text-white">🚀</div>
                        <div class="text-sm text-white/80 mt-1">Pronto para Usar</div>
                    </div>
                </div>

                <div class="fade-in-delay space-y-4">
                    <a href="index.php" 
                       class="inline-flex items-center space-x-3 bg-white text-gray-800 px-8 py-4 rounded-2xl font-semibold text-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 hover:scale-105 group">
                        <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span>Voltar ao Início</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                const icon = document.querySelector('.success-animation');
                icon.style.animation = 'successPulse 2s ease-in-out infinite';
            }, 1000);
        });
    </script>
</body>
</html>