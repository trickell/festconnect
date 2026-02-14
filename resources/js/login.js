$(function () {
    // The sliding action of the login box
    const signUpButton = document.getElementById('signUp');
    const signInButton = document.getElementById('signIn');
    const container = document.getElementById('login_container');

    if (signUpButton && signInButton && container) {
        signUpButton.addEventListener('click', () => {
            container.classList.add("right-panel-active");
        });

        signInButton.addEventListener('click', () => {
            container.classList.remove("right-panel-active");
        });
    }

    // Handle the submission of registration or login
    $('#form_login, #form_register').on("submit", function (e) {
        e.preventDefault();
        console.log($(this).serializeArray(), $(this).attr('id'));

        let form = $(this);
        let url = $(this).attr('id') == "form_login" ? '/login' : '/register'; // Fixed URL to be relative to root or named route if possible, but hardcoded for now matches existing logic roughly

        $.ajax({
            url: url,
            type: 'post',
            data: $(this).serializeArray(),
            dataType: 'json',
            success: function (data) {
                if (data.status == "error") {
                    console.log(data.message, "failed");
                    $('.err_message', form).html('Error: ' + data.message).show();
                    $('input', form).addClass('error');
                }
                else {
                    $('.err_message', form).hide();
                    $('input', form).removeClass('error');

                    if (url == '/register') {
                        // Simulate click and have them login
                        if (signInButton) signInButton.click();
                        alert('Thanks for registering. Please Login!');
                    } else {
                        // If we are on the /login page, go to home
                        // If we are on another page (like /reconnections) serving the login view, reload to show content
                        if (window.location.pathname === '/login') {
                            window.location.href = "/";
                        } else {
                            window.location.reload();
                        }
                    }
                }
            },
            error: function (data) {
                console.log("failed request", data);
                $('.err_message', form).html('Error: Request failed').show();
            }
        });
    });

});
