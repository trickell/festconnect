@extends('layouts.master')

@section('title', 'Fest Connection || Contact')

@section('content')
<div class="relative min-h-screen flex flex-col items-center justify-center overflow-hidden">
    <!-- Video Background -->
    <x-video-background source="img/video/contact_raver_bg.mp4" />

    <!-- Main Content -->
    <div class="relative z-10 container mx-auto px-6 py-12 flex flex-col items-center max-w-3xl">

        <h1
            class="text-4xl md:text-6xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-400 mb-8 text-center drop-shadow-md">
            Contact Support
        </h1>

        <div class="w-full bg-white/10 backdrop-blur-md border border-white/20 p-8 rounded-2xl shadow-2xl">
            <p class="text-gray-300 text-center mb-8">
                Have a question, suggestion, or need help with a post? Reach out to our moderation team.
            </p>

            <form id="contact_form" class="space-y-6">
                @csrf
                <div class="space-y-2">
                    <label for="name" class="block text-purple-300 font-semibold text-sm uppercase tracking-wide">Your
                        Name</label>
                    <input type="text" id="name" name="name"
                        class="w-full px-4 py-3 rounded-lg bg-black/40 border border-white/10 text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition"
                        placeholder="How should we address you?" value="{{ optional(session('user'))->name }}" required>
                </div>

                <div class="space-y-2">
                    <label for="email" class="block text-purple-300 font-semibold text-sm uppercase tracking-wide">Your
                        Email</label>
                    <input type="email" id="email" name="email"
                        class="w-full px-4 py-3 rounded-lg bg-black/40 border border-white/10 text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition"
                        placeholder="Where can we reply?" value="{{ optional(session('user'))->email }}" required>
                </div>

                <div class="space-y-2">
                    <label for="subject"
                        class="block text-purple-300 font-semibold text-sm uppercase tracking-wide">Subject</label>
                    <select id="subject" name="subject"
                        class="w-full px-4 py-3 rounded-lg bg-black/40 border border-white/10 text-white focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition">
                        <option value="support">General Support</option>
                        <option value="report">Report a Post</option>
                        <option value="feedback">Feedback / Suggestion</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label for="message"
                        class="block text-purple-300 font-semibold text-sm uppercase tracking-wide">Message</label>
                    <textarea id="message" name="message"
                        class="w-full px-4 py-3 rounded-lg bg-black/40 border border-white/10 text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition h-32"
                        placeholder="Tell us what's on your mind..." required></textarea>
                </div>

                <div id="form_message" class="hidden p-4 rounded-lg text-sm font-bold text-center"></div>

                <button type="submit" id="submit_btn"
                    class="w-full py-4 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-bold rounded-lg shadow-lg transform hover:scale-[1.02] transition-all">
                    Send Message
                </button>
            </form>

            <script>
                document.getElementById('contact_form').addEventListener('submit', async (e) => {
                    e.preventDefault();
                    const form = e.target;
                    const btn = document.getElementById('submit_btn');
                    const msg = document.getElementById('form_message');

                    btn.innerText = "SENDING...";
                    btn.disabled = true;
                    msg.classList.add('hidden');

                    const formData = new FormData(form);

                    try {
                        const res = await fetch('{{ url("/submit_ticket") }}', {
                            method: 'POST',
                            body: formData
                        });
                        const data = await res.json();

                        msg.innerText = data.message;
                        msg.classList.remove('hidden');

                        if (data.status === 'success') {
                            msg.className = "p-4 rounded-lg text-sm font-bold text-center bg-green-500/20 text-green-400 mb-6";
                            form.reset();
                            btn.innerText = "MESSAGE SENT!";
                        } else {
                            msg.className = "p-4 rounded-lg text-sm font-bold text-center bg-red-500/20 text-red-400 mb-6";
                            btn.innerText = "SEND MESSAGE";
                            btn.disabled = false;
                        }
                    } catch (err) {
                        msg.innerText = "Something went wrong. Please try again.";
                        msg.className = "p-4 rounded-lg text-sm font-bold text-center bg-red-500/20 text-red-400 mb-6";
                        msg.classList.remove('hidden');
                        btn.disabled = false;
                        btn.innerText = "SEND MESSAGE";
                    }
                });
            </script>
        </div>

        <div class="mt-8 text-gray-400 text-sm">
            Or email us directly at <a href="mailto:support@festconnect.com"
                class="text-purple-400 hover:underline">support@festconnect.com</a>
        </div>

    </div>
</div>
@stop