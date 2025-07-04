console.log('Forgot Password JS Loaded');
document.addEventListener('DOMContentLoaded', function () {
    const step1 = document.getElementById('step1');
    const step2 = document.getElementById('step2');
    const step3 = document.getElementById('step3');
    const errorDiv = document.getElementById('error');
    const successDiv = document.getElementById('success');
    let email = '';

    step1.addEventListener('submit', function (e) {
        e.preventDefault();
        errorDiv.textContent = '';
        successDiv.textContent = '';
        email = document.getElementById('email').value;

        fetch('/sendotpresetpassword?email=' + encodeURIComponent(email))
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    successDiv.textContent = data.message;
                    step1.style.display = 'none';
                    step2.style.display = 'block';
                } else {
                    errorDiv.textContent = data.message;
                }
            })
            .catch(err => {
                console.error(err);
                errorDiv.textContent = 'Đã xảy ra lỗi. Vui lòng thử lại.';
            });
    });

    step2.addEventListener('submit', function (e) {
        e.preventDefault();
        errorDiv.textContent = '';
        successDiv.textContent = '';
        const otp = document.getElementById('otp').value;

        fetch('/verifyotpresetpassword', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value },
            body: JSON.stringify({ email, otp })
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    successDiv.textContent = data.message;
                    step2.style.display = 'none';
                    step3.style.display = 'block';
                } else {
                    errorDiv.textContent = data.message;
                }
            })
            .catch(err => {
                console.error(err);
                errorDiv.textContent = 'Đã xảy ra lỗi. Vui lòng thử lại.';
            });
    });

    step3.addEventListener('submit', function (e) {
        e.preventDefault();
        errorDiv.textContent = '';
        successDiv.textContent = '';

        const password = document.getElementById('password').value;
        const password_confirmation = document.getElementById('password_confirmation').value;

        fetch('/resetpassword', {
            method: 'PATCH',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value },
            body: JSON.stringify({ email, password, password_confirmation })
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    successDiv.textContent = data.message + ' Bạn sẽ được chuyển về trang đăng nhập sau 3 giây.';
                    setTimeout(() => window.location.href = '/login', 3000);
                } else {
                    errorDiv.textContent = data.message;
                }
            })
            .catch(err => {
                console.error(err);
                errorDiv.textContent = 'Đã xảy ra lỗi. Vui lòng thử lại.';
            });
    });
});
