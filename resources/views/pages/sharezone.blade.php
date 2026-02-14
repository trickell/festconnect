@extends('layouts.master')

@section('title', 'Fest Connection || Festival Share Zone')

@section('content')
<div class="relative min-h-screen flex flex-col pt-20 overflow-hidden bg-black text-white">
    <!-- Video Background -->
    <x-video-background source="img/video/missedconn_bg.mp4" />

    <!-- Flag Modal (Moderator Only) -->
    <!-- Added penelty system for moderators to flag posts -->
    <div id="mod_flag_modal"
        class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-black/90 backdrop-blur-md p-4">
        <div class="bg-gray-900 border border-white/10 rounded-3xl w-full max-w-lg p-8 shadow-2xl animate-fade-in-up">
            <h2 class="text-2xl font-bold mb-6 text-pink-400 italic uppercase">Flag Post</h2>
            <form id="mod_flag_form" class="space-y-6">
                <input type="hidden" name="target_id" id="flag_target_id">
                <input type="hidden" name="target_type" value="post">

                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2">Flag
                        Type</label>
                    <select name="type"
                        class="w-full bg-black/40 border border-white/10 rounded-xl p-4 text-white focus:border-pink-500 outline-none">
                        <option value="warning">Potential Violation</option>
                        <option value="bad">Bad Conduct / Spam</option>
                        <option value="nudity">Nudity / NSFW</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2">Reason
                        (Visible to Admin)</label>
                    <textarea name="reason" rows="4" required
                        class="w-full bg-black/40 border border-white/10 rounded-2xl p-4 text-gray-200 focus:outline-none focus:border-pink-500 transition resize-none"
                        placeholder="Why are you flagging this?"></textarea>
                </div>

                <div class="flex gap-4">
                    <button type="submit"
                        class="flex-1 bg-pink-600 hover:bg-pink-500 py-4 rounded-2xl font-black uppercase tracking-widest transition text-sm shadow-xl">Submit
                        Flag</button>
                    <button type="button" onclick="closeModFlagModal()"
                        class="px-8 bg-white/5 hover:bg-white/10 py-4 rounded-2xl font-bold uppercase tracking-widest transition text-gray-400 text-sm">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Sidebar / Form Container -->
    <div id="share_form_sidebar"
        class="fixed top-0 right-0 h-full w-full md:w-96 bg-gray-900/95 backdrop-blur-xl border-l border-white/10 z-50 transform translate-x-full transition-transform duration-500 ease-in-out shadow-2xl">
        <div class="p-8 h-full flex flex-col">
            <div class="flex justify-between items-center mb-10">
                <h2 id="form_title"
                    class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-pink-400 to-purple-400">
                    Post to Share Zone</h2>
                <button id="close_sidebar" class="p-2 hover:bg-white/10 rounded-full transition">
                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form id="share_zone_form" class="flex-grow space-y-6 overflow-y-auto pr-2 custom-scrollbar">
                @csrf
                <input type="hidden" name="post_type" value="share_zone">
                <input type="hidden" name="reply_to_post_id" id="reply_to_post_id">

                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2 uppercase tracking-wider">Post
                        Type</label>
                    <select name="category" required
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 focus:outline-none focus:border-pink-500 transition text-white">
                        <option value="Chat" class="bg-gray-900" selected>Chat</option>
                        <option value="Reply" class="bg-gray-900">Reply</option>
                        <option value="Lost Item" class="bg-gray-900">Lost Item</option>
                        <option value="Find" class="bg-gray-900">Find</option>
                        <option value="Trinkets" class="bg-gray-900">Trinkets</option>
                        <option value="Other" class="bg-gray-900">Other</option>
                    </select>
                </div>

                <div>
                    <label
                        class="block text-sm font-medium text-gray-400 mb-2 uppercase tracking-wider">Festival</label>
                    <select name="festival" required
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 focus:outline-none focus:border-pink-500 transition text-white">
                        <option value="">Select a Festival</option>
                        <optgroup label="EDM">
                            <option value="lostLands">Lost Lands</option>
                            <option value="electricforest">Electric Forest</option>
                            <option value="solfest">Sol Fest</option>
                            <option value="edc">Electric Daisy Carnival</option>
                            <option value="umf">Ultra Music Festival</option>
                        </optgroup>
                        <optgroup label="Rock">
                            <option value="louderthanlife">Louder Than Life</option>
                            <option value="aftershock">Aftershock</option>
                            <option value="bourbonandbeyond">Bourbon And Beyond</option>
                        </optgroup>
                        <option value="lollapalooza">Lollapalooza</option>
                        <option value="Bonnaroo">Bonnaroo</option>
                        <option value="coachella">Coachella</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2 uppercase tracking-wider">Image
                        Reference</label>
                    <div class="relative group">
                        <input type="file" name="optConnectImg[]" id="share_img_input" accept="image/*" multiple
                            class="hidden">
                        <label for="share_img_input"
                            class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-white/10 rounded-xl cursor-pointer hover:border-pink-500/50 hover:bg-white/5 transition">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 text-gray-400 mb-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <p class="text-xs text-gray-400 text-center px-4" id="image_label">Click to upload
                                    images (up to 5)</p>
                            </div>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2 uppercase tracking-wider">Body</label>
                    <textarea name="post" required rows="5"
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 focus:outline-none focus:border-pink-500 transition text-white placeholder-gray-600 resize-none"
                        placeholder="Tell the community more..."></textarea>
                </div>

                <button type="submit" id="submit_share_btn"
                    class="w-full bg-gradient-to-r from-pink-600 to-purple-600 hover:from-pink-500 hover:to-purple-500 text-white font-bold py-4 rounded-xl shadow-lg transform hover:scale-[1.02] transition active:scale-95">
                    POST NOW
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="relative z-10 w-full max-w-6xl mx-auto px-6 flex flex-col h-full">
        <a href="{{ url('reconnections') }}"
            class="relative w-1/2 h-10 rounded-full bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center text-sm font-bold shadow-lg mb-10">
            Visit Missed Connections
        </a>
        <!-- Header & Typing Indicator -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
            <div>
                <h1 class="text-4xl md:text-5xl font-black text-white italic tracking-tighter">FESTIVAL <span
                        class="text-pink-500">SHARE ZONE</span></h1>
                <div id="typing_area" class="h-6 mt-2">
                    <p id="typing_text" class="text-pink-400 text-sm font-medium animate-pulse hidden">Someone is
                        typing...</p>
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <div class="relative">
                    <select id="festival_filter"
                        class="bg-white/10 text-white text-sm font-bold uppercase tracking-widest px-4 py-3 rounded-full border border-white/10 focus:outline-none hover:bg-white/20 transition cursor-pointer appearance-none pr-10">
                        <option value="">All</option>
                        <optgroup label="EDM">
                            <option value="lostLands">Lost Lands</option>
                            <option value="electricforest">Electric Forest</option>
                            <option value="solfest">Sol Fest</option>
                            <option value="edc">Electric Daisy Carnival</option>
                            <option value="umf">Ultra Music Festival</option>
                        </optgroup>
                        <optgroup label="Rock">
                            <option value="louderthanlife">Louder Than Life</option>
                            <option value="aftershock">Aftershock</option>
                            <option value="bourbonandbeyond">Bourbon And Beyond</option>
                        </optgroup>
                        <option value="lollapalooza">Lollapalooza</option>
                        <option value="Bonnaroo">Bonnaroo</option>
                        <option value="coachella">Coachella</option>
                        <option value="other">Other</option>
                    </select>
                    <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <button id="open_sidebar"
                class="group flex items-center space-x-3 bg-white/10 hover:bg-white/20 px-6 py-3 rounded-full border border-white/10 transition">
                <span class="text-sm font-bold uppercase tracking-widest text-gray-300 group-hover:text-white">Create
                    Post</span>
                <div
                    class="w-10 h-10 bg-pink-600 rounded-full flex items-center justify-center shadow-lg group-hover:rotate-90 transition duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                        </path>
                    </svg>
                </div>
            </button>
        </div>
    </div>

    <!-- Posts Feed -->
    <div id="share_zone_feed" class="flex-1 flex flex-col gap-6 pb-10 overflow-y-auto custom-scrollbar">
        <!-- Posts injected via JS -->
        <div class="py-20 text-center animate-pulse">
            <p class="text-gray-500">Waking up the share zone...</p>
        </div>
    </div>

    <!-- Pagination Controls -->
    <div id="pagination_container" class="flex justify-center gap-4 pb-10 z-20">
        <!-- Pagination buttons injected via JS -->
    </div>
