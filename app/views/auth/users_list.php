<?php require_once '../app/views/layout/header.php'; ?>

<main class="container mx-auto px-6 py-10 flex-grow">
    <div class="mb-8 flex justify-between items-end">
        <div>
            <h1 class="text-4xl font-black text-blue-900 uppercase tracking-tight">Správa uživatelů</h1>
            <p class="text-slate-500 italic mt-2">Přehled všech registrovaných trenérů a administrátorů.</p>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-blue-50 border-b border-blue-100 text-blue-800">
                        <th class="px-6 py-4 font-bold uppercase text-xs tracking-wider">ID</th>
                        <th class="px-6 py-4 font-bold uppercase text-xs tracking-wider">Uživatelské jméno</th>
                        <th class="px-6 py-4 font-bold uppercase text-xs tracking-wider">Jméno a Příjmení</th>
                        <th class="px-6 py-4 font-bold uppercase text-xs tracking-wider">Role</th>
                        <th class="px-6 py-4 font-bold uppercase text-xs tracking-wider text-center">Akce</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php foreach ($users as $u): ?>
                        <tr class="hover:bg-blue-50/50 transition-colors duration-200">
                            <td class="px-6 py-4 text-slate-500 font-mono font-medium">#<?= htmlspecialchars($u['id']) ?></td>
                            <td class="px-6 py-4 font-bold text-slate-800"><?= htmlspecialchars($u['username']) ?></td>
                            <td class="px-6 py-4 text-slate-600">
                                <?= htmlspecialchars($u['first_name'] . ' ' . $u['last_name']) ?>
                                <?php if (!empty($u['nickname'])): ?>
                                    <span class="text-xs text-slate-400 block">„<?= htmlspecialchars($u['nickname']) ?>“</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4">
                                <?php if ($u['is_admin'] == 1): ?>
                                    <span class="bg-amber-100 text-amber-700 px-3 py-1 rounded-md text-[10px] font-black uppercase tracking-widest border border-amber-200">Admin</span>
                                <?php else: ?>
                                    <span class="bg-slate-100 text-slate-600 px-3 py-1 rounded-md text-[10px] font-black uppercase tracking-widest border border-slate-200">Trenér</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <?php if ($u['id'] !== $_SESSION['user_id']): ?>
                                    <a href="<?= BASE_URL ?>/index.php?url=auth/deleteUser/<?= $u['id'] ?>" 
                                       onclick="return confirm('Opravdu chcete nenávratně smazat tohoto uživatele?')" 
                                       class="text-rose-500 hover:text-rose-700 font-bold text-sm transition-colors">Odstranit</a>
                                <?php else: ?>
                                    <span class="text-slate-300 text-sm italic">Aktuální účet</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php require_once '../app/views/layout/footer.php'; ?>