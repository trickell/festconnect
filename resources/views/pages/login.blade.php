@extends('layouts.master')

@section('title','Fest Connection || Login')

@section('content')
        <div class="message-box hidden">Thanks for registering. Login!</div>
        <div id="login-page" class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-800/60 dark:bg-dots-lighter dark:bg-gray-900/70 selection:bg-red-500 selection:text-white">
            <div id="video-bg">
                <video class="login_video" autoplay muted loop>
                    <source src={{ asset('img/video/login_bg.mp4') }} type="video/mp4">
                </video>
            </div>

            <div class="container" id="login_container">
                <div class="form-container sign-up-container">
                    <form id="form_register" action="#">
                        <input id="cstoken" type="hidden" name="_token" value="{{ csrf_token() }}">
                        <h1>Create Account</h1>
                        <div class="social-container">
                            <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
                            <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                        <span>or use your email for registration</span>
                        <input name="username" type="text" placeholder="Username" required />
                        <input name="email" type="email" placeholder="Email" required />
                        <input name="password" type="password" placeholder="Password" required />
                        <div class="err_message text-red-500 text-sm"></div>
                        <button type="submit">Sign Up</button>
                    </form>
                </div>
                <div class="form-container sign-in-container">
                    <form id="form_login" action="#">
                        <input id="cstoken" type="hidden" name="_token" value="{{ csrf_token() }}">
                        <h1>Sign in</h1>
                        <div class="social-container">
                            <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
                            <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                        <span>or use your account</span>
                        <input type="email" name="email" placeholder="Email" required />
                        <input type="password" name="password" placeholder="Password" required />
                        <div class="err_message text-red-500 text-sm"></div>
                        <a href="#">Forgot your password?</a>
                        <button type="submit">Sign In</button>
                    </form>
                </div>
                <div class="overlay-container">
                    <div class="overlay">
                        <div class="overlay-panel overlay-left">
                            <h1>Welcome Back!</h1>
                            <p>To keep connected with us please login with your personal info</p>
                            <button class="ghost" id="signIn">Sign In</button>
                        </div>
                        <div class="overlay-panel overlay-right">
                            <h1>Hello, Friend!</h1>
                            <p>Enter your personal details and start journey with us</p>
                            <button class="ghost" id="signUp">Sign Up</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @stop