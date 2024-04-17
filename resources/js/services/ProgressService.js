// src/services/ProgressService.js

import axios from 'axios';

const baseURL = 'http://votre-api.com/api'; // Remplacez par l'URL de base de votre API

export default {
  getProgresses() {
    return axios.get(`${baseURL}/progresses`);
  },
  createProgress(progressData) {
    return axios.post(`${baseURL}/progresses`, progressData);
  },
  updateProgress(id, progressData) {
    return axios.put(`${baseURL}/progresses/${id}`, progressData);
  },
  deleteProgress(id) {
    return axios.delete(`${baseURL}/progresses/${id}`);
  },
};
