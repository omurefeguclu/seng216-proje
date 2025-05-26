<?php setLayout('_root'); ?>

<style>
    body {
        background-color: #f0f2f5;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .container-box {
        background-color: #ffffff;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        border-radius: 12px;
        padding: 2rem;
        max-width: 900px;
        width: 100%;
        animation: fadeIn 0.6s ease-in;
    }

    .form-section {
        padding: 1rem;
        transition: transform 0.4s ease;
    }

    .form-title {
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 1rem;
        text-align: center;
    }

    .btn-custom {
        width: 100%;
    }

    .alert {
        font-size: 0.9rem;
        padding: 0.5rem;
    }

    .input-group-text {
        background-color: transparent;
        cursor: pointer;
    }

    @keyframes fadeIn {
        from {opacity: 0; transform: scale(0.95);}
        to {opacity: 1; transform: scale(1);}
    }


    .is-valid {
        border-color: #198754 !important;
        box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.25);
    }

    .is-invalid {
        border-color: #dc3545 !important;
        box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
    }
</style>


<div class="container-box">
    <div class="row flex-column flex-md-row">

        <div class="col-md-6 form-section border-end">
            <div class="form-title">Login</div>

            <form id="loginForm" data-ajax-form action="/api/auth/login">
                <div class="alert alert-danger d-flex align-items-center d-none" data-error="div" role="alert">
                    <svg class="bi flex-shrink-0 me-2" role="img"><use xlink:href="#exclamation-triangle-fill"/></svg>
                    <div>
                        An example danger alert with an icon
                    </div>
                </div>
                <div class="mb-3">
                    <label for="loginUsername" class="form-label">Username</label>
                    <input type="text" class="form-control" name="Username" id="loginUsername" data-validate="isRequired('You must enter a username')"
                           data-error-msg="#loginUsernameAlert">
                    <div id="loginUsernameAlert" class="alert alert-danger mt-2 d-none">Passwords do not match.</div>
                </div>
                <div class="mb-3">
                    <label for="loginPassword" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" name="Password" id="loginPassword" data-validate="isRequired('You must enter a password')"
                        data-error-msg="#loginPasswordAlert">
                        <span class="input-group-text toggle-password" data-target="loginPassword">
                            <svg class="bi"><use xlink:href="#eye"></use></svg>
                        </span>
                    </div>
                    <div id="loginPasswordAlert" class="alert alert-danger mt-2 d-none">Passwords do not match.</div>
                </div>
                <button type="submit" class="btn btn-primary btn-custom">Login</button>
            </form>
        </div>


        <div class="col-md-6 form-section">
            <div class="form-title">Register</div>
            <form id="registerForm" data-ajax-form action="/api/auth/register">
                <div class="mb-3">
                    <label for="registerUsername" class="form-label">Username</label>
                    <input type="text" class="form-control" name="Username" id="registerUsername"
                           data-validate="isRequired('You must enter a username')" data-error-msg="#registerUsernameAlert">
                    <div id="registerUsernameAlert" class="alert alert-danger mt-2 d-none">Passwords do not match.</div>
                </div>
                <div class="mb-3">
                    <label for="registerPassword" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" name="Password" class="form-control" id="registerPassword"
                        data-validate="isRequired('You must enter a password')" data-error-msg="#registerPasswordAlert">
                        <span class="input-group-text toggle-password" data-target="registerPassword">
                            <svg class="bi"><use xlink:href="#eye"></use></svg>
                        </span>
                    </div>
                    <div id="registerPasswordAlert" class="alert alert-danger mt-2 d-none">Passwords do not match.</div>
                </div>
                <div class="mb-3">
                    <label for="confirmPassword" class="form-label">Re-enter Password</label>
                    <div class="input-group">
                        <input type="password" name="ConfirmPassword" class="form-control" id="confirmPassword"
                        data-validate="isRequired('You must confirm your password') && isMatching('#registerPassword', 'Passwords are not matching')"
                        data-error-msg="#confirmPasswordAlert">
                        <span class="input-group-text toggle-password" data-target="confirmPassword">
                            <svg class="bi"><use xlink:href="#eye"></use></svg>
                        </span>
                    </div>
                    <div id="confirmaPasswordAlert" class="alert alert-danger mt-2 d-none">Passwords do not match.</div>
                </div>
                <button type="submit" class="btn btn-success btn-custom">Register</button>
            </form>
        </div>
    </div>
</div>


<?php
$viewEngine->startCustomScripts();
?>
<script>
    const registerForm = document.getElementById("registerForm");
    const loginForm = document.getElementById("loginForm");

    document.querySelectorAll(".toggle-password").forEach(toggle => {
        toggle.addEventListener("click", () => {
            const targetId = toggle.getAttribute("data-target");
            const input = document.getElementById(targetId);
            const icon = toggle.querySelector("svg > use");

            if (input.type === "password") {
                input.type = "text";
                icon.setAttribute("xlink:href", "#eye-slash");
            } else {
                input.type = "password";
                icon.setAttribute("xlink:href", "#eye");
            }

        });
    });

    loginForm.addEventListener('ajaxSubmitCompleted', function (e) {
        const response = e.detail;

        console.log('login ajax submit completed:', response);

        window.location.replace('/');
    });
    registerForm.addEventListener('ajaxSubmitCompleted', function (e) {
        const response = e.detail;

        console.log('register ajax submit completed:', response);

        window.location.replace('/');
    });
</script>
<?php
$viewEngine->endCustomScripts();
?>
