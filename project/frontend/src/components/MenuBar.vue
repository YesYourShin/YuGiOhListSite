<template>
  <div class="navbar bg-base-100">
    <div class="flex-1">
      <router-link to="/">
        <a class="flex items-center">
          <img src="../assets/yugioh-dark-magician-girl.png" class="mr-3 h-6 sm:h-9" alt="black_magic_girl" />
          <!-- <a class="btn btn-ghost normal-case text-xl">daisyUI</a> -->
          <span class="btn btn-ghost normal-case text-xl">YuGiOh Card Management</span>
        </a>
      </router-link>
    </div>
    <div class="flex-none">
      <ul class="menu menu-horizontal p-0">
        <li>
          <a><router-link to="/card">Card</router-link></a>
        </li>
        <li>
          <a><router-link to="/mycard">MyCard</router-link></a>
        </li>
      </ul>
    </div>
    <div v-if="this.$store.state.userStore.token" class="dropdown dropdown-end">
      <label tabindex="0" class="btn btn-ghost btn-circle avatar">
        <div class="w-10 rounded-full">
          <img src="../assets/evil_twin_Ki-sikil.jpg" />
        </div>
      </label>
      <ul tabindex="0" class="mt-3 p-2 shadow menu menu-compact dropdown-content bg-base-100 rounded-box w-52">
        <li><a>Settings</a></li>
        <li><a @click="logout">Logout</a></li>
      </ul>
    </div>
    <div v-else class="dropdown dropdown-end">
      <label tabindex="0" class="btn btn-ghost btn-circle avatar">
        <div class="w-10 rounded-full">
          <img src="../assets/yugioh_icon.png" />
        </div>
      </label>
      <ul tabindex="0" class="mt-3 p-2 shadow menu menu-compact dropdown-content bg-base-100 rounded-box w-52">
        <li><a>Settings</a></li>
        <li><a @click="login">Login</a></li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  methods: {
    login() {
      this.$router.push({ path: '/login' });
    },
    logout() {
      this.$store.commit('logout');
    },
  },
};
</script>