</div>

<!-- Private Message Modal -->
<div id="private_message_modal"
    class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-black/90 backdrop-blur-md p-4">
    <div class="bg-gray-900 border border-white/10 rounded-3xl w-full max-w-lg p-8 shadow-2xl animate-fade-in-up">
        <h2 class="text-2xl font-bold mb-6 text-pink-400 italic uppercase">Message <span
                id="msg_target_name">User</span></h2>
        <form id="private_message_form" class="space-y-6">
            @csrf
            <input type="hidden" name="receiver_id" id="msg_receiver_id">

            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2">Message</label>
                <textarea name="message" rows="4" required
                    class="w-full bg-black/40 border border-white/10 rounded-2xl p-4 text-gray-200 focus:outline-none focus:border-pink-500 transition resize-none"
                    placeholder="Write your message..."></textarea>
            </div>

            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2">Attach Images
                    (Optional)</label>
                <input type="file" name="optConnectImg[]" multiple accept="image/*"
                    class="w-full bg-black/40 border border-white/10 rounded-xl p-2 text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-pink-600 file:text-white hover:file:bg-pink-500 transition">
            </div>

            <div class="flex gap-4">
                <button type="submit"
                    class="flex-1 bg-pink-600 hover:bg-pink-500 py-4 rounded-2xl font-black uppercase tracking-widest transition text-sm shadow-xl">Send
                    Message</button>
                <button type="button" onclick="closeMessageModal()"
                    class="px-8 bg-white/5 hover:bg-white/10 py-4 rounded-2xl font-bold uppercase tracking-widest transition text-gray-400 text-sm">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Lightbox Modal -->
