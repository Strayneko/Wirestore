import './bootstrap';
import { initFlowbite } from "flowbite";
import 'flowbite';
import Swal from "sweetalert2";


document.addEventListener("livewire:navigating", () => {
    // Mutate the HTML before the page is navigated away...
    initFlowbite();
});

document.addEventListener("livewire:navigated", () => {
    // Reinitialize Flowbite components
    initFlowbite();
});

document.addEventListener('swal:message', (e) => {
    Swal.fire({
        title: e.detail.title || 'Congratulations!',
        text: e.detail.message,
        icon: e.detail.type || 'success',
    });
})
