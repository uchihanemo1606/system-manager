export function closeModal() {
    $("#modalContainer").modal("hide");
    return;
    const modalEl = document.getElementById("modalContainer");
    if (!modalEl) return;

    const modalInstance =
        bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
    modalInstance.hide();
}
