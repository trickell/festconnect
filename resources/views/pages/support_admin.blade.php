@extends('layouts.master')

@section('title', 'Admin Dashboard || Management')

@section('content')
<div class="relative min-h-screen py-24 bg-black text-white overflow-hidden" x-data="{ tab: 'tickets' }">
    <!-- Background Decor -->
    <!-- Video Background -->
    <x-video-background source="img/video/admin_bg.mp4" />

    <div
        class="absolute top-0 left-0 w-full h-[500px] bg-gradient-to-b from-indigo-900/20 to-transparent pointer-events-none">
    </div>

    <div class="relative z-10 container mx-auto px-4 max-w-6xl">
        <div class="flex flex-col md:flex-row justify-between items-center mb-12 gap-6">
            <div>
                <h1
                    class="text-4xl md:text-5xl font-black italic uppercase tracking-tighter bg-clip-text text-transparent bg-gradient-to-r from-indigo-400 to-purple-400">
                    Admin Dashboard
                </h1>
                <p class="text-gray-400 uppercase tracking-[0.2em] text-xs font-bold mt-2">Platform Control Center</p>
            </div>

            <div class="flex gap-4">
                <a href="{{ url('/profile/' . optional(session('user'))->name) }}"
                    class="px-6 py-2 bg-white/5 border border-white/10 rounded-xl hover:bg-white/10 transition text-sm font-bold uppercase tracking-widest">Back
                    to Profile</a>
            </div>
        </div>

        <!-- Tab Navigation -->
        <div class="flex flex-wrap gap-4 mb-10 border-b border-white/10 pb-6">
            <button @click="tab = 'tickets'"
                :class="tab === 'tickets' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20' : 'bg-white/5 text-gray-400 hover:bg-white/10'"
                class="px-8 py-3 rounded-2xl font-black uppercase tracking-widest transition text-xs">Support
                Tickets</button>
            <button @click="tab = 'users'; loadUsers();"
                :class="tab === 'users' ? 'bg-purple-600 text-white shadow-lg shadow-purple-500/20' : 'bg-white/5 text-gray-400 hover:bg-white/10'"
                class="px-8 py-3 rounded-2xl font-black uppercase tracking-widest transition text-xs">User
                Management</button>
            <button @click="tab = 'flags'; loadFlags();"
                :class="tab === 'flags' ? 'bg-pink-600 text-white shadow-lg shadow-pink-500/20' : 'bg-white/5 text-gray-400 hover:bg-white/10'"
                class="px-8 py-3 rounded-2xl font-black uppercase tracking-widest transition text-xs">Moderator
                Flags</button>
        </div>

        <!-- Tab Content: Support Tickets -->
        <div x-show="tab === 'tickets'" class="space-y-8 animate-fade-in-up">
            @forelse($tickets as $ticket)
                <div
                    class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-8 shadow-2xl transition hover:border-indigo-500/30">
                    <div class="flex flex-col lg:flex-row justify-between gap-8">
                        <div class="flex-grow space-y-4">
                            <div class="flex items-center gap-4 flex-wrap">
                                <span
                                    class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest 
                                            {{ $ticket->status === 'open' ? 'bg-green-500/20 text-green-400' : ($ticket->status === 'resolved' ? 'bg-blue-500/20 text-blue-400' : 'bg-gray-500/20 text-gray-400') }}">
                                    {{ $ticket->status }}
                                </span>
                                <span
                                    class="text-indigo-400 text-xs font-bold uppercase tracking-widest">{{ $ticket->subject }}</span>
                                <span
                                    class="text-gray-500 text-[10px] font-mono italic">{{ $ticket->created_at->diffForHumans() }}</span>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-white">{{ $ticket->name }} <span
                                        class="text-gray-500 text-sm font-normal">({{ $ticket->email }})</span></h3>
                            </div>
                            <div
                                class="bg-black/40 border border-white/5 rounded-2xl p-6 text-gray-300 leading-relaxed italic">
                                "{!! nl2br(e($ticket->message)) !!}"</div>
                            @if($ticket->admin_reply)
                                <div class="mt-6 border-t border-white/5 pt-6">
                                    <h4
                                        class="text-[10px] font-black uppercase tracking-[0.2em] text-purple-400 mb-3 flex items-center gap-2 italic">
                                        Admin Response</h4>
                                    <div
                                        class="text-gray-400 text-sm leading-relaxed bg-purple-500/5 rounded-xl p-4 border border-purple-500/10">
                                        {!! nl2br(e($ticket->admin_reply)) !!}
                                        <div class="text-[9px] mt-2 text-gray-600 uppercase font-bold tracking-widest">Replied
                                            on {{ $ticket->replied_at->format('M d, Y @ H:i') }}</div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="lg:w-80 flex flex-col gap-4">
                            @if($ticket->status === 'open')
                                <button onclick="openReplyModal({{ $ticket->id }}, '{{ $ticket->name }}')"
                                    class="w-full bg-indigo-600 hover:bg-indigo-500 py-4 rounded-2xl font-black uppercase tracking-widest transition shadow-lg text-sm">Reply
                                    to User</button>
                            @endif
                            <div class="grid grid-cols-2 gap-3">
                                <button onclick="updateTicketStatus({{ $ticket->id }}, 'resolved')"
                                    class="bg-blue-500/10 hover:bg-blue-500/20 py-3 rounded-xl text-[10px] font-bold uppercase tracking-widest text-blue-400 border border-blue-500/20">Resolve</button>
                                <button onclick="updateTicketStatus({{ $ticket->id }}, 'archived')"
                                    class="bg-white/5 hover:bg-white/10 py-3 rounded-xl text-[10px] font-bold uppercase tracking-widest text-gray-400 border border-white/5">Archive</button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div
                    class="py-20 text-center bg-white/5 rounded-3xl border border-dashed border-white/10 italic text-gray-500 uppercase tracking-widest font-bold">
                    No tickets found</div>
            @endforelse
        </div>

        <!-- Tab Content: User Management -->
        <div x-show="tab === 'users'" class="space-y-8 animate-fade-in-up" x-cloak>
            <div
                class="flex justify-between items-center bg-purple-600/10 border border-purple-500/20 p-6 rounded-3xl mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-purple-400">Total Community Members</h2>
                    <p class="text-gray-500 text-xs uppercase tracking-widest mt-1">Manage, update, and secure user
                        accounts</p>
                </div>
                <button onclick="openUserModal()"
                    class="bg-purple-600 hover:bg-purple-500 px-8 py-3 rounded-2xl font-black uppercase tracking-widest transition text-xs flex items-center gap-2 shadow-lg shadow-purple-500/20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg> Add New User
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="users_container">
                <!-- Loaded via JS -->
            </div>
        </div>

        <!-- Tab Content: Moderator Flags -->
        <div x-show="tab === 'flags'" class="space-y-8 animate-fade-in-up" x-cloak>
            <div
                class="flex justify-between items-center bg-pink-600/10 border border-pink-500/20 p-6 rounded-3xl mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-pink-400">Moderation Queue</h2>
                    <p class="text-gray-500 text-xs uppercase tracking-widest mt-1">Review activity reports from
                        moderators</p>
                </div>
            </div>
            <div class="space-y-6" id="flags_container">
                <!-- Loaded via JS -->
            </div>
        </div>
    </div>
