<!DOCTYPE html>
<html lang="cs" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <title>Fotbalová Soupiska</title>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen font-sans flex flex-col selection:bg-blue-500 selection:text-white">

    <header class="bg-gradient-to-r from-blue-900 to-blue-700 shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex flex-col md:flex-row justify-between items-center">
            
            <a href="<?= BASE_URL ?>/index.php" class="flex items-center group">
                <img src="<?= BASE_URL ?>/img/logo.png" alt="Soupiska Logo" 
                     class="h-12 md:h-14 w-auto bg-white px-4 py-2 rounded-xl shadow-sm transition-transform duration-300 group-hover:scale-105 border border-blue-200">
            </a>
            
            <nav class="mt-4 md:mt-0">
                <ul class="flex items-center space-x-6 text-sm uppercase tracking-wider font-bold">
                    <li>
                        <a href="<?= BASE_URL ?>/index.php" class="text-blue-100 hover:text-white transition-colors">Tým</a>
                    </li>

                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li>
                            <a href="<?= BASE_URL ?>/index.php?url=player/create" class="bg-white text-blue-800 hover:bg-blue-50 px-6 py-2.5 rounded-full transition-all shadow-md border border-white">
                                + Nový hráč
                            </a>
                        </li>
                        <li class="text-blue-200 border-l border-blue-500 pl-6 flex items-center">
                            <span class="mr-2">Trenér:</span> 
                            <a href="<?= BASE_URL ?>/index.php?url=auth/profile" class="text-white hover:text-blue-300 transition-colors font-bold flex items-center group">
                                <span class="group-hover:underline"><?= htmlspecialchars($_SESSION['user_name']) ?></span>
                                
                                <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
                                    <span class="ml-2 bg-amber-500 text-white text-[9px] font-black uppercase tracking-widest px-2 py-0.5 rounded-full shadow-md group-hover:bg-amber-600 transition-colors border border-amber-600">
                                        Admin
                                    </span>
                                <?php endif; ?>
                            </a>
                        </li>

                        <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
                            <li>
                                <a href="<?= BASE_URL ?>/index.php?url=auth/users" class="text-amber-400 hover:text-amber-200 uppercase tracking-widest text-xs font-black transition-colors flex items-center">
                                    ⚙️ Správa uživatelů
                                </a>
                            </li>
                        <?php endif; ?>
                        
                        <li>
                            <a href="<?= BASE_URL ?>/index.php?url=auth/logout" class="text-blue-200 hover:text-white transition-colors">
                                Odhlásit
                            </a>
                        </li>

                    <?php else: ?>
                        <li>
                            <a href="<?= BASE_URL ?>/index.php?url=auth/login" class="text-blue-100 hover:text-white transition-colors">Přihlásit</a>
                        </li>
                        <li>
                            <a href="<?= BASE_URL ?>/index.php?url=auth/register" class="bg-blue-800 hover:bg-blue-900 text-white px-6 py-2.5 rounded-full transition-all border border-blue-600">
                                Registrace
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container mx-auto px-6 pt-8">
        <?php if (isset($_SESSION['messages']) && !empty($_SESSION['messages'])): ?>
            <div class="space-y-3 mb-6">
                <?php foreach ($_SESSION['messages'] as $type => $messages): ?>
                    <?php 
                        $styles = [
                            'success' => 'bg-emerald-100 border-emerald-500 text-emerald-800',
                            'error'   => 'bg-rose-100 border-rose-500 text-rose-800',
                            'notice'  => 'bg-amber-100 border-amber-500 text-amber-800',
                        ];
                        $style = $styles[$type] ?? 'bg-blue-100 border-blue-500 text-blue-800';
                    ?>
                    <?php foreach ($messages as $message): ?>
                        <div class="<?= $style ?> border-l-4 p-4 rounded-r-lg shadow-sm">
                            <p class="font-semibold text-sm tracking-wide"><?= htmlspecialchars($message) ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php endforeach; ?>
                <?php unset($_SESSION['messages']); ?>
            </div>
        <?php endif; ?>
    </div>