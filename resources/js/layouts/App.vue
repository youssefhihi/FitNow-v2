<template>
    <div class="container ">
        <nav class="bg-gray-600 text-white p-4 mt-2 w-full">
        <div class=" flex justify-between items-center">
        <a class="text-lg font-bold text-black hover:text-gray-800" href="#">
          FitNow
        </a>
        <router-link to="/home" class="mr-4 text-white hover:text-black text-md">Home</router-link>
        <div>      
            <router-link to="/login" class="mr-4 text-white hover:text-black">Login</router-link>
            <router-link to="/register" class="text-white hover:text-black">Register</router-link>          
        </div>
      </div>
        </nav>
        <router-view></router-view>
    </div>
</template>