</div>

<!-- Modals -->
<div id="reply_modal"
    class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/90 backdrop-blur-md p-4">
    <div class="bg-gray-900 border border-white/10 rounded-3xl w-full max-w-lg p-8 shadow-2xl animate-fade-in-up">
        <h2 id="modal_title" class="text-2xl font-bold mb-6 text-indigo-400 italic uppercase">Reply to Ticket</h2>
        <form id="reply_form" class="space-y-6">@csrf<input type="hidden" id="ticket_id">
            <div><label class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2">Message
                    Content</label><textarea name="reply" rows="6" required
                    class="w-full bg-black/40 border border-white/10 rounded-2xl p-4 text-gray-200 focus:outline-none focus:border-indigo-500 transition resize-none"
                    placeholder="Type your response to the user..."></textarea></div>
            <div class="flex gap-4"><button type="submit"
                    class="flex-1 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 py-4 rounded-2xl font-black uppercase tracking-widest transition text-sm shadow-xl">Send
                    Reply</button><button type="button" onclick="closeReplyModal()"
                    class="px-8 bg-white/5 hover:bg-white/10 py-4 rounded-2xl font-bold uppercase tracking-widest transition text-gray-400 text-sm">Cancel</button>
            </div>
        </form>
    </div>
</div>

<div id="user_modal"
    class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/90 backdrop-blur-md p-4">
    <div class="bg-gray-900 border border-white/10 rounded-3xl w-full max-w-xl p-8 shadow-2xl animate-fade-in-up">
        <h2 id="user_modal_title" class="text-2xl font-bold mb-6 text-purple-400 italic uppercase">Add New User</h2>
        <form id="user_form" class="space-y-4">
            @csrf
            <input type="hidden" id="edit_user_id">
            <div class="grid grid-cols-2 gap-4">
                <div><label
                        class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2">Username</label><input
                        type="text" name="name" required
                        class="w-full bg-black/40 border border-white/10 rounded-xl p-4 text-white focus:border-purple-500 outline-none">
                </div>
                <div><label
                        class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2">Email</label><input
                        type="email" name="email" required
                        class="w-full bg-black/40 border border-white/10 rounded-xl p-4 text-white focus:border-purple-500 outline-none">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div><label
                        class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2">Role</label><select
                        name="role"
                        class="w-full bg-black/40 border border-white/10 rounded-xl p-4 text-white focus:border-purple-500 outline-none">
                        <option value="user">User</option>
                        <option value="moderator">Moderator</option>
                        <option value="admin">Admin</option>
                    </select></div>
                <div><label class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2">Password
                        (Leave blank to keep current)</label><input type="password" name="password"
                        class="w-full bg-black/40 border border-white/10 rounded-xl p-4 text-white focus:border-purple-500 outline-none">
                </div>
            </div>
            <div class="flex gap-4 mt-6">
                <button type="submit"
                    class="flex-1 bg-purple-600 hover:bg-purple-500 py-4 rounded-2xl font-black uppercase tracking-widest transition text-sm shadow-xl">Save
                    User Data</button>
                <button type="button" onclick="closeUserModal()"
                    class="px-8 bg-white/5 hover:bg-white/10 py-4 rounded-2xl font-bold uppercase tracking-widest transition text-gray-400 text-sm">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Resolution Modal -->