<div id="image_lightbox"
    class="fixed inset-0 z-[9999] hidden flex items-center justify-center bg-black/90 backdrop-blur-md animate-fade-in cursor-pointer">
    <button id="close_lightbox"
        class="absolute top-6 right-6 p-4 bg-white/10 hover:bg-white/20 rounded-full transition-all z-[110] group">
        <svg class="w-10 h-10 text-white group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
    <div
        class="lightbox-content-container relative w-[85vw] h-[85vh] flex items-center justify-center pointer-events-none">
        <img id="lightbox_img" src=""
            class="max-w-full max-h-full object-contain rounded-xl shadow-2xl pointer-events-auto border border-white/5">
    </div>
</div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const sidebar = document.getElementById('share_form_sidebar');
        const openBtn = document.getElementById('open_sidebar');
        const closeBtn = document.getElementById('close_sidebar');
        const form = document.getElementById('share_zone_form');
        const feed = document.getElementById('share_zone_feed');
        const typingArea = document.getElementById('typing_area');
        const typingText = document.getElementById('typing_text');
        const imgInput = document.getElementById('share_img_input');
        const imgLabel = document.getElementById('image_label');

        const festivalFilter = document.getElementById('festival_filter');
        const paginationContainer = document.getElementById('pagination_container');

        let editingPostId = null;
        const currentUserId = {{ optional(session('user'))->id ?? 'null' }};
        const userRole = '{{ optional(session('user'))->role ?? 'user' }}';
        let isTyping = false;
        let typingTimeout;
        let lastFetchedDataHash = null;
        let currentPage = 1;
        let currentFestival = 'all';
        let allPosts = [];

        // Sidebar Toggle
        openBtn.addEventListener('click', () => {
            editingPostId = null;
            document.getElementById('form_title').innerText = "Post to Share Zone";
            document.getElementById('submit_share_btn').innerText = "POST NOW";
            form.reset();
            sidebar.classList.remove('translate-x-full');
        });
        closeBtn.addEventListener('click', () => sidebar.classList.add('translate-x-full'));

        // Filter Update
        festivalFilter.addEventListener('change', (e) => {
            currentFestival = e.target.value;
            currentPage = 1;
            fetchPosts();
        });



        const parseTags = (text) => {
            if (!text) return '';
            // Regex to find hashtags and mentions
            const hashtagRegex = /(#\w+)/g;
            const mentionRegex = /(@\w+)/g;

            // Replace hashtags with styled spans
            let parsedText = text.replace(hashtagRegex, '<span class="text-blue-400 font-semibold">$1</span>');

            // Replace mentions with styled spans
            parsedText = parsedText.replace(mentionRegex, (match) => {
                const username = match.substring(1);
                return `<a href="/profile/${username}" class="text-pink-400 font-bold hover:underline">${match}</a>`;
            });

            return parsedText;
        };

        // Image Label Update
        imgInput.addEventListener('change', () => {
            if (imgInput.files && imgInput.files.length > 0) {
                const count = imgInput.files.length;
                imgLabel.innerText = count > 5 ? "Limit 5 images selected" : `${count} images selected`;
                imgLabel.classList.toggle('text-pink-400', count <= 5);
                imgLabel.classList.toggle('text-red-400', count > 5);
            } else {
                imgLabel.innerText = "Click to upload images (up to 5)";
                imgLabel.classList.remove('text-pink-400', 'text-red-400');
            }
        });

        // Hover Image Logic
        const thumbnailItems = document.querySelectorAll('.thumbnail-item');
        thumbnailItems.forEach(item => {
            item.addEventListener('mouseenter', () => {
                item.classList.add('hover:border-pink-500/50');
            });
            item.addEventListener('mouseleave', () => {
                item.classList.remove('hover:border-pink-500/50');
            });
        });

        // Lightbox Logic
        const lightbox = document.getElementById('image_lightbox');
        const lightboxImg = document.getElementById('lightbox_img');
        const closeLightbox = document.getElementById('close_lightbox');

        window.openImage = (src) => {
            lightboxImg.src = src;
            lightbox.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        };

        closeLightbox.addEventListener('click', () => {
            lightbox.classList.add('hidden');
            document.body.style.overflow = '';
        });

        lightbox.addEventListener('click', (e) => {
            if (e.target === lightbox) {
                lightbox.classList.add('hidden');
                document.body.style.overflow = '';
            }
        });

        // Typing Status Logic
        const textarea = form.querySelector('textarea');
        textarea.addEventListener('input', () => {
            if (!isTyping) {
                isTyping = true;
                updateTypingBackend(true);
            }
            clearTimeout(typingTimeout);
            typingTimeout = setTimeout(() => {
                isTyping = false;
                updateTypingBackend(false);
            }, 3000);
        });

        const updatePresence = async () => {
            try {
                await fetch('/update_presence', {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                });
            } catch (e) {
                console.error("Presence error:", e);
            }
        };

        const updateTypingBackend = async (typing) => {
            if (!typing) return; // Backend only tracks active typing time
            try {
                await fetch('/update_typing', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ room: 'share_zone' })
                });
            } catch (e) { console.error("Typing error:", e); }
        };

        // Live Updates
        const fetchPosts = async () => {
            try {
                const res = await fetch(`/get_posts?type=share_zone&festival=${currentFestival}&page=${currentPage}`);
                const data = await res.json();
                allPosts = data.data; // Store for edit/search logic
                renderPosts(data.data);
                renderPagination(data);
            } catch (e) {
                console.error("Fetch error:", e);
            }
        };

        const fetchTypingStatus = async () => {
            try {
                const res = await fetch('/get_typing_status?room=share_zone');
                const users = await res.json();
                if (users.length > 0) {
                    const names = users.map(u => u.name).join(', ');
                    typingText.innerText = `${names} ${users.length > 1 ? 'are' : 'is'} typing...`;
                    typingText.classList.remove('hidden');
                } else {
                    typingText.classList.add('hidden');
                }
            } catch (e) { console.error("Typing status error:", e); }
        };

        const renderPosts = (posts) => {
            if (!posts || posts.length === 0) {
                feed.innerHTML = `
                    <div class="col-span-full py-20 text-center animate-fade-in px-4">
                        <div class="inline-block p-10 bg-white/5 border border-white/10 rounded-[2.5rem] backdrop-blur-md shadow-2xl relative overflow-hidden group max-w-lg w-full">
                            <!-- Background Decor -->
                            <div class="absolute -top-24 -right-24 w-48 h-48 bg-pink-600/10 blur-3xl rounded-full transition-transform duration-1000 group-hover:scale-150"></div>
                            
                            <div class="relative z-10 flex flex-col items-center">
                                <div class="w-20 h-20 bg-pink-600/10 rounded-3xl flex items-center justify-center mb-6 border border-pink-500/20 animate-bounce-slow">
                                    <svg class="w-10 h-10 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                </div>
                                <h3 class="text-3xl font-black italic uppercase tracking-tighter text-white mb-2">No posts exists at the moment</h3>
                                <p class="text-gray-400 text-sm font-bold uppercase tracking-widest mb-8 max-w-xs mx-auto leading-relaxed">Be the first to share your festival magic with the community!</p>
                                <button onclick="document.getElementById('open_sidebar').click()" class="w-full bg-gradient-to-r from-pink-600 to-purple-600 hover:from-pink-500 hover:to-purple-500 text-white text-sm font-black uppercase tracking-[0.2em] py-4 rounded-2xl shadow-xl shadow-pink-600/20 active:scale-95 transition-all duration-300">
                                    Share Something
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                lastFetchedDataHash = null;
                return;
            }

            const dataHash = JSON.stringify(posts.map(p => ({
                id: p.id,
                cat: p.category,
                body: p.post,
                updated: p.updated_at,
                img_count: p.images ? p.images.length : 0
            })));

            const isSameContent = dataHash === lastFetchedDataHash;

            if (!isSameContent) {
                lastFetchedDataHash = dataHash;
                feed.innerHTML = '';
            }

            posts.forEach(post => {
                const isOwnPost = post.user_id === currentUserId;
                const lastSeen = post.user && post.user.last_seen_at ? new Date(post.user.last_seen_at) : null;
                const isOnline = lastSeen && (new Date() - lastSeen < 120000);
                const statusColor = isOnline ? 'bg-green-500 shadow-[0_0_10px_rgba(34,197,94,0.5)]' : 'bg-red-500';

                const existingCard = document.getElementById(`post-${post.id}`);

                if (existingCard) {
                    const circle = existingCard.querySelector('.status-circle');
                    if (circle) circle.className = `absolute -bottom-1 -right-1 w-3 h-3 rounded-full border-2 border-black status-circle ${statusColor}`;
                    if (isSameContent) return; // Skip rebuild if same content and card exists
                }

                const card = existingCard || document.createElement('div');
                card.id = `post-${post.id}`;
                if (!existingCard) {
                    card.className = 'chat-bubble-container flex gap-4 w-full items-start animate-fade-in-up mb-6 transition-all duration-1000';
                }

                // Get images array or fallback to mc_image
                const images = post.images || (post.mc_image ? [post.mc_image] : []);

                let imagesHtml = '';
                if (images.length > 0) {
                    imagesHtml = `<div class="flex flex-wrap gap-3 mt-4">`;
                    images.forEach(img => {
                        const imgSrc = img.startsWith('http') ? img : `/${img}`;
                        imagesHtml += `
                            <div class="thumbnail-item group relative">
                                <div class="w-20px h-20px  
                                overflow-hidden rounded-xl 
                                border border-white/10 cursor-pointer 
                                hover:border-pink-500/50 transition duration-300">
                                    <img src="${imgSrc}" onclick="openImage('${imgSrc}')" 
                                         class="w-full h-full object-cover">
                                </div>                               
                            </div>
                        `;
                    });
                    imagesHtml += `</div>`;
                }

                const replyingTo = post.reply_to_post_id ? `<span class="text-[10px] text-pink-400 font-bold mt-1">replying to <a href="#post-${post.reply_to_post_id}" class="hover:underline">post #${post.reply_to_post_id}</a></span>` : '';

                card.innerHTML = `
                    <div class="flex flex-col items-center justify-between self-stretch flex-shrink-0 pb-2">
                        <div class="relative">
                            <div class="w-10 h-10 md:w-12 md:h-12 rounded-full bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center text-sm font-bold shadow-lg">
                                ${post.user ? post.user.name.charAt(0) : '?'}
                            </div>
                            <div class="absolute -bottom-1 -right-1 w-3 h-3 rounded-full border-2 border-black status-circle ${statusColor}"></div>
                        </div>
                        <div class="flex flex-col items-center gap-1">
                            ${isOwnPost ? `
                                <button onclick="editPost(${post.id}, '${post.category}', '${post.festival}', \`${(post.post || '').replace(/`/g, '\\`').replace(/\$/g, '\\$')}\`)" class="text-gray-500 hover:text-blue-500 transition-colors p-2 rounded-full hover:bg-blue-500/10" title="Edit Post">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                            ` : ''}
                            <button onclick="openReply(${post.id}, '${post.user ? post.user.name : 'Unknown'}', '${post.festival}')" class="text-gray-500 hover:text-pink-500 transition-colors p-2 rounded-full hover:bg-pink-500/10" title="Reply to Post">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                                </svg>
                            </button>
                            ${(isOwnPost || userRole === 'admin') ? `
                                <button onclick="deletePost(${post.id}, ${post.comments_count || 0})" class="text-gray-500 hover:text-red-500 transition-colors p-2 rounded-full hover:bg-red-500/10" title="Delete Post">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            ` : ''}
                            ${(userRole === 'moderator' || userRole === 'admin') ? `
                                <button onclick="openModFlagModal(${post.id})" class="text-gray-500 hover:text-pink-500 transition-colors p-2 rounded-full hover:bg-pink-500/10" title="Flag Post">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9" />
                                    </svg>
                                </button>
                            ` : ''}
                        </div>
                    </div>
                    <div class="flex-grow bg-white/5 border border-white/10 rounded-2xl p-6 relative bubble-tail shadow-lg">
                        <div class="flex justify-between items-start mb-2">
                            <div class="flex items-center">
                                <span class="text-pink-500 text-xs font-black uppercase tracking-widest italic">${post.category || 'Chat'}</span>
                            </div>
                            <span class="bg-white/5 px-2 py-1 rounded text-[10px] text-gray-500 uppercase font-bold tracking-widest">${post.festival}</span>
                        </div>
                        <p class="text-gray-200 text-sm md:text-base leading-relaxed break-words post-body">${parseTags(post.post)}</p>
                        ${imagesHtml}
                        <div class="flex items-center justify-between pt-4 mt-4 border-t border-white/5">
                            <div class="flex flex-col">
                                <div class="flex items-center gap-2 group/user relative">
                                    <a href="/profile/${post.user ? post.user.name : ''}" 
                                    class="text-[11px] font-bold ${(post.user.role === 'moderator' || post.user.role === 'admin') ? 'text-purple-500' : 'text-gray-400'} 
                                    uppercase tracking-wider hover:text-white transition">
                                    ${post.user ? post.user.name : 'Unknown'}
                                    ${post.user.role === 'moderator' ? ' (Moderator)' : ''}
                                    ${post.user.role === 'admin' ? ' (Admin)' : ''}
                                    </a>
                                    ${post.user_id !== currentUserId ? `
                                        <button onclick="initiateMessage(${post.user_id}, '${post.user ? post.user.name : 'User'}')" 
                                            class="opacity-0 group-hover/user:opacity-100 transition-opacity p-1 hover:bg-white/10 rounded text-pink-500" 
                                            title="Message ${post.user ? post.user.name : 'User'}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                            </svg>
                                        </button>
                                    ` : ''}
                                </div>
                                ${replyingTo}
                            </div>
                            <span class="text-[10px] text-gray-600 font-mono italic">${new Date(post.created_at).toLocaleString([], { month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' })}</span>
                        </div>
                    </div>
                `;
                if (!existingCard) feed.appendChild(card);
            });
        };

        const renderPagination = (data) => {
            if (!data.data || data.total === 0) {
                paginationContainer.innerHTML = '';
                return;
            }

            let html = '';

            // Previous Button
            if (data.current_page > 1) {
                html += `<button onclick="changePage(${data.current_page - 1})" class="px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 rounded-lg transition text-sm font-bold">PREV</button>`;
            }

            // Current Page Indicator (Always show if posts exist)
            html += `<span class="px-4 py-2 bg-pink-600/20 text-pink-400 border border-pink-500/30 rounded-lg text-sm font-bold">PAGE ${data.current_page} OF ${data.last_page}</span>`;

            // Next Button
            if (data.current_page < data.last_page) {
                html += `<button onclick="changePage(${data.current_page + 1})" class="px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 rounded-lg transition text-sm font-bold">NEXT</button>`;
            }

            paginationContainer.innerHTML = html;
        };

        window.changePage = (page) => {
            currentPage = page;
            fetchPosts();
            feed.scrollTo({ top: 0, behavior: 'smooth' });
        };

        window.deletePost = async (id, commentCount) => {
            if (commentCount > 0) {
                if (!confirm('Warning: This post has comments. Deleting it will remove all discussion and notify everyone who commented. Are you sure?')) return;
            }
            if (!confirm('Are you sure you want to delete this post? This cannot be undone.')) return;

            try {
                const res = await fetch(`/delete_post/${id}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                const data = await res.json();
                if (data.status === 'success') {
                    // Success visual feedback
                    const el = document.getElementById(`post-${id}`);
                    if (el) {
                        el.classList.add('scale-0', 'opacity-0');
                        setTimeout(() => fetchPosts(), 500);

                        // Small success overlay
                        const toast = document.createElement('div');
                        toast.className = 'fixed top-10 left-1/2 -translate-x-1/2 bg-green-500 text-white px-6 py-3 rounded-full flex items-center gap-2 shadow-2xl z-[9999] animate-bounce';
                        toast.innerHTML = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg> Post Deleted Successfully`;
                        document.body.appendChild(toast);
                        setTimeout(() => toast.remove(), 3000);
                    } else {
                        fetchPosts();
                    }
                } else {
                    alert(data.message || 'Failed to delete post.');
                }
            } catch (e) {
                console.error("Delete error:", e);
                alert('An error occurred while deleting the post.');
            }
        };

        window.editPost = (id, category, festival, body) => {
            editingPostId = id;
            document.getElementById('form_title').innerText = "Edit Post";
            document.getElementById('submit_share_btn').innerText = "UPDATE POST";
            form.querySelector('select[name="category"]').value = category;
            form.querySelector('select[name="festival"]').value = festival;
            form.querySelector('textarea').value = body;
            sidebar.classList.remove('translate-x-full');
        };

        window.openReply = (postId, username, festival) => {
            document.getElementById('reply_to_post_id').value = postId;
            form.querySelector('select[name="category"]').value = "Reply";
            if (festival) {
                form.querySelector('select[name="festival"]').value = festival;
            }
            const textarea = form.querySelector('textarea');
            textarea.value = `@${username} `;
            sidebar.classList.remove('translate-x-full');
            textarea.focus();
        };


        // Form Submission
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const btn = document.getElementById('submit_share_btn');
            btn.disabled = true;
            btn.innerText = "POSTING...";

            const formData = new FormData(form);
            const url = editingPostId ? `/update_post/${editingPostId}` : '/submit_post';

            try {
                const res = await fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                const data = await res.json();
                if (data.status === 'success') {
                    form.reset();
                    editingPostId = null;
                    document.getElementById('form_title').innerText = "Post to Share Zone";
                    document.getElementById('submit_share_btn').innerText = "POST NOW";
                    document.getElementById('reply_to_post_id').value = '';
                    imgLabel.innerText = "Click to upload images (up to 5)";
                    imgLabel.classList.remove('text-pink-400', 'text-red-400');
                    sidebar.classList.add('translate-x-full');
                    currentPage = 1; // Reset to page 1 to see new post
                    fetchPosts(); // Immediate refresh
                } else {
                    console.error("Submission error details:", data);
                    alert('Error: ' + (data.message || 'Submission failed') + (data.error ? '\n\n' + data.error : ''));
                }
            } catch (e) {
                console.error("Fetch error:", e);
                alert("Error posting your moment. Check console for details.");
            } finally {
                btn.disabled = false;
                btn.innerText = "POST NOW";
            }
        });

        window.openModFlagModal = (id) => {
            document.getElementById('flag_target_id').value = id;
            document.getElementById('mod_flag_modal').classList.remove('hidden');
        };

        window.closeModFlagModal = () => {
            document.getElementById('mod_flag_modal').classList.add('hidden');
        };

        document.getElementById('mod_flag_form')?.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(e.target);
            const btn = e.target.querySelector('button[type="submit"]');
            btn.disabled = true;
            btn.innerText = "FLAGGING...";

            try {
                const res = await fetch('/flag', {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                });
                const data = await res.json();
                if (data.status === 'success') {
                    alert('Post flagged for admin review.');
                    closeModFlagModal();
                } else {
                    alert(data.message);
                }
            } catch (err) { alert("Error flagging post"); }
            finally {
                btn.disabled = false;
                btn.innerText = "SUBMIT FLAG";
            }
        });

        // Start Polling
        fetchPosts().then(() => {
            // Handle direct edit from Profile
            const params = new URLSearchParams(window.location.search);
            if (params.get('edit') === 'true' && params.get('post')) {
                const postId = params.get('post');
                const post = allPosts.find(p => p.id == postId);
                if (post) {
                    window.editPost(post.id, post.category, post.festival, post.post);
                }
            }

            // Scroll to post if deep linked
            const postId = params.get('post');
            if (postId) {
                setTimeout(() => {
                    const el = document.getElementById(`post-${postId}`);
                    if (el) {
                        el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        el.classList.add('ring-2', 'ring-pink-500', 'ring-offset-4', 'ring-offset-black', 'rounded-2xl');
                        setTimeout(() => el.classList.remove('ring-2', 'ring-pink-500', 'ring-offset-4', 'ring-offset-black'), 3000);
                    }
                }, 500);
            }
        });

        setInterval(() => {
            if (currentPage === 1) fetchPosts(); // Only auto-poll on page 1
        }, 5000);

        // --- Messaging Logic ---
        window.initiateMessage = (userId, userName) => {
            document.getElementById('msg_receiver_id').value = userId;
            document.getElementById('msg_target_name').innerText = userName;
            document.getElementById('private_message_modal').classList.remove('hidden');
        };

        window.closeMessageModal = () => {
            document.getElementById('private_message_modal').classList.add('hidden');
            document.getElementById('private_message_form').reset();
        };

        document.getElementById('private_message_form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const form = e.target;
            const btn = form.querySelector('button[type="submit"]');
            btn.disabled = true;
            btn.innerText = "SENDING...";

            const formData = new FormData(form);

            try {
                const res = await fetch('/send_message', {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                });
                const data = await res.json();
                if (data.status === 'success') {
                    alert('Message sent successfully!');
                    closeMessageModal();
                } else {
                    alert(data.message || 'Failed to send message.');
                }
            } catch (err) {
                console.error(err);
                alert("Error sending message.");
            } finally {
                btn.disabled = false;
                btn.innerText = "SEND MESSAGE";
            }
        });
    });
</script>

<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: rgba(236, 72, 153, 0.5);
    }

    .bubble-tail::before {
        content: '';
        position: absolute;
        left: -10px;
        top: 20px;
        width: 0;
        height: 0;
        border-top: 10px solid transparent;
        border-bottom: 10px solid transparent;
        border-right: 10px solid rgba(255, 255, 255, 0.05);
    }

    .chat-bubble-container:hover .bubble-tail::before {
        border-right-color: rgba(255, 255, 255, 0.1);
    }

    .thumbnail-preview {
        pointer-events: none;
    }

    /* Full width adjustment */
    #share_zone_feed {
        width: 100%;
    }

    .bubble-tail {
        max-width: calc(100% - 60px);
    }

    #image_lightbox {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    #image_lightbox:not(.hidden) {
        display: flex;
    }

    .lightbox-content-container {
        pointer-events: none;
    }

    .thumbnail-item img {
        display: block;
        width: 100%;
        height: 100%;
    }

    @keyframes fade-in-up {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in-up {
        animation: fade-in-up 0.6s ease-out forwards;
    }
</style>
@stop