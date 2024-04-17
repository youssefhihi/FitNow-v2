<template>
    <div>
    <div class="min-h-screen flex flex-col justify-center items-center bg-gray-100">
      <div class="max-w-md w-full mx-auto bg-white p-8 rounded-xl border border-gray-300">
        <form @submit.prevent="register" class="space-y-6">
          <h2 class="text-2xl font-semibold text-center text-gray-700">Create Your Free Account</h2>
          <div>
            <label for="name" class="text-sm font-medium text-gray-700">Full Name</label>
            <input type="text" id="name" v-model="name"
                   class="mt-1 w-full p-2 border border-gray-300 rounded-md"placeholder="Fuul name"
                   required>
          </div>
          <div>
            <label for="email" class="text-sm font-medium text-gray-700">Email</label>
            <input type="email" id="email" v-model="email"
                   class="mt-1 w-full p-2 border border-gray-300 rounded-md"
                   placeholder="votreemail@example.com" required>
          </div>  
          <div>
            <label for="password" class="text-sm font-medium text-gray-700">Password</label>
            <input type="password" id="password" v-model="password"
                   class="mt-1 w-full p-2 border border-gray-300 rounded-md"placeholder="enter you password"
                   required>
          </div>
          <div >
            <button type="submit"
                    class="w-1/2 mx-auto flex justify-center py-2 px-4 border border-transparent 
                           rounded-md shadow-sm text-sm font-medium text-white 
                           bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 
                           focus:ring-offset-2 focus:ring-gray-500">
              Create An account
            </button>
          </div>
        </form>
      </div>
    </div>
</div>
  </template>
  
  <script>
import axios from 'axios';

export default {
  data() {
    return {
      name: '',
      email: '',
      password: '',
      errorMessage: '', 
    };
  },
  methods: {
    async register() {
      this.errorMessage = '';

      try {
        const response = await axios.post('http://127.0.0.1:8000/api/auth/register', {
          name: this.name,
          email: this.email,
          password: this.password,
        });
        console.log(response.data); 
        localStorage.setItem('authToken', response.data.access_token);

        this.$router.replace('/home');
        alert('Your account created with success');
      } catch (error) {
        if (error.response && error.response.data) {
          console.error(error.response.data);
          this.errorMessage = error.response.data.message || 'Une erreur est survenue lors de l’inscription.';
        } else {
          this.errorMessage = 'Erreur de réseau ou serveur non disponible.';
        }
      }
    },
  },
};
</script>

  