<div id="flag_modal"
    class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/90 backdrop-blur-md p-4">
    <div class="bg-gray-900 border border-white/10 rounded-3xl w-full max-w-lg p-8 shadow-2xl animate-fade-in-up">
        <h2 id="flag_modal_title" class="text-2xl font-bold mb-6 text-pink-400 italic uppercase">Resolve Flag</h2>
        <form id="flag_form" class="space-y-6">@csrf<input type="hidden" id="resolve_flag_id">
            <div><label class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2">Action
                    Taken</label><select name="status"
                    class="w-full bg-black/40 border border-white/10 rounded-xl p-4 text-white focus:border-pink-500 outline-none">
                    <option value="cleared">Clear Flag (No problem)</option>
                    <option value="warned">Send Warning to User</option>
                    <option value="removed">Remove Content & Warn User</option>
                </select></div>
            <div><label class="block text-[10px] font-black uppercase tracking-widest text-gray-500 mb-2">Internal Admin
                    Comment / Warning Message</label><textarea name="admin_comment" rows="4" required
                    class="w-full bg-black/40 border border-white/10 rounded-2xl p-4 text-gray-200 focus:outline-none focus:border-pink-500 transition resize-none"></textarea>
            </div>
            <div class="flex gap-4 mt-6"><button type="submit"
                    class="flex-1 bg-pink-600 hover:bg-pink-500 py-4 rounded-2xl font-black uppercase tracking-widest transition text-sm shadow-xl">Execute
                    Action</button><button type="button" onclick="closeFlagModal()"
                    class="px-8 bg-white/5 hover:bg-white/10 py-4 rounded-2xl font-bold uppercase tracking-widest transition text-gray-400 text-sm">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
    // --- User Management ---
    async function loadUsers() {
        const res = await fetch('/admin/users');
        const users = await res.json();
        const container = document.getElementById('users_container');
        container.innerHTML = users.map(user => `
            <div class="bg-white/5 border border-white/10 rounded-3xl p-6 hover:border-purple-500/30 transition group relative overflow-hidden">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center font-bold text-lg uppercase">${user.name.charAt(0)}</div>
                    <div><h4 class="font-bold text-white group-hover:text-purple-400 transition">${user.name}</h4><p class="text-[10px] text-gray-500 font-mono tracking-tighter">${user.email}</p></div>
                </div>
                <div class="flex items-center justify-between mb-4"><span class="px-2 py-0.5 rounded text-[9px] font-black uppercase tracking-widest ${user.role === 'admin' ? 'bg-indigo-500/20 text-indigo-400' : (user.role === 'moderator' ? 'bg-purple-500/20 text-purple-400' : 'bg-gray-500/20 text-gray-500')}">${user.role}</span></div>
                <div class="flex gap-2">
                    <button onclick="editUser(${user.id}, '${user.name}', '${user.email}', '${user.role}')" class="flex-1 bg-white/5 hover:bg-purple-600/20 py-2 rounded-xl text-[9px] font-bold uppercase tracking-widest text-gray-400 hover:text-purple-400 border border-white/5 transition">Edit Profile</button>
                    ${user.name !== 'systemadmin' ? `<button onclick="deleteUser(${user.id})" class="bg-red-500/10 hover:bg-red-500/30 p-2 rounded-xl text-red-500 transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg></button>` : ''}
                </div>
            </div>
        `).join('');
    }

    function openUserModal() {
        document.getElementById('user_form').reset();
        document.getElementById('edit_user_id').value = '';
        document.getElementById('user_modal_title').innerText = "Add New User";
        document.getElementById('user_modal').classList.remove('hidden');
    }

    function editUser(id, name, email, role) {
        document.getElementById('edit_user_id').value = id;
        document.getElementById('user_form').querySelector('input[name="name"]').value = name;
        document.getElementById('user_form').querySelector('input[name="email"]').value = email;
        document.getElementById('user_form').querySelector('select[name="role"]').value = role;
        document.getElementById('user_modal_title').innerText = `Edit: ${name}`;
        document.getElementById('user_modal').classList.remove('hidden');
    }

    function closeUserModal() { document.getElementById('user_modal').classList.add('hidden'); }

    document.getElementById('user_form').addEventListener('submit', async (e) => {
        e.preventDefault();
        const id = document.getElementById('edit_user_id').value;
        const formData = new FormData(e.target);
        const url = id ? `/admin/users/${id}` : '/admin/users';
        try {
            const res = await fetch(url, { method: 'POST', body: formData });
            const data = await res.json();
            if (data.status === 'success') { loadUsers(); closeUserModal(); } else { alert(data.message); }
        } catch (err) { alert("Error saving user"); }
    });

    async function deleteUser(id) {
        if (!confirm("Warning: This will delete the user profile and all their data. Proceed?")) return;
        const res = await fetch(`/admin/users/delete/${id}`, { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });
        const data = await res.json();
        if (data.status === 'success') loadUsers(); else alert(data.message);
    }

    // --- Flag Management ---
    async function loadFlags() {
        const res = await fetch('/admin/flags');
        const flags = await res.json();
        const container = document.getElementById('flags_container');
        container.innerHTML = flags.map(flag => `
            <div class="bg-white/5 border ${flag.status === 'pending' ? 'border-pink-500/30' : 'border-white/10'} rounded-3xl p-6 transition group relative overflow-hidden shadow-xl">
                <div class="flex flex-col lg:flex-row justify-between gap-6">
                    <div class="flex-grow space-y-3">
                        <div class="flex items-center gap-3">
                            <span class="px-2 py-0.5 rounded text-[9px] font-black uppercase tracking-widest ${flag.type === 'good' ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-500'}">${flag.type} Flag</span>
                            <span class="text-gray-500 text-[10px] font-mono italic">by Moderator: ${flag.moderator ? flag.moderator.name : 'Unknown'}</span>
                            <span class="text-xs font-bold text-gray-400">Target: <span class="text-white">${flag.target_type} #${flag.target_id}</span></span>
                        </div>
                        <div class="bg-black/40 border border-white/5 rounded-2xl p-6 text-gray-300 italic">"${flag.reason}"</div>
                        ${flag.admin_comment ? `
                            <div class="mt-4 pt-4 border-t border-white/5">
                                <p class="text-[10px] uppercase font-black text-pink-400 mb-1">Admin Action: ${flag.status}</p>
                                <p class="text-sm text-gray-400 italic">"${flag.admin_comment}"</p>
                            </div>
                        ` : ''}
                    </div>
                    <div class="lg:w-48 flex flex-col gap-2">
                        ${flag.status === 'pending' ? `
                            <button onclick="openFlagModal(${flag.id})" class="w-full bg-pink-600 hover:bg-pink-500 py-3 rounded-xl font-bold uppercase tracking-widest transition text-[10px]">Resolve Ticket</button>
                        ` : `
                            <span class="text-center py-2 bg-white/5 rounded-xl text-[9px] font-black uppercase tracking-widest text-gray-600">Resolved</span>
                        `}
                    </div>
                </div>
            </div>
        `).join('');
    }

    function openFlagModal(id) { document.getElementById('resolve_flag_id').value = id; document.getElementById('flag_modal').classList.remove('hidden'); }
    function closeFlagModal() { document.getElementById('flag_modal').classList.add('hidden'); }

    document.getElementById('flag_form').addEventListener('submit', async (e) => {
        e.preventDefault();
        const id = document.getElementById('resolve_flag_id').value;
        const formData = new FormData(e.target);
        try {
            const res = await fetch(`/admin/flags/${id}/resolve`, { method: 'POST', body: formData });
            const data = await res.json();
            if (data.status === 'success') { loadFlags(); closeFlagModal(); } else { alert(data.message); }
        } catch (err) { alert("Error resolving flag"); }
    });

    // --- Support Logic (Moved/Integrated) ---
    function openReplyModal(id, name) {
        document.getElementById('ticket_id').value = id;
        document.getElementById('modal_title').innerText = `Reply to ${name}`;
        document.getElementById('reply_modal').classList.remove('hidden');
    }
    function closeReplyModal() { document.getElementById('reply_modal').classList.add('hidden'); }
    document.getElementById('reply_form').addEventListener('submit', async (e) => {
        e.preventDefault();
        const id = document.getElementById('ticket_id').value;
        const formData = new FormData(e.target);
        try {
            const res = await fetch(`/admin/tickets/${id}/reply`, { method: 'POST', body: formData });
            const data = await res.json();
            if (data.status === 'success') { window.location.reload(); }
        } catch (err) { alert("Error sending reply"); }
    });
    async function updateTicketStatus(id, status) {
        if (!confirm(`Mark ticket as ${status}?`)) return;
        const res = await fetch(`/admin/tickets/${id}/status`, { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' }, body: JSON.stringify({ status }) });
        const data = await res.json();
        if (data.status === 'success') window.location.reload();
    }
</script>

<style>
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
        animation: fade-in-up 0.4s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    }

    [x-cloak] {
        display: none !important;
    }
</style>
@stop