import axios from "axios";

window.axios = axios;

document.addEventListener('livewire:initialized', () => {
    Livewire.on('reset-search', () => {
    });
});
