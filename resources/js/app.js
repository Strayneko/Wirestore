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


/**
 * ===============
 * Sweetalert 2
 * ===============
 */
document.addEventListener('swal:message', (e) => {
    Swal.fire({
        title: e.detail.title || 'Congratulations!',
        text: e.detail.message,
        icon: e.detail.type || 'success',
    });
})


document.addEventListener('swal:confirmation', (e) => {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        cancelButtonColor: "#3085d6",
        confirmButtonColor: "#d33",
        confirmButtonText: "Delete"
      }).then((result) => {
        if(!result.isConfirmed) return;

        Livewire.dispatch(e.detail.eventDispatchName, {slug: e.detail.slug})
      });
})
