$(function(){
    // The sliding action of the login box
    const signUpButton = document.getElementById('signUp');
    const signInButton = document.getElementById('signIn');
    const container = document.getElementById('login_container');
    
    console.log(signUpButton, signInButton, container);
    
    signUpButton.addEventListener('click', () => {
        container.classList.add("right-panel-active");
    });
    
    signInButton.addEventListener('click', () => {
        container.classList.remove("right-panel-active");
    });


    // Handle the submission of registration or login
    $('form').on("submit", function(e){
        e.preventDefault();
        console.log($(this).serializeArray(), $(this).attr('id'));

        let form = $(this);
        if($(this).attr('id') == "form_login"){            
            $.ajax({
                url: 'login',
                type: 'post',
                data: $(this).serializeArray(),
                dataType: 'json',
                success: function (data) {
                    // history.back();
                    if(data.status == "error"){
                        console.log(data.message, "failed");
                        $('.err_message', form).html('Error: '+data.message).show();
                        $('input', form).addClass('error');
                    }
                    else {
                        $('.err_message', form).hide();
                        $('input', form).removeClass('error');
                        history.back();
                    }
                },

            })
            .fail(function(data){
                console.log("failed login", data);
            });
        }

        if($(this).attr('id') == "form_register"){            
            $.ajax({
                url: 'register',
                type: 'post',
                data: $(this).serializeArray(),
                dataType: 'json',
                success: function (data) {
                    if(data.status == "error"){
                        console.log(data.message, "failed");
                        $('.err_message', form).html('Error: '+data.message).show();
                        $('input', form).addClass('error');
                    }
                    else {
                        $('.err_message', form).hide();
                        $('input', form).removeClass('error');
                        
                        // Simulate click and have them login
                        signInButton.click();

                        // Create message box and show
                        messagebox('Thanks for registering. Login!');
                        // $('.message-box').html('Thanks for registering. Login!').fadeIn();
                        // setTimeout(() => {
                        //     $('.message-box').fadeOut();
                        // }, "2000")
                    }
                }
            });
        }
    });

});
