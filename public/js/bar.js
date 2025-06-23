document.getElementById("logout").addEventListener("click", function (e) {
    e.preventDefault();
    fetch("/api/logout", {
        method: "POST",
        headers: {
            Authorization: "Bearer " + localStorage.getItem("jwt_token"),
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
        },
    })
        .then((res) => res.json())
        .then((data) => {
            if (data.status === "success") {
                localStorage.removeItem("jwt_token");
                window.location.href = "/login";
            } else {
                alert("Logout failed");
            }
        });
});
