export default defineNuxtRouteMiddleware((to, from) => {
  const token = useCookie('token');

  // Jika belum login dan mengakses selain halaman login (/), alihkan langsung ke /
  if (!token.value && to.path !== '/') {
    return navigateTo('/');
  }

  // Jika sudah login dan mengakses halaman login (/), alihkan langsung ke /kasir
  if (token.value && to.path === '/') {
    return navigateTo('/kasir');
  }
});
