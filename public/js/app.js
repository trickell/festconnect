// import './bootstrap';

const today = new Date();

// Stores the logged in user in a local js variable for js code to access
const store_user = function(){
    $.get('/get_user')
        .done(function(data){            
            sessionStorage.setItem('user', data);
        });
}

// This creates a messagebox of text as long as a div with class='message_box' exists in the body
function messagebox(text){
    $('.message-box').html(text).fadeIn();
    setTimeout(() => {
        $('.message-box').fadeOut();
    }, 2000);
}

// Handles the filters for the filter select
function filter_posts(filter, type){
    console.log(filter,type);
    switch(type){
        case "festival":
            console.log($('.post-container'));
            $('.post-container').hide();
            $('div[data-filter="'+ filter +'"]').fadeIn();
            break;

        case "reset":
            $('.post-container').show();
            $('select[name="festival"]').val("0");
            break;
    }
}

// Formats a date for Website use.
function formatDate(date){
    if(date === null){ return "N/A"; }
    date = new Date(date);
    return date.toLocaleDateString('en-US', {year: 'numeric', month: 'long', day: 'numeric'});
}

// Define a method for grabbing the csrf token
function getCSRFToken(){
    return $('#cstoken').val();
}

$(function(){
    // Store User
    store_user();
    const user = JSON.parse(sessionStorage.getItem('user')).user;

    // Take care of the click events on the missed connections pages
    $(".submitMissedConnections").click(function(){
        $("#rec_landing").hide();
        $("#rec_posts").hide();
        $("#rec_form").fadeIn(1000);
    });

    // Handle the form submission for missed connection posts
    $("#missed_connection_form").submit(function(e){
        e.preventDefault();
        console.log("Form Submitted!");
        console.log($(this).serializeArray());

        // Make sure the form is reading the correctid. 
        $('input[name="user_id"]', form).val(user.id);
        // $.post("submit_post", $(this).serializeArray(), function(data){
        //     console.log(data);
        // });
        $.ajaxSetup({
            beforeSend: function() {
               $('.loader').show();
            },
            complete: function(){},
            success: function() {}
          });
        $.ajax({
            url: 'submit_post',
            type: 'post',
            data: $(this).serializeArray(),
            dataType: 'json',
            success: function (data) {
                console.info(data);
                $('.loader').hide()
                $(".formSubmittedBtn").click();
            }
        });
    });

    // Define variables needed for viewing posts
    let postCount = 0;
    let posts = [];

    // Define a method for submitting a comment
    function subComment(postId, userId, comment){
        console.log("Submitting Comment for Post: "+postId+" with userid: "+userId);
        console.log("Comment: "+comment);
    
        $.ajax({
            url: 'submit_comment',
            type: 'post',
            data: {_token: getCSRFToken, post_id: postId, user_id: userId,
                  comment: comment },
            dataType: 'json',
            success: function (data) {
                console.info(data);
                let c = data.comment_data;
                $("#comments_"+c.post_id).append(`
                    <div id="comm_`+ data.comment_id +`" class="flex flex-col text-base p-1 m-1 bg-sky-600/50 rounded-md">
                        <div class="flex flex-row">
                            <div class="flex flex-row p-1 text-slate-100">
                                <h3 class="text-lg font-bold p-1">`+ user.username 
                                +`<br/><span class="italic text-xs text-slate-500">`+ formatDate(today) +`</span></h3>
                                <p class="text-base p-1">`+ c.comment +`</p>
                            </div>
                        </div>
                    </div>
                `);
                messagebox('Thanks for your comment!');

                // Show comments and Scroll to new comment element
                $("#comments_"+c.post_id).show();
                $('html, body').animate({
                    scrollTop: $("#comments_"+c.post_id+" :last-child").offset().top + 10
                }, 2000);                
            }
        });
    }

    // Handle the loading of posts
    $(".viewMissedConnections, .formSubmittedBtn").click(function(){
        // Handle graphical events
        $("#rec_landing").hide();
        $("#rec_form").hide();
        $("#rec_posts").fadeIn(1000);

        // Handle the fetching of posts
        $.ajax({
            url: 'get_posts',
            type: 'get',
            dataType: 'json',
            success: function (data) {
                console.info(data);
                posts = data;

                // check if the data has already been appended once
                
                if(postCount == 0){
                
                $.each(posts, function(index, val){    
                    // Checks the the post is turned off in DB, returns if so
                    if (val.turn_off == 1){ return; }
                    // Checks if an image for the posts exists
                    if (!val.image) { val.image = "/img/no-image.png" }
                    
                    $("#rec_posts .body").append(`
                        <div class="flex flex-col post-container" data-filter="`+ val.festival +`">
                            <a href="#" class="flex flex-container flex-col">
                                <div class="flex flex-col text-xl border-solid rounded-md border-2 text-gray-600 dark:text-gray-400 hover:text-red-400 p-5 m-2 hover:bg-slate-900/80">
                                    <div class="flex flex-container text-sm font-bold p-1 text-right justify-end">Posted on: `+ new Date(val.created_at).toDateString() +`</div>
                                    <div class="flex flex-col xl:flex-row">
                                        <div class="px-3">
                                            <img src=`+ val.image +` alt="Post Image" class="w-28 h-28">
                                        </div>
                                        <div class="text-left">
                                            <h3 class="text-xl font-bold p-1">Festival: <span class="festcolors">`+ val.festival +`</span></h3>
                                            <h3 class="text-lg font-bold p-1"><span class="festcolors">`+ val.user.username +`</span> is looking for this missed connection: `+ val.missed_conn +`</h3>
                                            <p class="text-base p-5">`+ val.post +`</p>
                                        </div>      
                                    </div>     
                                    <div id="comment_events" class="flex flex-col text-base justify-end border-b-2 border-slate-800 mb-5">
                                        <div class="flex flex-row p-1 ">
                                            <button id="v_comments" data-id="`+ val.id +`" class="flex flex-row p-2 m-2 bg-violet-900/50 rounded-md hover:bg-violet-900/80">
                                                <a href="/reconnections" class="text-slate-50 dark:text-gray-400 hover:text-red-400">View Comments</a>
                                            </button>
                                            <button id="s_comments" data-id="`+ val.id +`" class="flex flex-row p-2 m-2 bg-violet-900/50 rounded-md hover:bg-violet-900/80">
                                                <a href="/reconnections" class="text-slate-50 dark:text-gray-400 hover:text-red-400">Submit a Comment</a>
                                            </button>
                                            <button id="connect_w_user" data-id="`+ val.id +`" class="flex flex-row p-2 m-2 bg-violet-900/50 rounded-md hover:bg-violet-900/80">
                                                <a href="/reconnections" class="flex flex-row text-slate-50 dark:text-gray-400 hover:text-red-400">
                                                <svg class="text-slate-300" width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M10.5766 8.70419C11.2099 7.56806 11.5266 7 12 7C12.4734 7 12.7901 7.56806 13.4234 8.70419L13.5873 8.99812C13.7672 9.32097 13.8572 9.48239 13.9975 9.5889C14.1378 9.69541 14.3126 9.73495 14.6621 9.81402L14.9802 9.88601C16.2101 10.1643 16.825 10.3034 16.9713 10.7739C17.1176 11.2443 16.6984 11.7345 15.86 12.715L15.643 12.9686C15.4048 13.2472 15.2857 13.3865 15.2321 13.5589C15.1785 13.7312 15.1965 13.9171 15.2325 14.2888L15.2653 14.6272C15.3921 15.9353 15.4554 16.5894 15.0724 16.8801C14.6894 17.1709 14.1137 16.9058 12.9622 16.3756L12.6643 16.2384C12.337 16.0878 12.1734 16.0124 12 16.0124C11.8266 16.0124 11.663 16.0878 11.3357 16.2384L11.0378 16.3756C9.88634 16.9058 9.31059 17.1709 8.92757 16.8801C8.54456 16.5894 8.60794 15.9353 8.7347 14.6272L8.76749 14.2888C8.80351 13.9171 8.82152 13.7312 8.76793 13.5589C8.71434 13.3865 8.59521 13.2472 8.35696 12.9686L8.14005 12.715C7.30162 11.7345 6.88241 11.2443 7.02871 10.7739C7.17501 10.3034 7.78993 10.1643 9.01977 9.88601L9.33794 9.81402C9.68743 9.73495 9.86217 9.69541 10.0025 9.5889C10.1428 9.48239 10.2328 9.32097 10.4127 8.99812L10.5766 8.70419Z" stroke="#1482f7" stroke-width="1.5"/>
                                                <path opacity="0.5" d="M12 2V4" stroke="#3030ff" stroke-width="1.5" stroke-linecap="round"/>
                                                <path opacity="0.5" d="M12 20V22" stroke="#996eff" stroke-width="1.5" stroke-linecap="round"/>
                                                <path opacity="0.5" d="M2 12L4 12" stroke="#3030ff" stroke-width="1.5" stroke-linecap="round"/>
                                                <path opacity="0.5" d="M20 12L22 12" stroke="#996eff" stroke-width="1.5" stroke-linecap="round"/>
                                                <path d="M6 18L6.34305 17.657" stroke="#3030ff" stroke-width="1.5" stroke-linecap="round"/>
                                                <path d="M17.6567 6.34326L18 6" stroke="#996eff" stroke-width="1.5" stroke-linecap="round"/>
                                                <path d="M18 18L17.657 17.657" stroke="#996eff" stroke-width="1.5" stroke-linecap="round"/>
                                                <path d="M6.34326 6.34326L6 6" stroke="#3030ff" stroke-width="1.5" stroke-linecap="round"/>
                                                </svg>
                                                Connect with a user</a>
                                            </button>
                                        </div>
                                        <div id="submit_comment_`+ val.id +`" class="flex flex-col p-1 hidden">
                                            <form id="comment_form" class="flex flex-row p-1">
                                                <input type="hidden" name="user_id" value="`+ user.id +`">
                                                <input type="hidden" name="post_id" value="`+ val.id +`">
                                                <input type="text" name="comment" class="p-2 ml-4 rounded-sm w-5/6" placeholder="Submit a Comment">
                                                <button id="sub_comment" data-id="`+ val.id +`" class="p-2 m-2 w-1/6 bg-violet-900/50 rounded-md hover:bg-violet-900/80">Comment</button>
                                            </form>
                                        </div>
                                    </div>
                                    <div id="comments_`+ val.id +`" class="flex flex-row text-base hidden">                              
                                    </div>
                                </div>
                            </a>
                        </div>
                    `);
                    // Add comments to the post
                    $.get( "get_comments/"+val.id, function( comments ) {
                        // Log it
                        console.log(comments)
                        if(comments){
                            $.each(JSON.parse(comments), function(index, c){
                                if(c.parent === null){
                                    $("#comments_"+val.id).append(`
                                        <div id="comm_`+ c.id +`" class="flex flex-col text-base p-1 m-1 bg-sky-600/50 rounded-md">
                                            <div class="flex flex-row">
                                                <div class="flex flex-row p-1 text-slate-100">
                                                    <h3 class="text-lg font-bold p-1">`+ c.username 
                                                    +`<br/><span class="italic text-xs text-slate-500">`+ formatDate(c.created_at) +`</span></h3>
                                                    <p class="text-base p-1">`+ c.comment +`</p>
                                                </div>
                                            </div>
                                        </div>
                                    `);
                                }
                                else {
                                    $("#comm_"+c.parent).append(`
                                        <div id="comm_`+ c.id +`" class="flex flex-col text-base p-1 m-1 bg-sky-600/50 rounded-md">
                                            <div class="flex flex-row">
                                                <div class="flex flex-row p-1 text-sky-300">
                                                    <h3 class="text-lg font-bold p-1">`+ c.user 
                                                    +`<br/><span class="italic text-sm">`+ formatDate(c.created_at) +`</span></h3>
                                                    <p class="text-base p-1">`+ c.comment +`</p>
                                                </div>
                                            </div>
                                        </div>
                                    `);
                                }
                            });
                        }
                        else {
                            $("#comments_"+val.id).append(`
                                <div class="flex flex-row text-base p-1 m-1 bg-sky-600/50 rounded-md">
                                    <div class="flex flex-row p-1">
                                        <p class="text-base p-1"><i>No comments yet! Be the first to post! Submit a comment!</i></p>
                                    </div>
                                </div>
                            `);
                        }
                        console.log(data);  
                        
                        
                    });

                    // We need to handle the click events for the comments
                    $("#comment_events button").click(function(e){
                        e.stopImmediatePropagation();
                        e.preventDefault();
                        
                        if($(this).attr("id") === "v_comments"){
                            console.log($("#comments_"+$(this).attr("data-id")));                    
                            $("#comments_"+$(this).attr("data-id")).toggle();
                        }
                        else if($(this).attr("id") === "s_comments"){
                            console.log("Submit a Comment for: "+$(this).attr("data-id"));
                            $("#submit_comment_"+$(this).attr("data-id")).toggle();
                        }
                        else if($(this).attr("id") === "connect_w_user"){
                            console.log("Connect with a user for: "+$(this).attr("data-id"));
                        }
                        else if($(this).attr("id") === "sub_comment"){
                            console.log("Submit a user comment for : "+$(this).attr("data-id"));
                            let parent = $("#submit_comment_"+$(this).attr("data-id"));
                            subComment($(this).attr("data-id"), $("input[name='user_id']", parent).val(), $("input[name='comment']", parent).val());
                        }
                    });
                });
                postCount++;

                } // End if statement
                else {

                }
            }
        });

        // Filter Bar
        $("#rec_posts .filter").html(`
            <div class="flex flex-row">
                <div class="flex flex-container flex-row px-3 py-2 m-5 bg-violet-900/50 rounded-md">
                    <h2 class="text-xl font-bold p-1 text-slate-50">Filter By:</h2>
                    <div class="flex flex-row">
                        <div class="flex flex-row p-1">
                            <select name="festival" id="festival" class="p-2 ml-4 rounded-sm">
                                <option value="0">Select a Festival</option>
                                <optgroup label="EDM">                                    
                                    <option value="lostLands">Lost Lands</option>
                                    <option value="electricforest">Electric Forest</option>
                                    <option value="solfest">Sol Fest</option>                                                                   
                                    <option value="edc">Electric Daisy Carnival</option>
                                    <option value="umf">Ultra Music Festival</option>
                                </optgroup>
                                <optgroup label="Rock">
                                    <option value="louderthanlife">Louder Than Life</option>
                                    <option value="aftershock">Aftershock</option>\
                                    <option value="bourbonandbeyond">Bourbon And Beyond</option>
                                </optgroup>
                                <option value="lollapalooza">Lollapalooza</option> 
                                <option value="Bonnaroo">Bonnaroo</option>
                                <option value="coachella">Coachella</option>
                                <option value="other">Other</option>
                            </select>
                            <button class="flex flex-row p-2 m-2 text-white bg-violet-700/50 rounded-md hover:bg-violet-600/80">
                                Reset
                            </button>
                        </div>
                    </div>
                </div>
            </div>`);
        
        // Handle how the filter event is handled
        $("#rec_posts .filter select").on('change', function(e){
            filter_posts($(this).val(),'festival');
        });
        $("#rec_posts .filter button").on('click', function(){
            filter_posts(null,'reset');
        });
    });

});