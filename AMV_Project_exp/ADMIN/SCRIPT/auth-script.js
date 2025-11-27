document.addEventListener('DOMContentLoaded', function() {
    const authForm = document.getElementById('authForm');
    const otpInputs = document.querySelectorAll('.otp-input');
    const authButton = document.querySelector('.auth-button');

    // Generate a random 6-digit OTP (demo only)
    let generatedOTP = String(Math.floor(100000 + Math.random() * 900000));

    // Pop up OTP (demo only, replace with SMS/email in real app)
    setTimeout(() => {
        alert("Your One-Time Password (OTP) is: " + generatedOTP);
    }, 500);

    // Focus first input on page load
    otpInputs[0].focus();

    // Handle OTP input functionality
    otpInputs.forEach((input, index) => {
        input.addEventListener('input', function(e) {
            const value = e.target.value;
            if (!/^\d*$/.test(value)) {
                e.target.value = value.replace(/\D/g, '');
                return;
            }
            if (value && index < otpInputs.length - 1) {
                otpInputs[index + 1].focus();
            }
            updateInputState(input, value);
            checkFormCompletion();
        });

        input.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace' && e.target.value === '' && index > 0) {
                otpInputs[index - 1].focus();
            }
            if (e.key === 'ArrowLeft' && index > 0) {
                otpInputs[index - 1].focus();
            }
            if (e.key === 'ArrowRight' && index < otpInputs.length - 1) {
                otpInputs[index + 1].focus();
            }
        });

        input.addEventListener('paste', function(e) {
            e.preventDefault();
            const pastedData = e.clipboardData.getData('text');
            const numbers = pastedData.replace(/\D/g, '').slice(0, 6);
            if (numbers.length === 6) {
                numbers.split('').forEach((num, i) => {
                    if (otpInputs[i]) {
                        otpInputs[i].value = num;
                        updateInputState(otpInputs[i], num);
                    }
                });
                otpInputs[5].focus();
                checkFormCompletion();
            }
        });

        input.addEventListener('focus', function() {
            this.select();
            this.classList.add('focused');
        });

        input.addEventListener('blur', function() {
            this.classList.remove('focused');
        });
    });

    function updateInputState(input, value) {
        if (value) {
            input.classList.add('filled');
            input.classList.remove('error');
        } else {
            input.classList.remove('filled');
        }
    }

    function checkFormCompletion() {
        const allFilled = Array.from(otpInputs).every(input => input.value);
        authButton.disabled = !allFilled;
        authButton.style.opacity = allFilled ? '1' : '0.6';
    }

    function clearInputs() {
        otpInputs.forEach(input => {
            input.value = '';
            input.classList.remove('filled', 'error');
        });
        checkFormCompletion();
        otpInputs[0].focus();
    }

    function showError(message) {
        otpInputs.forEach(input => input.classList.add('error'));
        document.querySelectorAll('.error-message').forEach(error => error.remove());
        
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message';
        errorDiv.style.cssText = `
            color: #ef4444;
            font-size: 0.875rem;
            text-align: center;
            margin-top: 0.5rem;
        `;
        errorDiv.textContent = message;
        document.querySelector('.form-group').appendChild(errorDiv);
    }

    function clearErrors() {
        otpInputs.forEach(input => input.classList.remove('error'));
        document.querySelectorAll('.error-message').forEach(error => error.remove());
    }

    async function verifyOTP(otp) {
        return new Promise((resolve) => {
            setTimeout(() => {
                if (otp === generatedOTP) {
                    resolve({ success: true, message: 'Authentication successful!' });
                } else {
                    resolve({ success: false, message: 'Invalid OTP code. Please try again.' });
                }
            }, 1500);
        });
    }

    authForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        clearErrors();
        const otp = Array.from(otpInputs).map(input => input.value).join('');
        
        if (otp.length !== 6) {
            showError('Please enter the complete 6-digit OTP code.');
            return;
        }

        authButton.classList.add('loading');
        authButton.textContent = 'Verifying...';
        authButton.disabled = true;

        try {
            const result = await verifyOTP(otp);
            if (result.success) {
                authButton.textContent = 'Success!';
                authButton.classList.add('success');
                setTimeout(() => {
                    window.location.href = 'dashboard.php';
                }, 1500);
            } else {
                showError(result.message);
                clearInputs();
                authButton.textContent = 'Login';
                authButton.classList.remove('loading');
                authButton.disabled = false;
            }
        } catch (error) {
            showError('An error occurred. Please try again.');
            authButton.textContent = 'Login';
            authButton.classList.remove('loading');
            authButton.disabled = false;
        }
    });

    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 'v') {
            e.preventDefault();
            otpInputs[0].focus();
        }
        if (e.key === 'Enter' && !authButton.disabled) {
            authForm.dispatchEvent(new Event('submit'));
        }
    });

    checkFormCompletion();
});
