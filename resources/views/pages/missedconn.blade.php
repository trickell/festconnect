@extends('layouts.master')

@section('title','Fest Connection || Missed and Shared Connections')

@section('content')
        
        <div class="relative sm:flex sm:justify-center sm:items-center lg:min-h-screen bg-dots-darker bg-center bg-gray-800/70 dark:bg-dots-lighter dark:bg-gray-900/70 selection:bg-red-500 selection:text-white z-0">
            <div id="video-bg">
                <video class="missedconn_video" autoplay muted loop>
                    <source src={{ asset('img/video/missedconn_bg.mp4') }} type="video/mp4">
                </video>
            </div>
            <div class="text-white-500 text-center flex flex-col">
                <h1 class="text-4xl pt-5 lg:text-6xl font-semibold leading-relaxed text-white dark:text-white z-0">Missed and Shared Connections</h1>
                <div class="missed_text flex flex-container lg:max-w-5xl m-5 text-gray-400 text-lg z-0">
                    Moments that slipped away can find their way back to you! Festivals are full of fleeting interactions and unforgettable experiences, but sometimes, the hustle and excitement means you miss the chance to reconnect. Whether it was a brief conversation in the crowd, a shared glance during your favorite set, or a helping hand that got lost in the shuffle, this is the place to reach out and recapture those special connections. Leave a message, and who knows? You might just find that person you've been thinking about ever since.
                </div>    
                <div class="flex flex-container flex-col lg:flex-row z-0">
                    <div class="flex flex-col">
                        <a href="/reconnections" class="text-xl text-gray-400 dark:text-gray-400 hover:text-red-400 p-10 m-2 border-solid rounded-md border-2 bg-slate-900/70 hover:bg-slate-900/80">
                            <p>Another Lost Connection!</p>
                            <p>No worries! Let's make a reconnection happen.</p>
                        </a>
                    </div>
                    <div class="flex flex-col">
                        <a href="#" class="text-xl text-gray-400 dark:text-gray-400 hover:text-red-400 p-10 m-2 border-solid rounded-md border-2 bg-slate-900/70 hover:bg-slate-900/80">
                            <p class="text-xl dark:text-gray-400">Festival Share Zone</p>
                            <p class="text-xl dark:text-gray-400">Share an image, a find, or a gift with us here!</p>
                        </a>
                    </div>
                </div>
            </div>
@stop