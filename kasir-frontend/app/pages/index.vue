<template>
  <div class="min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
    <!-- Background Decorations -->
    <div class="absolute inset-0 pointer-events-none">
      <div class="absolute top-1/4 -left-32 w-96 h-96 rounded-full bg-blue-600/15 blur-3xl"></div>
      <div class="absolute bottom-1/4 -right-32 w-96 h-96 rounded-full bg-sky-500/10 blur-3xl"></div>
      <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] rounded-full bg-blue-500/5 blur-3xl"></div>
    </div>

    <!-- Login Card -->
    <div class="glass-card p-6 sm:p-10 w-full max-w-md relative animate-fade-in-up">
      <!-- Logo / Icon -->
      <div class="flex justify-center mb-6">
        <div class="w-16 h-16 flex items-center justify-center">
          <svg class="w-16 h-16" viewBox="0 0 100 100" fill="none">
            <!-- Blue top-right box -->
            <path d="M 56 10 L 88 10 A 4 4 0 0 1 92 14 L 78 54 A 4 4 0 0 1 74 58 L 42 58 A 4 4 0 0 1 38 54 L 52 14 A 4 4 0 0 1 56 10 Z" fill="#2563eb" />
            <path d="M 57 23 L 73 34 L 57 45" stroke="#0f172a" stroke-width="6.5" stroke-linecap="round" stroke-linejoin="round" fill="none" />
            <!-- White bottom-left box -->
            <path d="M 26 42 L 54 42 A 4 4 0 0 1 58 46 L 44 86 A 4 4 0 0 1 40 90 L 12 90 A 4 4 0 0 1 8 86 L 22 46 A 4 4 0 0 1 26 42 Z" fill="#ffffff" />
            <path d="M 41 55 L 25 66 L 41 77" stroke="#0f172a" stroke-width="6.5" stroke-linecap="round" stroke-linejoin="round" fill="none" />
          </svg>
        </div>
      </div>

      <!-- Title -->
      <h1 class="text-2xl font-black text-center mb-0.5 tracking-wider">
        <span class="text-white">CLOU</span><span class="text-blue-500">VIA</span>
      </h1>
      <p class="text-xs text-slate-400 font-bold tracking-widest text-center uppercase mb-8">
        Digital <span class="text-blue-400">Service</span>
      </p>

      <!-- Form -->
      <form @submit.prevent="handleLogin" class="space-y-5">
        <!-- Email -->
        <div class="animate-fade-in-up-delay-1">
          <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">
            Email
          </label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
              <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                  d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
              </svg>
            </div>
            <input
              v-model="form.email"
              type="email"
              placeholder="admin@gmail.com"
              class="input-elegant pl-11"
              required
            />
          </div>
        </div>

        <!-- Password -->
        <div class="animate-fade-in-up-delay-2">
          <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">
            Password
          </label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
              <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                  d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
              </svg>
            </div>
            <input
              v-model="form.password"
              :type="showPassword ? 'text' : 'password'"
              placeholder="••••••••"
              class="input-elegant pl-11 pr-12"
              required
            />
            <button
              type="button"
              @click="showPassword = !showPassword"
              class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-500 hover:text-slate-300 transition-colors"
            >
              <svg v-if="!showPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
              </svg>
              <svg v-else class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                  d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
              </svg>
            </button>
          </div>
        </div>

        <!-- Quick Demo Login Account Selector -->
        <div class="p-3 rounded-xl bg-white/[0.03] border border-white/[0.06] space-y-2">
          <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider text-center">Pilih Akun Demo:</p>
          <div class="grid grid-cols-2 gap-2">
            <button
              type="button"
              @click="quickLogin('admin')"
              class="py-1.5 px-2 rounded-lg text-xs font-semibold bg-blue-500/15 border border-blue-500/25 text-blue-300 hover:bg-blue-500/25 transition-all text-center"
            >
              👑 Admin
            </button>
            <button
              type="button"
              @click="quickLogin('kasir')"
              class="py-1.5 px-2 rounded-lg text-xs font-semibold bg-emerald-500/15 border border-emerald-500/25 text-emerald-300 hover:bg-emerald-500/25 transition-all text-center"
            >
              👤 Kasir User
            </button>
          </div>
        </div>

        <!-- Submit -->
        <button
          type="submit"
          :disabled="isLoading"
          class="btn-primary w-full py-3.5 text-sm tracking-wide mt-2 flex items-center justify-center gap-2"
        >
          <svg v-if="isLoading" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
          {{ isLoading ? 'Memproses...' : 'Masuk Sistem' }}
        </button>
      </form>

      <!-- Footer -->
      <p class="text-xs text-slate-600 text-center mt-8">
        &copy; 2026 POS Kasir Toko &middot; All rights reserved
      </p>
    </div>
  </div>
</template>

<script setup>
const token = useCookie("token");
const role = useCookie("role");
const form = ref({ email: "admin@gmail.com", password: "password" });
const showPassword = ref(false);
const isLoading = ref(false);

onMounted(() => {
  if (token.value) {
    if (role.value === 'kasir') {
      navigateTo("/kasir");
    } else {
      navigateTo("/dashboard");
    }
  }
});

const quickLogin = (type) => {
  if (type === 'admin') {
    form.value.email = 'admin@gmail.com';
    form.value.password = 'password';
  } else {
    form.value.email = 'kasir@gmail.com';
    form.value.password = 'password';
  }
};

const handleLogin = async () => {
  isLoading.value = true;
  try {
    const res = await $fetch("http://localhost/crud-laravel/public/api/login", {
      method: "POST",
      body: form.value,
    });

    token.value = res.token;
    role.value = res.user?.role || 'admin';

    if (role.value === 'kasir') {
      navigateTo("/kasir");
    } else {
      navigateTo("/dashboard");
    }
  } catch (err) {
    const msg = err.data?.message || "Email atau Password salah!";
    alert(msg);
  } finally {
    isLoading.value = false;
  }
};
</script>
