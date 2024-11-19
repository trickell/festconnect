<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Fest Connection</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link href={{ asset('css/app.css') }} rel="stylesheet">

        <script src="https://cdn.tailwindcss.com"></script>
        <script
        src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
        crossorigin="anonymous"></script>
        <script src={{ asset('js/app.js') }}></script>


        <!-- Styles -->
        <style>
            /* ! tailwindcss v3.2.4 | MIT License | https://tailwindcss.com */*,::after,::before{box-sizing:border-box;border-width:0;border-style:solid;border-color:#e5e7eb}::after,::before{--tw-content:''}html{line-height:1.5;-webkit-text-size-adjust:100%;-moz-tab-size:4;tab-size:4;font-family:Figtree, sans-serif;font-feature-settings:normal}body{margin:0;line-height:inherit}hr{height:0;color:inherit;border-top-width:1px}abbr:where([title]){-webkit-text-decoration:underline dotted;text-decoration:underline dotted}h1,h2,h3,h4,h5,h6{font-size:inherit;font-weight:inherit}a{color:inherit;text-decoration:inherit}b,strong{font-weight:bolder}code,kbd,pre,samp{font-family:ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;font-size:1em}small{font-size:80%}sub,sup{font-size:75%;line-height:0;position:relative;vertical-align:baseline}sub{bottom:-.25em}sup{top:-.5em}table{text-indent:0;border-color:inherit;border-collapse:collapse}button,input,optgroup,select,textarea{font-family:inherit;font-size:100%;font-weight:inherit;line-height:inherit;color:inherit;margin:0;padding:0}button,select{text-transform:none}[type=button],[type=reset],[type=submit],button{-webkit-appearance:button;background-color:transparent;background-image:none}:-moz-focusring{outline:auto}:-moz-ui-invalid{box-shadow:none}progress{vertical-align:baseline}::-webkit-inner-spin-button,::-webkit-outer-spin-button{height:auto}[type=search]{-webkit-appearance:textfield;outline-offset:-2px}::-webkit-search-decoration{-webkit-appearance:none}::-webkit-file-upload-button{-webkit-appearance:button;font:inherit}summary{display:list-item}blockquote,dd,dl,figure,h1,h2,h3,h4,h5,h6,hr,p,pre{margin:0}fieldset{margin:0;padding:0}legend{padding:0}menu,ol,ul{list-style:none;margin:0;padding:0}textarea{resize:vertical}input::placeholder,textarea::placeholder{opacity:1;color:#9ca3af}[role=button],button{cursor:pointer}:disabled{cursor:default}audio,canvas,embed,iframe,img,object,svg,video{display:block;vertical-align:middle}img,video{max-width:100%;height:auto}[hidden]{display:none}*, ::before, ::after{--tw-border-spacing-x:0;--tw-border-spacing-y:0;--tw-translate-x:0;--tw-translate-y:0;--tw-rotate:0;--tw-skew-x:0;--tw-skew-y:0;--tw-scale-x:1;--tw-scale-y:1;--tw-pan-x: ;--tw-pan-y: ;--tw-pinch-zoom: ;--tw-scroll-snap-strictness:proximity;--tw-ordinal: ;--tw-slashed-zero: ;--tw-numeric-figure: ;--tw-numeric-spacing: ;--tw-numeric-fraction: ;--tw-ring-inset: ;--tw-ring-offset-width:0px;--tw-ring-offset-color:#fff;--tw-ring-color:rgb(59 130 246 / 0.5);--tw-ring-offset-shadow:0 0 #0000;--tw-ring-shadow:0 0 #0000;--tw-shadow:0 0 #0000;--tw-shadow-colored:0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: ;--tw-backdrop-blur: ;--tw-backdrop-brightness: ;--tw-backdrop-contrast: ;--tw-backdrop-grayscale: ;--tw-backdrop-hue-rotate: ;--tw-backdrop-invert: ;--tw-backdrop-opacity: ;--tw-backdrop-saturate: ;--tw-backdrop-sepia: }::-webkit-backdrop{--tw-border-spacing-x:0;--tw-border-spacing-y:0;--tw-translate-x:0;--tw-translate-y:0;--tw-rotate:0;--tw-skew-x:0;--tw-skew-y:0;--tw-scale-x:1;--tw-scale-y:1;--tw-pan-x: ;--tw-pan-y: ;--tw-pinch-zoom: ;--tw-scroll-snap-strictness:proximity;--tw-ordinal: ;--tw-slashed-zero: ;--tw-numeric-figure: ;--tw-numeric-spacing: ;--tw-numeric-fraction: ;--tw-ring-inset: ;--tw-ring-offset-width:0px;--tw-ring-offset-color:#fff;--tw-ring-color:rgb(59 130 246 / 0.5);--tw-ring-offset-shadow:0 0 #0000;--tw-ring-shadow:0 0 #0000;--tw-shadow:0 0 #0000;--tw-shadow-colored:0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: ;--tw-backdrop-blur: ;--tw-backdrop-brightness: ;--tw-backdrop-contrast: ;--tw-backdrop-grayscale: ;--tw-backdrop-hue-rotate: ;--tw-backdrop-invert: ;--tw-backdrop-opacity: ;--tw-backdrop-saturate: ;--tw-backdrop-sepia: }::backdrop{--tw-border-spacing-x:0;--tw-border-spacing-y:0;--tw-translate-x:0;--tw-translate-y:0;--tw-rotate:0;--tw-skew-x:0;--tw-skew-y:0;--tw-scale-x:1;--tw-scale-y:1;--tw-pan-x: ;--tw-pan-y: ;--tw-pinch-zoom: ;--tw-scroll-snap-strictness:proximity;--tw-ordinal: ;--tw-slashed-zero: ;--tw-numeric-figure: ;--tw-numeric-spacing: ;--tw-numeric-fraction: ;--tw-ring-inset: ;--tw-ring-offset-width:0px;--tw-ring-offset-color:#fff;--tw-ring-color:rgb(59 130 246 / 0.5);--tw-ring-offset-shadow:0 0 #0000;--tw-ring-shadow:0 0 #0000;--tw-shadow:0 0 #0000;--tw-shadow-colored:0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: ;--tw-backdrop-blur: ;--tw-backdrop-brightness: ;--tw-backdrop-contrast: ;--tw-backdrop-grayscale: ;--tw-backdrop-hue-rotate: ;--tw-backdrop-invert: ;--tw-backdrop-opacity: ;--tw-backdrop-saturate: ;--tw-backdrop-sepia: }.relative{position:relative}.mx-auto{margin-left:auto;margin-right:auto}.mx-6{margin-left:1.5rem;margin-right:1.5rem}.ml-4{margin-left:1rem}.mt-16{margin-top:4rem}.mt-6{margin-top:1.5rem}.mt-4{margin-top:1rem}.-mt-px{margin-top:-1px}.mr-1{margin-right:0.25rem}.flex{display:flex}.inline-flex{display:inline-flex}.grid{display:grid}.h-16{height:4rem}.h-7{height:1.75rem}.h-6{height:1.5rem}.h-5{height:1.25rem}.min-h-screen{min-height:100vh}.w-auto{width:auto}.w-16{width:4rem}.w-7{width:1.75rem}.w-6{width:1.5rem}.w-5{width:1.25rem}.max-w-7xl{max-width:80rem}.shrink-0{flex-shrink:0}.scale-100{--tw-scale-x:1;--tw-scale-y:1;transform:translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))}.grid-cols-1{grid-template-columns:repeat(1, minmax(0, 1fr))}.items-center{align-items:center}.justify-center{justify-content:center}.gap-6{gap:1.5rem}.gap-4{gap:1rem}.self-center{align-self:center}.rounded-lg{border-radius:0.5rem}.rounded-full{border-radius:9999px}.bg-gray-100{--tw-bg-opacity:1;background-color:rgb(243 244 246 / var(--tw-bg-opacity))}.bg-white{--tw-bg-opacity:1;background-color:rgb(255 255 255 / var(--tw-bg-opacity))}.bg-red-50{--tw-bg-opacity:1;background-color:rgb(254 242 242 / var(--tw-bg-opacity))}.bg-dots-darker{background-image:url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E")}.from-gray-700\/50{--tw-gradient-from:rgb(55 65 81 / 0.5);--tw-gradient-to:rgb(55 65 81 / 0);--tw-gradient-stops:var(--tw-gradient-from), var(--tw-gradient-to)}.via-transparent{--tw-gradient-to:rgb(0 0 0 / 0);--tw-gradient-stops:var(--tw-gradient-from), transparent, var(--tw-gradient-to)}.bg-center{background-position:center}.stroke-red-500{stroke:#ef4444}.stroke-gray-400{stroke:#9ca3af}.p-6{padding:1.5rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.text-center{text-align:center}.text-right{text-align:right}.text-xl{font-size:1.25rem;line-height:1.75rem}.text-sm{font-size:0.875rem;line-height:1.25rem}.font-semibold{font-weight:600}.leading-relaxed{line-height:1.625}.text-gray-600{--tw-text-opacity:1;color:rgb(75 85 99 / var(--tw-text-opacity))}.text-gray-900{--tw-text-opacity:1;color:rgb(17 24 39 / var(--tw-text-opacity))}.text-gray-500{--tw-text-opacity:1;color:rgb(107 114 128 / var(--tw-text-opacity))}.underline{-webkit-text-decoration-line:underline;text-decoration-line:underline}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.shadow-2xl{--tw-shadow:0 25px 50px -12px rgb(0 0 0 / 0.25);--tw-shadow-colored:0 25px 50px -12px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)}.shadow-gray-500\/20{--tw-shadow-color:rgb(107 114 128 / 0.2);--tw-shadow:var(--tw-shadow-colored)}.transition-all{transition-property:all;transition-timing-function:cubic-bezier(0.4, 0, 0.2, 1);transition-duration:150ms}.selection\:bg-red-500 *::selection{--tw-bg-opacity:1;background-color:rgb(239 68 68 / var(--tw-bg-opacity))}.selection\:text-white *::selection{--tw-text-opacity:1;color:rgb(255 255 255 / var(--tw-text-opacity))}.selection\:bg-red-500::selection{--tw-bg-opacity:1;background-color:rgb(239 68 68 / var(--tw-bg-opacity))}.selection\:text-white::selection{--tw-text-opacity:1;color:rgb(255 255 255 / var(--tw-text-opacity))}.hover\:text-gray-900:hover{--tw-text-opacity:1;color:rgb(17 24 39 / var(--tw-text-opacity))}.hover\:text-gray-700:hover{--tw-text-opacity:1;color:rgb(55 65 81 / var(--tw-text-opacity))}.focus\:rounded-sm:focus{border-radius:0.125rem}.focus\:outline:focus{outline-style:solid}.focus\:outline-2:focus{outline-width:2px}.focus\:outline-red-500:focus{outline-color:#ef4444}.group:hover .group-hover\:stroke-gray-600{stroke:#4b5563}.z-10{z-index: 10}@media (prefers-reduced-motion: no-preference){.motion-safe\:hover\:scale-\[1\.01\]:hover{--tw-scale-x:1.01;--tw-scale-y:1.01;transform:translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))}}@media (prefers-color-scheme: dark){.dark\:bg-gray-900{--tw-bg-opacity:1;background-color:rgb(17 24 39 / var(--tw-bg-opacity))}.dark\:bg-gray-800\/50{background-color:rgb(31 41 55 / 0.5)}.dark\:bg-red-800\/20{background-color:rgb(153 27 27 / 0.2)}.dark\:bg-dots-lighter{background-image:url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E")}.dark\:bg-gradient-to-bl{background-image:linear-gradient(to bottom left, var(--tw-gradient-stops))}.dark\:stroke-gray-600{stroke:#4b5563}.dark\:text-gray-400{--tw-text-opacity:1;color:rgb(156 163 175 / var(--tw-text-opacity))}.dark\:text-white{--tw-text-opacity:1;color:rgb(255 255 255 / var(--tw-text-opacity))}.dark\:shadow-none{--tw-shadow:0 0 #0000;--tw-shadow-colored:0 0 #0000;box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)}.dark\:ring-1{--tw-ring-offset-shadow:var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);--tw-ring-shadow:var(--tw-ring-inset) 0 0 0 calc(1px + var(--tw-ring-offset-width)) var(--tw-ring-color);box-shadow:var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000)}.dark\:ring-inset{--tw-ring-inset:inset}.dark\:ring-white\/5{--tw-ring-color:rgb(255 255 255 / 0.05)}.dark\:hover\:text-white:hover{--tw-text-opacity:1;color:rgb(255 255 255 / var(--tw-text-opacity))}.group:hover .dark\:group-hover\:stroke-gray-400{stroke:#9ca3af}}@media (min-width: 640px){.sm\:fixed{position:fixed}.sm\:top-0{top:0px}.sm\:right-0{right:0px}.sm\:ml-0{margin-left:0px}.sm\:flex{display:flex}.sm\:items-center{align-items:center}.sm\:justify-center{justify-content:center}.sm\:justify-between{justify-content:space-between}.sm\:text-left{text-align:left}.sm\:text-right{text-align:right}}@media (min-width: 768px){.md\:grid-cols-2{grid-template-columns:repeat(2, minmax(0, 1fr))}}@media (min-width: 1024px){.lg\:gap-8{gap:2rem}.lg\:p-8{padding:2rem}}
        </style>
    </head>
    <body class="antialiased">
        <div class="message-box hidden">Thanks for registering. Login!</div>
        
        <div class="relative flex scroll-smooth flex-col sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-800/70 dark:bg-dots-lighter dark:bg-gray-900/70 selection:bg-red-500 selection:text-white lg:max-w-4xl lg:mx-auto">
            <div id="video-bg">
            <video class="missedconn_video" autoplay muted loop>
                <source src={{ asset('img/video/reconnections_bg.mp4') }} type="video/mp4">
            </video>
            </div>
            
            <header class="justify-center flex-col">
            <nav class="text-white-500 text-center flex flex-row z-0">
                <ul class="flex flex-row mx-auto z-0">
                    <li class="p-5 m-2 text-slate-500 bg-violet-950/50 text-xl hover:text-slate-200 hover:bg-violet-900/80 hover:border-1 hover:border-violet-500 hover:rounded-sm"><a htext-slate-200 "><a href="/">Home</a></li>
                    <li class="p-5 m-2 text-slate-500 bg-violet-950/50 text-xl hover:text-slate-200 hover:bg-violet-900/80 hover:border-1 hover:border-violet-500 hover:rounded-sm"><a href="/missed_connections">Missed Connections</a></li>
                    <li class="p-5 m-2 text-slate-500 bg-violet-950/50 text-xl hover:text-slate-200 hover:bg-violet-900/80 hover:border-1 hover:border-violet-500 hover:rounded-sm"><a href="/about">About</a></li>
                    <li class="p-5 m-2 text-slate-500 bg-violet-950/50 text-xl hover:text-slate-200 hover:bg-violet-900/80 hover:border-1 hover:border-violet-500 hover:rounded-sm"><a href="/contact">Contact a Moderator</a></li>
                    <li class="justify-right m-2 p-5 ml-20 text-slate-500 bg-sky-950/50 text-xl hover:text-slate-200 hover:bg-sky-800/80 hover:border-1 hover:border-sky-500 hover:rounded-sm">
                        <a href="/logout">Logout</a>
                    </li>
                </ul>
                
            </nav>
            </header>
            
            <div id="top_spacer" class="flex flex-container flex-col h-20 mt-20"></div>

            <div class="text-white-500 text-center flex flex-col">           
                <div class="loader z-0 hidden"></div>
                <div id="rec_landing" class="flex flex-container flex-col z-0">
                    <h1 class="text-6xl font-semibold leading-relaxed text-white dark:text-white mt-100">Rekindle / Find a Missed Connection</h1>
                    <div class="missed_text flex flex-container flex-col max-w-5xl m-5 text-gray-400 text-lg">
                        <p class="pt-5">Have you ever met someone at a festival and felt a connection, but didn't get their contact information? Or maybe you're looking for someone you met at a festival and want to reconnect? Fest Connection is here to help you find that missed connection.</p>
                        <p class="pt-5">Fill out a little bit of information about the connection you're looking for and some information about yourself. We'll do the best
                            to help find that person. If a connection is found, we will notify you via email! </p>  
                    </div> 
                    <div class="flex flex-container flex-row justify-center">
                        <div class="flex flex-container flex-row mx-5">
                            <button class="p-2 px-6 mt-4 bg-red-500 text-white rounded-lg submitMissedConnections">Submit a Missed Connection</button>
                        </div>
                        <div class="flex flex-container flex-row">
                            <button class="p-2 px-6 mt-4 bg-red-500 text-white rounded-lg viewMissedConnections">View Missed Connections</button>
                        </div>
                    </div>
                </div>

                <div id="rec_form" class="flex flex-container flex-col z-0 hidden">
                    <h3 class="text-6xl font-semibold leading-relaxed text-white dark:text-white">Fill the Form out, best to memory!</h3>
                    <form id="missed_connection_form" class="flex flex-container flex-col max-w-5xl m-5 text-gray-400 text-lg">
                        <input id="cstoken" type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="user_id" value=""><!-- BADLY DONE! NEED TO FIX -->
                        <div class="flex flex-container flex-row">
                            <label for="festival" class="text-xl">Festival Name:</label>
                            <select id="festival_name" name="festival" class="p-2 ml-4 rounded-sm" required>
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

                            <!--<input type="text" id="festival_name" name="festival_name" class="p-2 ml-4 rounded-lg" required>-->
                        </div>
                        <div class="flex flex-container flex-row">
                            <label for="missed_conn" class="text-xl">Who is the Missed Connection? <i class="text-sm">ex. Detailed description of the person</i></label>
                            <textarea id="missedConnection" name="missed_conn" class="p-2 ml-4 rounded-lg"></textarea>

                            <!-- Optional: Upload an Image <input type="file" id="optConnectImg" name="optConnectImg" class="p-2 ml-4 rounded-lg" accept="image/*,.pdf"> -->
                        </div>
                        <div class="flex flex-container flex-row">
                            <label>Optional:</label> Upload an Image <input type="file" id="optConnectImg" name="optConnectImg" class="p-2 ml-4 rounded-lg" accept="image/*,.pdf">
                        </div>
                        <div class="flex flex-container flex-row">
                            <label for="post" class="text-xl">Detailed Description of how we met: <i class="text-sm">ex. Where in the festival?</i></label>
                            <textarea id="description" name="post" class="p-2 ml-4 rounded-lg" required></textarea>
                        </div>
                        <div class="flex flex-container flex-row">
                            <label for="your_name" class="text-xl">Your Name:</label>
                            <input type="text" id="your_name" name="name" class="p-2 ml-4 rounded-lg" placeholder="Real Name or Festival Name" required>
                        </div>
                        <div class="flex flex-container flex-row">
                            <label for="your_email" class="text-xl">Your Email: (We notify you when they connect with you!)</label>
                            <input type="text" id="your_email" name="email" class="p-2 ml-4 rounded-lg" required>
                        </div>
                        <div class="flex flex-container flex-row text-right">
                            <i class="m-5">After Submitting, You will be brought to everyone elses posts!</i>
                            <button type="submit" class="p-2 px-6 mt-4 bg-red-500 text-white rounded-lg text-right">Submit</button>
                            <button class="p-2 px-6 mt-4 bg-red-500 text-white rounded-lg text-right viewMissedConnections mx-10">View Posts</button>
                        </div>
                    </form>
                    <a class="absolute left-9000 rounded-lg text-right formSubmittedBtn"></a>
                </div>
                
                <!-- This is where the content for the missed connections will go -->
                <div id="rec_posts" class="flex flex-container flex-col z-0 hidden">
                    <div class="filter"></div>
                    <div class="body scroll-smooth"></div>
                    <div class="buttons">
                    <div class="flex flex-container flex-row justify-center">
                        <div class="flex flex-container flex-row mx-5">
                            <button class="p-2 px-6 mt-4 bg-red-500 text-white rounded-lg submitMissedConnections">Submit a Missed Connection</button>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </body>