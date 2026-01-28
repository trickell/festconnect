@extends('layouts.master')

@section('title', 'Fest Connection || Reconnections')

@section('content')
<div class="relative min-h-screen flex flex-col items-center justify-center overflow-hidden">
    <!-- Video Background -->
    <x-video-background source="img/video/reconnections_bg.mp4" />

    <!-- Flag Modal (Moderator Only) -->
    <div id="mod_flag_modal"
        class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-black/90 backdrop-blur-md p-4">
        <div class="bg-gray-900 border border-white/10 rounded-3xl w-full max-w-lg p-8 shadow-2xl animate-fade-in-up">
            <h2 class="text-2xl font-bold mb-6 text-pink-400 italic uppercase">Flag Target</h2>
            <form id="mod_flag_form" class="space-y-6">
                <input type="hidden" name="target_id" id="flag_target_id">
                <input type="hidden" name="target_type" id="flag_target_type">

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

    <!-- Main Content -->
    <div class="relative z-10 container mx-auto px-4 py-12 flex flex-col items-center max-w-4xl">

        <!-- Loading State -->
        <div class="loader z-50 hidden absolute inset-0 bg-black/50 flex items-center justify-center">
            <div class="animate-spin rounded-full h-16 w-16 border-t-2 border-b-2 border-purple-500"></div>
        </div>

        <a href="{{ url('share_zone') }}"
            class="relative w-1/2 h-10 rounded-full bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center text-sm font-bold shadow-lg mb-10">
            Visit Festival Share Zone
        </a>

        <!-- Landing View -->
        <div id="rec_landing" class="flex flex-col items-center text-center space-y-8 animate-fade-in">

            <h1
                class="text-4xl md:text-6xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-400 drop-shadow-sm">
                Make a Connection
            </h1>

            <div class="bg-white/10 backdrop-blur-md border border-white/20 p-6 md:p-8 rounded-2xl shadow-xl max-w-2xl">
                <p class="text-gray-200 text-lg leading-relaxed mb-4">
                    Have you ever met someone at a festival and felt a connection, but didn't get their contact
                    information?
                    <span class="block mt-2 font-semibold text-white">Fest Connection is here to help you find that
                        missed connection.</span>
                </p>
                <p class="text-gray-300 text-sm">
                    Fill out a little bit of information about the connection you're looking for and yourself. We'll do
                    our best to help!
                </p>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 w-full justify-center">
                <button
                    class="submitMissedConnections w-full sm:w-auto px-8 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-bold rounded-lg shadow-lg transform hover:scale-105 transition-all">
                    Submit a Connection
                </button>
                <button
                    class="viewMissedConnections w-full sm:w-auto px-8 py-3 bg-white/10 hover:bg-white/20 border border-white/30 text-white font-bold rounded-lg shadow-lg backdrop-blur-sm transition-all">
                    View Posts
                </button>
            </div>
        </div>

        <!-- Form View (Hidden Default) -->
        <div id="rec_form" class="hidden w-full max-w-2xl">
            <div class="bg-white/10 backdrop-blur-md border border-white/20 p-8 rounded-2xl shadow-2xl">
                <h3 class="text-2xl font-bold text-white mb-6 text-center">Tell us about them</h3>

                <form id="missed_connection_form" class="space-y-6">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ optional(session('user'))->id }}">

                    <div class="space-y-2">
                        <label for="festival_name"
                            class="block text-purple-300 font-semibold text-sm uppercase tracking-wide">Festival
                            Name</label>
                        <select id="festival_name" name="festival"
                            class="w-full px-4 py-3 rounded-lg bg-black/40 border border-white/10 text-white focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition"
                            required>
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

                    <div class="space-y-2">
                        <label for="missedConnection"
                            class="block text-purple-300 font-semibold text-sm uppercase tracking-wide">Who was
                            it?</label>
                        <textarea id="missedConnection" name="missed_conn"
                            class="w-full px-4 py-3 rounded-lg bg-black/40 border border-white/10 text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition h-24"
                            placeholder="Detailed description of the person..." required></textarea>
                    </div>

                    <div class="space-y-2">
                        <label for="optConnectImg"
                            class="block text-purple-300 font-semibold text-sm uppercase tracking-wide">Upload Image
                            (Optional)</label>
                        <input type="file" id="optConnectImg" name="optConnectImg"
                            class="w-full px-4 py-3 rounded-lg bg-black/40 border border-white/10 text-gray-300 focus:outline-none transition file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-purple-600 file:text-white hover:file:bg-purple-700"
                            accept="image/*,.pdf">
                    </div>

                    <div class="space-y-2">
                        <label for="description"
                            class="block text-purple-300 font-semibold text-sm uppercase tracking-wide">How we
                            met</label>
                        <textarea id="description" name="post"
                            class="w-full px-4 py-3 rounded-lg bg-black/40 border border-white/10 text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition h-32"
                            placeholder="Where in the festival? What happened?" required></textarea>
                    </div>



                    <div class="flex flex-col space-y-4 pt-4">
                        <p class="text-xs text-gray-500 text-center italic">After submitting, you will be able to see
                            other posts.</p>
                        <div class="flex gap-4">
                            <button type="submit"
                                class="flex-1 py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-bold rounded-lg shadow-lg transform hover:scale-[1.02] transition-all">
                                Submit
                            </button>
                            <button type="button"
                                class="viewMissedConnections flex-1 py-3 bg-gray-600 hover:bg-gray-700 text-white font-bold rounded-lg shadow-lg transition-all">Cancel
                                / View Posts</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Posts View (Hidden Default) -->
        <div id="rec_posts" class="hidden w-full max-w-5xl">
            <div
                class="bg-white/10 backdrop-blur-md border border-white/20 p-6 rounded-2xl shadow-xl flex justify-between items-center mb-6">
                <h2 class="text-2xl md:text-3xl font-bold text-white">Recent Posts</h2>
                <button
                    class="submitMissedConnections px-6 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-full text-sm font-bold transition shadow-lg">
                    + New Post
                </button>
            </div>

            <div class="filter mb-6 flex justify-end animate-fade-in">
                <select id="festival_filter"
                    class="px-4 py-2 bg-white/10 border border-white/20 rounded-lg text-white text-sm focus:outline-none focus:border-purple-500 transition">
                    <option value="all">All Festivals</option>
                    <option value="lostLands">Lost Lands</option>
                    <option value="electricforest">Electric Forest</option>
                    <option value="solfest">Sol Fest</option>
                    <option value="edc">Electric Daisy Carnival</option>
                    <option value="umf">Ultra Music Festival</option>
                    <option value="louderthanlife">Louder Than Life</option>
                    <option value="aftershock">Aftershock</option>
                    <option value="bourbonandbeyond">Bourbon And Beyond</option>
                    <option value="lollapalooza">Lollapalooza</option>
                    <option value="Bonnaroo">Bonnaroo</option>
                    <option value="coachella">Coachella</option>
                    <option value="other">Other</option>
                </select>
            </div>

            <div class="body grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Posts will be injected here via JS -->
            </div>
        </div>

        <!-- Post Detail View (Hidden Default) -->
        <div id="rec_post_detail" class="hidden w-full max-w-4xl animate-fade-in">
            <!-- Header Controls -->
            <div class="flex justify-between items-center mb-6">
                <button id="close_detail_btn"
                    class="px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-lg flex items-center transition space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Back to Posts</span>
                </button>

                <div id="detail_auth_controls" class="hidden flex gap-3">
                    <!-- Edit Button -->
                    <button id="edit_post_btn"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg flex items-center transition space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        <span>Edit</span>
                    </button>
                    <!-- Delete Button -->
                    <button id="delete_post_btn"
                        class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg flex items-center transition space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        <span>Delete</span>
                    </button>
                </div>
            </div>

            <!-- Post Content -->
            <div id="detail_content"
                class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-6 md:p-8 shadow-2xl mb-8">
                <!-- Content injected via JS -->
            </div>

            <!-- Comments Section -->
            <div class="bg-black/40 backdrop-blur-sm border border-white/10 rounded-2xl p-6 md:p-8">
                <h3 class="text-xl font-bold text-white mb-6">Comments</h3>

                @if(session('user'))
                    <!-- Comment Form -->
                    <form id="comment_form" class="mb-8">
                        @csrf
                        <input type="hidden" name="post_id" id="detail_post_id">
                        <input type="hidden" name="parent" id="detail_parent_id"> <!-- For replies -->
                        <div class="flex gap-4">
                            <textarea name="comment"
                                class="w-full px-4 py-3 rounded-lg bg-white/5 border border-white/10 text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 transition"
                                placeholder="Write a comment..." rows="2" required></textarea>
                            <button type="submit"
                                class="px-6 py-2 bg-purple-600 hover:bg-purple-700 text-white font-bold rounded-lg shadow-lg self-start whitespace-nowrap transition">Post</button>
                        </div>
                        <div id="replying_to_notice"
                            class="hidden text-sm text-purple-300 mt-2 flex justify-between items-center">
                            <span>Replying to a comment...</span>
                            <button type="button" id="cancel_reply" class="text-gray-400 hover:text-white underline">Cancel
                                Reply</button>
                        </div>
                    </form>
                @else
                    <div class="mb-8 p-4 bg-purple-900/30 border border-purple-500/30 rounded-lg text-center">
                        <p class="text-purple-200">Please <a href="{{ url('/login') }}"
                                class="text-white font-bold hover:underline">log in</a> to leave a comment.</p>
                    </div>
                @endif

                <!-- Comments List -->
                <div id="comments_container" class="space-y-4 max-h-[600px] overflow-y-auto pr-2 custom-scrollbar">
                    <!-- Comments injected via JS -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const landing = document.getElementById('rec_landing');
        const formDiv = document.getElementById('rec_form');
        const postsDiv = document.getElementById('rec_posts');
        const detailDiv = document.getElementById('rec_post_detail');
        const form = document.getElementById('missed_connection_form');
        const postsContainer = postsDiv.querySelector('.body');
        const filterSelect = document.getElementById('festival_filter');

        // Detail Elements
        const closeDetailBtn = document.getElementById('close_detail_btn');
        const detailContent = document.getElementById('detail_content');
        const commentsContainer = document.getElementById('comments_container');
        const commentForm = document.getElementById('comment_form');
        const detailPostIdInput = document.getElementById('detail_post_id');
        const detailParentIdInput = document.getElementById('detail_parent_id');
        const replyingToNotice = document.getElementById('replying_to_notice');
        const cancelReplyBtn = document.getElementById('cancel_reply');

        const parseTags = (text) => {
            if (!text) return '';
            return text.replace(/@(\w+)/g, '<a href="/profile/$1" class="text-purple-400 font-bold hover:underline">@$1</a>');
        };

        const currentUserId = {{ optional(session('user'))->id ?? 'null' }};
        const userRole = '{{ optional(session('user'))->role ?? 'user' }}';
        let editingPostId = null;
        let currentDetailPost = null;
        let allPosts = []; // Store fetched posts for filtering

        const updatePresence = async () => {
            try {
                await fetch('/update_presence', {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                });
            } catch (e) { }
        };

        // --- View Switching Logic ---
        const hideAllViews = () => {
            landing.classList.add('hidden');
            postsDiv.classList.add('hidden');
            formDiv.classList.add('hidden');
            detailDiv.classList.add('hidden');
        };

        const switchToForm = (editData = null) => {
            hideAllViews();
            if (editData && editData.id) {
                editingPostId = editData.id;
                formDiv.querySelector('h3').innerText = "Edit your connection";
                formDiv.querySelector('button[type="submit"]').innerText = "Update Post";
                form.querySelector('select[name="festival"]').value = editData.festival;
                form.querySelector('textarea[name="missed_conn"]').value = editData.missed_conn;
                form.querySelector('textarea[name="post"]').value = editData.post;
                // We no longer manually set name/email here as they are handled by session
            } else {
                editingPostId = null;
                formDiv.querySelector('h3').innerText = "Tell us about them";
                formDiv.querySelector('button[type="submit"]').innerText = "Submit";
                form.reset();
            }
            formDiv.classList.remove('hidden');
        };

        const switchToPosts = () => {
            hideAllViews();
            postsDiv.classList.remove('hidden');
            // Also reset filter if desired, or keep it
        };

        const switchToDetail = () => {
            hideAllViews();
            detailDiv.classList.remove('hidden');
        };

        // --- Data Fetching Logic ---
        const fetchAndRenderPosts = async () => {
            try {
                // postsContainer.innerHTML = '<div class="col-span-full text-center text-white">Loading...</div>';
                const response = await fetch('/get_posts');
                allPosts = await response.json();
                applyFilterAndRender();
            } catch (error) {
                console.error('Error fetching posts:', error);
                postsContainer.innerHTML = '<p class="text-white text-center col-span-full">Failed to load posts.</p>';
            }
        };

        const applyFilterAndRender = () => {
            const filterValue = filterSelect.value;
            let filtered = allPosts;

            if (filterValue !== 'all') {
                filtered = allPosts.filter(p => p.festival === filterValue);
            }

            // Sort newest first
            filtered.sort((a, b) => b.id - a.id);
            renderPosts(filtered);
        };

        const renderPosts = (posts) => {
            postsContainer.innerHTML = '';

            if (!posts || posts.length === 0) {
                postsContainer.innerHTML = '<p class="text-white text-center col-span-full opacity-70">No connections found.</p>';
                return;
            }

            posts.forEach(post => {
                const imageUrl = post.mc_image ? `/${post.mc_image}` : 'https://images.unsplash.com/photo-1493225255756-d9584f8606e9?auto=format&fit=crop&q=80&w=2070';

                const card = document.createElement('div');
                card.className = 'bg-white/5 backdrop-blur-md border border-white/10 rounded-xl overflow-hidden hover:bg-white/10 transition duration-300 animate-fade-in-up cursor-pointer';
                card.innerHTML = `
                    <div class="relative h-48 w-full group overflow-hidden">
                        <img src="${imageUrl}" alt="Post Image" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        <div class="absolute top-2 right-2 bg-purple-600/80 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold text-white uppercase tracking-wider shadow-sm">
                            ${post.festival || 'Festival'}
                        </div>
                    </div>
                    <div class="p-5">
                        <div class="flex items-center gap-2 mb-2">
                            <a href="/profile/${post.user ? post.user.name : ''}" class="text-lg font-bold text-white line-clamp-1 hover:text-purple-300 transition">${post.user ? post.user.name : 'Someone'} is looking...</a>
                            <div class="w-2.5 h-2.5 rounded-full ${post.user && post.user.last_seen_at && (new Date() - new Date(post.user.last_seen_at) < 60000) ? 'bg-green-500 shadow-[0_0_8px_rgba(34,197,94,0.5)]' : 'bg-red-500'}"></div>
                        </div>
                        <p class="text-gray-300 text-sm line-clamp-3 leading-relaxed mb-4">${parseTags(post.missed_conn || post.post)}</p>
                        
                        <div class="pt-4 border-t border-white/10 flex justify-between items-center text-xs text-gray-400">
                            <span>${new Date(post.created_at).toLocaleDateString()}</span>
                            <div class="flex items-center gap-2">
                                ${userRole === 'admin' ? `
                                    <button onclick="event.stopPropagation(); deleteAdminPost(${post.id})" class="text-red-500 hover:text-red-400 transition pr-2 border-r border-white/10">Delete Admin</button>
                                ` : ''}
                                ${(userRole === 'moderator' || userRole === 'admin') ? `
                                    <button onclick="event.stopPropagation(); openModFlagModal(${post.id}, 'post')" class="text-pink-500 hover:text-pink-400 transition pr-2 border-r border-white/10">Flag</button>
                                ` : ''}
                                <span class="text-purple-300 group-hover:text-purple-200 transition">Read More &rarr;</span>
                            </div>
                        </div>
                    </div>
                `;

                // Click to view detail
                card.addEventListener('click', () => openPostDetail(post));
                postsContainer.appendChild(card);
            });
        };

        // --- Detail View Logic ---
        const openPostDetail = async (post) => {
            currentDetailPost = post;
            // Render Post Content
            const imageUrl = post.mc_image ? `/${post.mc_image}` : 'https://images.unsplash.com/photo-1493225255756-d9584f8606e9?auto=format&fit=crop&q=80&w=2070';

            // Show auth controls if it's the user's post
            const authControls = document.getElementById('detail_auth_controls');
            if (authControls) {
                authControls.classList.toggle('hidden', post.user_id !== currentUserId);
            }

            detailContent.innerHTML = `
                <div class="flex flex-col md:flex-row gap-6 md:gap-8">
                    <div class="w-full md:w-1/2 rounded-xl overflow-hidden shadow-lg h-64 md:h-96">
                        <img src="${imageUrl}" class="w-full h-full object-cover">
                    </div>
                    <div class="w-full md:w-1/2 flex flex-col justify-center">
                        <div class="inline-block self-start bg-purple-600 px-3 py-1 rounded-full text-xs font-bold text-white uppercase tracking-wider mb-4">
                            ${post.festival}
                        </div>
                        <h2 class="text-3xl font-bold text-white mb-4">Looking for: <span class="text-purple-300">${parseTags(post.missed_conn)}</span></h2>
                        <div class="prose prose-invert">
                            <p class="text-gray-300 text-lg leading-relaxed mb-6">${parseTags(post.post)}</p>
                        </div>
                        <div class="mt-auto pt-4 border-t border-white/10 text-sm text-gray-400">
                            Posted by <a href="/profile/${post.user ? post.user.name : ''}" class="text-white font-semibold hover:text-purple-300 transition">${post.user ? post.user.name : 'Unknown'}</a> on ${new Date(post.created_at).toLocaleDateString()}
                        </div>
                    </div>
                </div>
            `;

            // Setup Comment Form
            if (detailPostIdInput) {
                detailPostIdInput.value = post.id;
                detailParentIdInput.value = ''; // Reset parent
                replyingToNotice.classList.add('hidden');
            }

            // Switch view
            switchToDetail();

            // Fetch Comments
            fetchComments(post.id);
        };

        const fetchComments = async (postId) => {
            try {
                commentsContainer.innerHTML = '<p class="text-gray-400 text-center">Loading comments...</p>';
                const response = await fetch(`/get_comments/${postId}`);
                const comments = await response.json();
                renderComments(comments);
            } catch (error) {
                console.error(error);
                commentsContainer.innerHTML = '<p class="text-red-400 text-center">Failed to load comments.</p>';
            }
        };

        const renderComments = (comments) => {
            commentsContainer.innerHTML = '';
            if (!comments || comments.length === 0) {
                commentsContainer.innerHTML = '<p class="text-gray-400 text-center py-4">No comments yet.</p>';
                return;
            }

            const commentMap = {};
            const roots = [];

            // First pass: Build map
            comments.forEach(c => {
                c.children = [];
                commentMap[c.id] = c;
            });

            // Second pass: Build tree
            comments.forEach(c => {
                if (c.parent && commentMap[c.parent]) {
                    commentMap[c.parent].children.push(c);
                } else {
                    roots.push(c);
                }
            });

            const createCommentNode = (c, level = 0) => {
                const node = document.createElement('div');
                node.className = `bg-white/5 rounded-lg p-4 border border-white/5 ${level > 0 ? 'ml-6 md:ml-12 mt-2 border-l-2 border-l-purple-500/50' : ''}`;

                // Format relative time if possible or just use locale string
                const timeStr = new Date(c.created_at).toLocaleString([], { dateStyle: 'short', timeStyle: 'short' });

                node.innerHTML = `
                    <div class="flex justify-between items-start mb-2">
                         <a href="/profile/${c.user_name || ''}" class="font-bold text-purple-300 text-sm hover:text-white transition">${c.user_name || 'User'}</a>
                         <div class="flex items-center gap-3">
                            <span class="text-xs text-gray-500">${timeStr}</span>
                            ${userRole === 'admin' ? `
                                <button onclick="deleteAdminComment(${c.id})" class="text-red-500/50 hover:text-red-500 transition text-[10px] uppercase font-black uppercase tracking-widest">Delete</button>
                            ` : ''}
                            ${(userRole === 'moderator' || userRole === 'admin') ? `
                                <button onclick="openModFlagModal(${c.id}, 'user')" class="text-pink-500/50 hover:text-pink-500 transition text-[10px] uppercase font-black uppercase tracking-widest">Flag User</button>
                            ` : ''}
                         </div>
                    </div>
                    <p class="text-gray-200 text-sm mb-3">${parseTags(c.comment)}</p>
                    ${commentForm ? `<button class="text-xs text-gray-400 hover:text-white flex items-center gap-1 transition reply-btn" data-id="${c.id}" data-user="${c.user_name}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" /></svg> Reply
                    </button>` : ''}
                `;

                // Reply Action
                const replyBtn = node.querySelector('.reply-btn');
                if (replyBtn) {
                    replyBtn.addEventListener('click', () => {
                        detailParentIdInput.value = c.id;
                        replyingToNotice.classList.remove('hidden');
                        replyingToNotice.querySelector('span').innerText = `Replying to ${c.user_name}...`;
                        document.querySelector('textarea[name="comment"]').focus();
                        document.querySelector('textarea[name="comment"]').scrollIntoView({ behavior: 'smooth', block: 'center' });
                    });
                }

                return node;
            };

            const appendRecursive = (list, container, level) => {
                list.forEach(c => {
                    const el = createCommentNode(c, level);
                    container.appendChild(el);
                    if (c.children && c.children.length > 0) {
                        appendRecursive(c.children, container, level + 1);
                    }
                });
            };

            appendRecursive(roots, commentsContainer, 0);
        };

        // --- Event Listeners ---

        // Navigation
        const showPosts = () => {
            switchToPosts();
            fetchAndRenderPosts();
        };

        document.querySelectorAll('.submitMissedConnections').forEach(btn => {
            btn.addEventListener('click', () => switchToForm());
        });

        document.querySelectorAll('.viewMissedConnections').forEach(btn => {
            btn.addEventListener('click', showPosts);
        });

        if (closeDetailBtn) {
            closeDetailBtn.addEventListener('click', switchToPosts);
        }

        // Edit and Delete Detail Actions
        document.getElementById('edit_post_btn')?.addEventListener('click', () => {
            if (currentDetailPost) switchToForm(currentDetailPost);
        });

        document.getElementById('delete_post_btn')?.addEventListener('click', async () => {
            if (!currentDetailPost) return;

            const commentCount = currentDetailPost.comments_count || 0;
            if (commentCount > 0) {
                if (!confirm('Warning: This post has comments. Deleting it will remove all discussion and notify everyone who commented. Are you sure?')) return;
            }
            if (!confirm('Are you sure you want to delete this post? This cannot be undone.')) return;

            try {
                const res = await fetch(`/delete_post/${currentDetailPost.id}`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                });
                const data = await res.json();
                if (data.status === 'success') {
                    // Success symbol flash
                    const toast = document.createElement('div');
                    toast.className = 'fixed top-10 left-1/2 -translate-x-1/2 bg-green-500 text-white px-6 py-3 rounded-full flex items-center gap-2 shadow-2xl z-[9999] animate-bounce';
                    toast.innerHTML = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg> Post Removed Successfully`;
                    document.body.appendChild(toast);
                    setTimeout(() => toast.remove(), 3000);

                    showPosts();
                } else {
                    alert(data.message || 'Deletion failed');
                }
            } catch (e) {
                console.error(e);
                alert('An error occurred');
            }
        });

        // Cancel Reply
        if (cancelReplyBtn) {
            cancelReplyBtn.addEventListener('click', () => {
                detailParentIdInput.value = '';
                replyingToNotice.classList.add('hidden');
            });
        }

        // Filter Change
        if (filterSelect) {
            filterSelect.addEventListener('change', applyFilterAndRender);
        }

        // Initialize view
        if (window.location.hash === '#posts') {
            showPosts();
        }

        // --- Form Submissions ---

        // Post Submission
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerText;
            submitBtn.disabled = true;
            submitBtn.innerText = 'Submitting...';

            const formData = new FormData(form);
            const url = editingPostId ? `/update_post/${editingPostId}` : '/submit_post';

            try {
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value }
                });

                const data = await response.json();

                if (data.status === 'success') {
                    form.reset();
                    showPosts();
                } else {
                    alert('Error: ' + (data.message || 'Submission failed'));
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerText = originalText;
            }
        });

        // Comment Submission
        if (commentForm) {
            commentForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const submitBtn = commentForm.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerText;
                const postId = detailPostIdInput.value;

                submitBtn.disabled = true;
                submitBtn.innerText = '...';

                const formData = new FormData(commentForm);

                try {
                    const response = await fetch('/submit_comment', {
                        method: 'POST',
                        body: formData,
                        headers: { 'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value }
                    });

                    const data = await response.json();
                    if (data.status === 'success') {
                        commentForm.reset();
                        detailPostIdInput.value = postId; // Restore post id as reset clears it
                        detailParentIdInput.value = '';
                        replyingToNotice.classList.add('hidden');
                        fetchComments(postId); // Refresh comments
                    } else {
                        alert('Error: ' + (data.message || 'Comment failed'));
                    }
                } catch (error) {
                    console.error(error);
                    alert('Error posting comment');
                } finally {
                    submitBtn.disabled = false;
                    submitBtn.innerText = originalText;
                }
            });
        }

        window.deleteAdminPost = (id) => {
            if (!confirm("Admin: Permanent delete this post?")) return;
            // Existing delete logic is authorized for admin in controller
            deletePost(id);
        };

        window.deleteAdminComment = async (id) => {
            if (!confirm("Admin: Permanent delete this comment?")) return;
            try {
                const res = await fetch(`/admin/delete_comment/${id}`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                });
                const data = await res.json();
                if (data.status === 'success') {
                    if (currentDetailPost) fetchComments(currentDetailPost.id);
                } else {
                    alert(data.message);
                }
            } catch (err) { alert("Error deleting comment"); }
        };

        window.openModFlagModal = (id, type) => {
            document.getElementById('flag_target_id').value = id;
            document.getElementById('flag_target_type').value = type;
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
                    alert('Target flagged for admin review.');
                    closeModFlagModal();
                } else {
                    alert(data.message);
                }
            } catch (err) { alert("Error flagging target"); }
            finally {
                btn.disabled = false;
                btn.innerText = "SUBMIT FLAG";
            }
        });

        // Presence Polling
        updatePresence();
        setInterval(updatePresence, 20000);
    });
</script>
@stop