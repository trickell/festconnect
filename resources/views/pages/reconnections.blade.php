@extends('layouts.master')

@section('title','Fest Connection || Home')

@section('content')
        
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
            
            <div id="top_spacer" class="flex flex-container flex-col h-20 mt-10"></div>

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
@stop