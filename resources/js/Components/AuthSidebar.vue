<template>
  <transition name="slide">
    <div v-if="isOpen" class="fixed top-0 right-0 w-80 h-full bg-white shadow-lg z-50 p-6">
      <!-- Close Button -->
      <button @click="closeSidebar" class="absolute top-4 right-4 text-gray-600 hover:text-gray-800">
        ✖
      </button>

      <!-- Tabs: Login & Register -->
      <div class="flex justify-between border-b pb-2 mb-4">
        <button
            @click="activeTab = 'login'"
            :class="activeTab === 'login' ? 'border-b-2 border-black font-bold' : 'text-gray-500'"
            class="w-1/2 text-center pb-2"
        >
          Inloggen
        </button>
        <button
            @click="activeTab = 'register'"
            :class="activeTab === 'register' ? 'border-b-2 border-black font-bold' : 'text-gray-500'"
            class="w-1/2 text-center pb-2"
        >
          Registreren
        </button>
      </div>

      <!-- Login Form -->
      <div v-if="activeTab === 'login'">
        <h2 class="text-lg font-bold mb-4">Log in</h2>
        <form @submit.prevent="login.post(route('login'))">
          <input v-model="login.email" type="email" placeholder="E-mail" class="w-full p-2 mb-2 border rounded" required>
          <div v-if="login.errors.email" class="text-red-500 text-sm">{{ login.errors.email }}</div>

          <input v-model="login.password" type="password" placeholder="Wachtwoord" class="w-full p-2 mb-2 border rounded" required>
          <div v-if="login.errors.password" class="text-red-500 text-sm">{{ login.errors.password }}</div>

          <button :disabled="login.processing" class="w-full bg-black text-white py-2 rounded">
            {{ login.processing ? "Inloggen..." : "Inloggen" }}
          </button>
        </form>
      </div>

      <!-- Register Form -->
      <div v-if="activeTab === 'register'">
        <h2 class="text-lg font-bold mb-4">Registreren</h2>
        <form @submit.prevent="register.post(route('register.store'))">
          <input v-model="register.firstname" type="text" placeholder="Voornaam" class="w-full p-2 mb-2 border rounded" required>
          <div v-if="register.errors.firstname" class="text-red-500 text-sm">{{ register.errors.firstname }}</div>

          <input v-model="register.lastname" type="text" placeholder="Achternaam" class="w-full p-2 mb-2 border rounded" required>
          <div v-if="register.errors.lastname" class="text-red-500 text-sm">{{ register.errors.lastname }}</div>

          <input v-model="register.email" type="email" placeholder="E-mail" class="w-full p-2 mb-2 border rounded" required>
          <div v-if="register.errors.email" class="text-red-500 text-sm">{{ register.errors.email }}</div>

          <input v-model="register.password" type="password" placeholder="Wachtwoord" class="w-full p-2 mb-2 border rounded" required>
          <div v-if="register.errors.password" class="text-red-500 text-sm">{{ register.errors.password }}</div>

          <input v-model="register.password_confirmation" type="password" placeholder="Bevestig wachtwoord" class="w-full p-2 mb-2 border rounded" required>
          <div v-if="register.errors.password_confirmation" class="text-red-500 text-sm">{{ register.errors.password_confirmation }}</div>

          <button :disabled="register.processing" class="w-full bg-black text-white py-2 rounded">
            {{ register.processing ? "Registreren..." : "Registreren" }}
          </button>
        </form>
      </div>

      <!-- Logged-in View -->
      <div v-if="user">
        <p class="mb-2">Hallo, {{ user.firstname }}!</p>
        <Link :href="route('home')" class="block text-blue-600">Mijn account</Link>
        <form @submit.prevent="logout">
          <button class="mt-4 bg-red-500 text-white py-2 px-4 rounded">Uitloggen</button>
        </form>
      </div>
    </div>
  </transition>
</template>

<script setup>
import {ref} from "vue";
import {Link, usePage, useForm} from "@inertiajs/vue3";

const isOpen = ref(false);
const activeTab = ref("login"); // Default tab is "Login"
const page = usePage();
const user = page.props.auth.user || null;

const login = useForm({
  email: "",
  password: "",
});

const register = useForm({
  firstname: "",
  lastname: "",
  email: "",
  password: "",
  password_confirmation: '',
});

const logout = () => {
  axios.post(route("logout")).then(() => window.location.reload());
};

const openSidebar = () => (isOpen.value = true);
const closeSidebar = () => (isOpen.value = false);

defineExpose({openSidebar});
</script>

<style>
/* Slide animation */
.slide-enter-active, .slide-leave-active {
  transition: transform 0.3s ease-in-out;
}

.slide-enter-from, .slide-leave-to {
  transform: translateX(100%);
}
</style>
