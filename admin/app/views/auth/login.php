<div class="w-full max-w-md relative">

    <!-- Studio Identity — matches navbar exactly -->
    <div class="text-center mb-7">
        <div class="inline-flex flex-col items-center leading-tight mb-4">
            <span class="font-heading flex items-end gap-1 leading-none" style="color:#5c3d2e;">
                <span class="text-sm font-body font-medium uppercase tracking-[0.2em]">The</span>
                <span class="text-3xl font-semibold">Clayo</span>
            </span>
            <span class="text-[11px] tracking-[0.35em] uppercase font-medium mt-1" style="color:#b8935a;">
                Pottery Studio
            </span>
        </div>

        <h1 class="font-heading text-xl font-semibold" style="color:#2c2420;">Welcome back</h1>
    </div>

    <!-- Login Card -->
    <div class="rounded-2xl border p-8 shadow-warm"
         style="background:#ffffff; border-color:#e8ddd5;">

        <!-- Error alert -->
        <?php if (!empty($error)): ?>
            <div class="mb-6 rounded-xl border px-4 py-3 text-sm flex items-center gap-2.5"
                 style="background:#fdf2ef; border-color:#e8a090; color:#a8503a;">
                <i data-lucide="alert-circle" class="w-4 h-4 flex-shrink-0"></i>
                <span><?= e($error) ?></span>
            </div>
        <?php endif; ?>

        <form action="<?= e(url('/login')) ?>" method="POST" class="space-y-5" autocomplete="on">
            <?= csrf_field() ?>

            <!-- Email field -->
            <div>
                <label for="email"
                       class="block text-[11px] font-semibold uppercase tracking-widest mb-2 font-body"
                       style="color:#5c3d2e;">
                    Email address
                </label>
                <div class="relative">
                    <i data-lucide="mail"
                       class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 pointer-events-none"
                       style="color:#b8935a;"></i>
                    <input id="email" name="email" type="email" required autofocus
                           value="<?= e($email ?? '') ?>"
                           placeholder="you@studio.com"
                           class="w-full rounded-xl pl-11 pr-4 py-3 text-sm font-body transition-all duration-200"
                           style="background:#faf7f2; border:1.5px solid #ddd0c5; color:#2c2420; outline:none;"
                           onfocus="this.style.borderColor='#b8935a'; this.style.boxShadow='0 0 0 3px rgba(184,147,90,0.15)'"
                           onblur="this.style.borderColor='#ddd0c5'; this.style.boxShadow='none'">
                </div>
            </div>

            <!-- Password field with toggle -->
            <div>
                <label for="password"
                       class="block text-[11px] font-semibold uppercase tracking-widest mb-2 font-body"
                       style="color:#5c3d2e;">
                    Password
                </label>
                <div class="relative">
                    <i data-lucide="lock"
                       class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 pointer-events-none"
                       style="color:#b8935a;"></i>
                    <input id="password" name="password" type="password" required
                           placeholder="••••••••"
                           class="w-full rounded-xl pl-11 pr-12 py-3 text-sm font-body transition-all duration-200"
                           style="background:#faf7f2; border:1.5px solid #ddd0c5; color:#2c2420; outline:none;"
                           onfocus="this.style.borderColor='#b8935a'; this.style.boxShadow='0 0 0 3px rgba(184,147,90,0.15)'"
                           onblur="this.style.borderColor='#ddd0c5'; this.style.boxShadow='none'">
                    <!-- Show / hide toggle -->
                    <button type="button"
                            id="pwd-toggle"
                            aria-label="Toggle password visibility"
                            onclick="togglePassword()"
                            class="absolute right-3.5 top-1/2 -translate-y-1/2 p-1 rounded-lg transition-colors duration-150 focus:outline-none"
                            style="color:#8a7a70;"
                            onmouseover="this.style.color='#b8935a'"
                            onmouseout="this.style.color='#8a7a70'">
                        <i data-lucide="eye" id="pwd-icon-show" class="w-4 h-4"></i>
                        <i data-lucide="eye-off" id="pwd-icon-hide" class="w-4 h-4 hidden"></i>
                    </button>
                </div>
            </div>

            <!-- Submit button -->
            <button type="submit"
                    class="w-full text-white font-semibold py-3 rounded-xl transition-all duration-200 font-body inline-flex items-center justify-center gap-2 mt-1 shadow-card"
                    style="background: linear-gradient(135deg, #c1654a 0%, #b8935a 100%); letter-spacing:0.01em;"
                    onmouseover="this.style.background='linear-gradient(135deg, #a8503a 0%, #9a7340 100%)'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 6px 20px -4px rgba(193,101,74,0.45)'"
                    onmouseout="this.style.background='linear-gradient(135deg, #c1654a 0%, #b8935a 100%)'; this.style.transform='translateY(0)'; this.style.boxShadow=''">
                <span>Sign in</span>
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </button>
        </form>
    </div>

    <!-- Footer -->
    <p class="text-center text-xs mt-6 font-body" style="color:#8a7a70;">
        &copy; <?= date('Y') ?> The Clayo Pottery Studio &nbsp;&middot;&nbsp; Admin Console
    </p>
</div>

<script>
    function togglePassword() {
        const input = document.getElementById('password');
        const iconShow = document.getElementById('pwd-icon-show');
        const iconHide = document.getElementById('pwd-icon-hide');

        if (input.type === 'password') {
            input.type = 'text';
            iconShow.classList.add('hidden');
            iconHide.classList.remove('hidden');
        } else {
            input.type = 'password';
            iconShow.classList.remove('hidden');
            iconHide.classList.add('hidden');
        }
    }
</script>
