<template>
  <div class="min-h-screen flex flex-col">
    <!-- Navbar -->
    

    <!-- Main Content Area -->
    <main class="flex-grow container mx-auto p-4 text-gray-800">
      <h1 class="text-3xl font-bold text-center mb-6">Manage Your Progress</h1>
      <div class="flex justify-end mb-4">
        <button @click="showAddModal = true" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
          Add New Progression
        </button>
      </div>
      <!-- Progressions List -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <div v-for="item in progressList" :key="item.id" class="bg-white p-4 rounded-lg shadow">
          <h2 class="font-bold text-xl text-green-500">{{ item.title }}</h2>
          <p>{{ item.description }}</p>
          <div class="mt-4 flex justify-between">
            <button @click="editItem(item)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
              Edit
            </button>
            <button @click="deleteItem(item.id)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
              Delete
            </button>
          </div>
        </div>
      </div>
    </main>

    <!-- Add/Edit Modal -->
    <div v-if="showAddModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
      <div class="bg-white p-5 rounded-lg">
        <h2 class="text-xl font-bold mb-4">{{ editing ? 'Edit Progression' : 'Add Progression' }}</h2>
        <form @submit.prevent="handleSubmit">
          <label class="block mb-2">Title:</label>
          <input v-model="formData.title" type="text" placeholder="Title" class="p-2 border rounded w-full mb-4">
          <label class="block mb-2">Weight:</label>
          <input v-model="formData.weight" type="number" placeholder="Weight" class="p-2 border rounded w-full mb-4">
          <label class="block mb-2">Measurements:</label>
          <input v-model="formData.measurements" type="text" placeholder="Measurements" class="p-2 border rounded w-full mb-4">
          <label class="block mb-2">Performance:</label>
          <input v-model="formData.performance" type="text" placeholder="Performance" class="p-2 border rounded w-full mb-4">
          <label class="block mb-2">Status:</label>
          <select v-model="formData.status" class="p-2 border rounded w-full mb-4">
            <option value="Non terminé">Non terminé</option>
            <option value="Terminé">Terminé</option>
          </select>
          <div class="flex justify-between">
            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
              {{ editing ? 'Update' : 'Add' }}
            </button>
            <button @click="showAddModal = false" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
              Cancel
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Footer -->
    <footer class="bg-black text-white p-4 text-center">
      <div class="flex justify-center items-center">
        <span class="text-sm">Follow FitNow@2024
        </span>
      </div>
    </footer>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      progressList: [],
      showAddModal: false,
      formData: {
        title: '',
        weight: '',
        measurements: '',
        performance: '',
        status: 'Non terminé',
        id: ''
      },
      editing: false,
      authToken: localStorage.getItem('authToken') 
    };
  },
  methods: {
    fetchProgressions() {
      axios.get('http://127.0.0.1:8000/api/progress/my-progress', {
        headers: {
        'Authorization': `Bearer ${localStorage.getItem('authToken')}`
      },
    })
    .then(response => {
      this.progressList = response.data.progress;
      console.log(localStorage.getItem('authToken'));

    })
    .catch(error => {
      console.error('Error fetching progressions', error);
      
    });
  },
     
    handleSubmit() {
      const url = this.editing ? `http://127.0.0.1:8000/api/progress/${this.formData.id}` : 'http://127.0.0.1:8000/api/progress';
      const method = this.editing ? 'put' : 'post';
      axios({
        method: method,
        url: url,
        data: this.formData,
        headers: {
          'Authorization': `Bearer ${this.authToken}`
        }
      })
      .then(() => {
        this.fetchProgressions();
        this.showAddModal = false;
        this.resetForm();
      })
      .catch(error => console.error('Failed to submit progression', error));
    },
    editItem(item) {
      this.formData = { ...item };
      this.editing = true;
      this.showAddModal = true;
    },
    deleteItem(id) {
      axios.delete(`http://127.0.0.1:8000/api/progress/${id}`, {
        headers: {
          'Authorization': `Bearer ${this.authToken}`
        }
      })
      .then(() => {
        this.fetchProgressions();
      })
      .catch(error => console.error('Failed to delete progression', error));
    },
    resetForm() {
      this.formData = { title: '', weight: null, measurements: '', performance: '', status: 'Non terminé', id: null };
      this.editing = false;
    },
    logout() {
      localStorage.removeItem('authToken');
      this.$router.push('/login');
    }
  },
  created() {
  if (!localStorage.getItem('authToken')) {
    this.$router.push('/login'); 
  } else {
    this.fetchProgressions();
  }
}

};
</script>