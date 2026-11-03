{{-- ======================================================== --}}
{{-- ASISTEN KEUANGAN AI (FLOATING CHATBOT WIDGET)           --}}
{{-- ======================================================== --}}
@auth
<div id="cataChat" class="fixed bottom-4 right-4 sm:bottom-6 sm:right-6 z-[60] flex flex-col items-end gap-3 no-print">

    {{-- PANEL CHAT --}}
    <div id="cataPanel"
         class="hidden w-[calc(100vw-2rem)] sm:w-[26rem] max-w-[26rem] origin-bottom-right transition-all duration-300 ease-out opacity-0 scale-95 translate-y-3">

        <div class="relative overflow-hidden rounded-[28px] border border-slate-200/80 dark:border-slate-700/70 bg-white/95 dark:bg-slate-900/95 backdrop-blur-xl shadow-2xl shadow-slate-900/20 dark:shadow-black/60 flex flex-col h-[34rem] max-h-[calc(100vh-8rem)]">

            {{-- HEADER --}}
            <div class="relative shrink-0 px-4 pt-4 pb-3 bg-gradient-to-br from-[#4ABDAC] via-[#3ca092] to-[#2e7e73] text-white overflow-hidden">
                <div class="absolute -top-10 -right-6 w-28 h-28 rounded-full bg-white/10 blur-xl pointer-events-none"></div>
                <div class="absolute -bottom-12 -left-8 w-32 h-32 rounded-full bg-[#F7B733]/20 blur-2xl pointer-events-none"></div>

                <div class="relative flex items-center gap-3">
                    <div class="relative shrink-0">
                        <div class="w-10 h-10 rounded-2xl bg-white/20 border border-white/30 backdrop-blur flex items-center justify-center shadow-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456z"/>
                            </svg>
                        </div>
                        <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 rounded-full bg-emerald-400 border-2 border-[#3ca092]"></span>
                    </div>

                    <div class="min-w-0 flex-1">
                        <div class="flex items-center gap-1.5">
                            <p class="font-heading font-extrabold text-sm tracking-tight truncate">Cata Assistant</p>
                            <span class="px-1.5 py-0.5 rounded-md bg-white/20 text-[9px] font-bold uppercase tracking-wide">AI</span>
                        </div>
                        <p class="text-[11px] text-white/80 truncate">Tanya apa saja soal keuanganmu</p>
                    </div>

                    <button type="button" id="cataClearBtn" title="Mulai percakapan baru"
                            class="p-2 rounded-xl text-white/80 hover:text-white hover:bg-white/15 transition shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                    </button>
                    <button type="button" id="cataCloseBtn" title="Tutup chat"
                            class="p-2 rounded-xl text-white/80 hover:text-white hover:bg-white/15 transition shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- AREA PESAN --}}
            <div id="cataMessages" class="flex-1 min-h-0 overflow-y-auto px-3.5 py-4 space-y-3.5 bg-[#F8F9FB] dark:bg-slate-950/60 scroll-smooth">
                {{-- Pesan pembuka (dirender JS) --}}
            </div>

            {{-- QUICK SUGGESTIONS --}}
            <div id="cataSuggestions" class="shrink-0 px-3 pb-2 pt-1 bg-white/60 dark:bg-slate-900/60 flex gap-1.5 overflow-x-auto no-scrollbar">
                <button type="button" data-suggestion="Bagaimana cara mencatat transaksi baru?"
                        class="cata-chip shrink-0 px-3 py-1.5 rounded-full text-[11px] font-semibold whitespace-nowrap border border-[#4ABDAC]/30 bg-[#4ABDAC]/10 text-[#2e7e73] dark:text-[#4ABDAC] hover:bg-[#4ABDAC]/20 transition">Cara catat transaksi</button>
                <button type="button" data-suggestion="Bagaimana kondisi keuanganku bulan ini?"
                        class="cata-chip shrink-0 px-3 py-1.5 rounded-full text-[11px] font-semibold whitespace-nowrap border border-[#4ABDAC]/30 bg-[#4ABDAC]/10 text-[#2e7e73] dark:text-[#4ABDAC] hover:bg-[#4ABDAC]/20 transition">Kondisi keuanganku</button>
                <button type="button" data-suggestion="Beri saya tips menghemat pengeluaran."
                        class="cata-chip shrink-0 px-3 py-1.5 rounded-full text-[11px] font-semibold whitespace-nowrap border border-[#4ABDAC]/30 bg-[#4ABDAC]/10 text-[#2e7e73] dark:text-[#4ABDAC] hover:bg-[#4ABDAC]/20 transition">Tips hemat</button>
                <button type="button" data-suggestion="Bagaimana cara ekspor laporan ke CSV?"
                        class="cata-chip shrink-0 px-3 py-1.5 rounded-full text-[11px] font-semibold whitespace-nowrap border border-[#4ABDAC]/30 bg-[#4ABDAC]/10 text-[#2e7e73] dark:text-[#4ABDAC] hover:bg-[#4ABDAC]/20 transition">Ekspor laporan</button>
            </div>

            {{-- INPUT --}}
            <form id="cataForm" class="shrink-0 p-2.5 bg-white dark:bg-slate-900 border-t border-slate-200/80 dark:border-slate-800">
                <div class="flex items-end gap-2 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/60 focus-within:border-[#4ABDAC] focus-within:ring-2 focus-within:ring-[#4ABDAC]/20 transition px-3 py-2">
                    <textarea id="cataInput" rows="1" maxlength="2000" placeholder="Tulis pertanyaanmu di sini..."
                              class="flex-1 resize-none bg-transparent border-0 p-0 text-sm text-slate-800 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 focus:ring-0 focus:outline-none max-h-24 leading-relaxed"></textarea>
                    <button type="submit" id="cataSendBtn"
                            class="shrink-0 w-8 h-8 rounded-xl bg-[#4ABDAC] hover:bg-[#3ca092] text-white flex items-center justify-center shadow-md shadow-[#4ABDAC]/30 transition disabled:opacity-40 disabled:cursor-not-allowed"
                            title="Kirim">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                    </button>
                </div>
                <p class="text-center text-[10px] text-slate-400 dark:text-slate-500 mt-1.5">Cata bisa keliru. Periksa kembali info penting.</p>
            </form>
        </div>
    </div>

    {{-- TOMBOL MELAYANG --}}
    <button type="button" id="cataToggleBtn"
            class="relative group w-14 h-14 rounded-2xl bg-gradient-to-br from-[#4ABDAC] to-[#2e7e73] text-white shadow-xl shadow-[#4ABDAC]/40 hover:shadow-2xl hover:shadow-[#4ABDAC]/50 hover:scale-105 active:scale-95 transition-all duration-300 flex items-center justify-center"
            aria-label="Buka asisten keuangan AI">
        <span class="absolute inset-0 rounded-2xl bg-[#4ABDAC] animate-ping opacity-20 group-hover:opacity-0"></span>
        <svg id="cataIconChat" class="relative w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-4 4v-4z"/>
        </svg>
        <svg id="cataIconClose" class="relative hidden w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>
</div>

<style>
    #cataMessages::-webkit-scrollbar { width: 6px; }
    #cataMessages::-webkit-scrollbar-thumb { background: rgba(74, 189, 172, 0.35); border-radius: 9999px; }
    #cataMessages::-webkit-scrollbar-track { background: transparent; }
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    @keyframes cataBubbleIn { from { opacity: 0; transform: translateY(8px) scale(.97); } to { opacity: 1; transform: translateY(0) scale(1); } }
    .cata-bubble-in { animation: cataBubbleIn .28s cubic-bezier(.22,1,.36,1) both; }
    @keyframes cataDot { 0%, 60%, 100% { transform: translateY(0); opacity: .4; } 30% { transform: translateY(-4px); opacity: 1; } }
    .cata-dot { animation: cataDot 1.2s infinite ease-in-out; }
</style>

<script>
    (function () {
        const toggleBtn = document.getElementById('cataToggleBtn');
        const panel = document.getElementById('cataPanel');
        const messagesEl = document.getElementById('cataMessages');
        const form = document.getElementById('cataForm');
        const input = document.getElementById('cataInput');
        const sendBtn = document.getElementById('cataSendBtn');
        const clearBtn = document.getElementById('cataClearBtn');
        const closeBtn = document.getElementById('cataCloseBtn');
        const iconChat = document.getElementById('cataIconChat');
        const iconClose = document.getElementById('cataIconClose');
        const suggestionsEl = document.getElementById('cataSuggestions');

        if (!toggleBtn || !panel) return;

        const endpoint = @json(route('chatbot.chat'));
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content
            || @json(csrf_token());
        const starter = 'Hai {{ addslashes(Auth::user()->name ?? 'Sobat') }} 👋 Aku **Cata**, asisten keuanganmu. Mau tanya soal cara pakai aplikasi, atau minta analisis singkat keuanganmu?';
        const storageKey = 'cata_chat_history';
        const MAX_HISTORY = 12;

        let history = [];
        let isOpen = false;
        let isSending = false;

        function escapeHtml(text) {
            return String(text)
                .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;').replace(/'/g, '&#39;');
        }

        function renderMarkdown(text) {
            let safe = escapeHtml(text);
            safe = safe.replace(/`([^`]+)`/g, '<code class="px-1 py-0.5 rounded bg-slate-200/70 dark:bg-slate-700/70 text-[11.5px] font-mono">$1</code>');
            safe = safe.replace(/\*\*([^*]+)\*\*/g, '<strong class="font-bold">$1</strong>');
            safe = safe.replace(/(^|\n)\s*\*\s+/g, '$1• ');

            return safe.split('\n').map((line) => {
                const trimmed = line.trim();
                if (trimmed === '') return '';
                if (/^[-•]\s/.test(trimmed)) {
                    return `<li class="ml-4 pl-1 list-disc marker:text-[#4ABDAC]">${trimmed.replace(/^[-•]\s/, '')}</li>`;
                }
                return `<p class="leading-relaxed">${trimmed}</p>`;
            }).join('').replace(/(<li[\s\S]*?<\/li>)+/g, (m) => `<ul class="space-y-1 my-1">${m}</ul>`);
        }

        function scrollToBottom(smooth = true) {
            messagesEl.scrollTo({ top: messagesEl.scrollHeight, behavior: smooth ? 'smooth' : 'auto' });
        }

        function bubble(kind, html) {
            const wrap = document.createElement('div');
            wrap.className = 'cata-bubble-in flex ' + (kind === 'user' ? 'justify-end' : 'justify-start');

            if (kind === 'user') {
                wrap.innerHTML = `<div class="max-w-[85%] rounded-2xl rounded-br-md px-3.5 py-2.5 text-sm bg-[#4ABDAC] text-white shadow-md shadow-[#4ABDAC]/25 break-words">${html}</div>`;
            } else {
                const avatar = `<div class="shrink-0 w-7 h-7 rounded-xl bg-gradient-to-br from-[#4ABDAC] to-[#2e7e73] text-white flex items-center justify-center shadow-sm mt-0.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/></svg>
                    </div>`;
                wrap.innerHTML = `<div class="flex items-start gap-2 max-w-[92%]">${avatar}
                    <div class="rounded-2xl rounded-bl-md px-3.5 py-2.5 text-sm bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-100 border border-slate-200/80 dark:border-slate-700/80 shadow-sm space-y-1 break-words">${html}</div>
                </div>`;
            }

            messagesEl.appendChild(wrap);
            scrollToBottom();
            return wrap;
        }

        function typingIndicator() {
            const wrap = document.createElement('div');
            wrap.className = 'cata-bubble-in flex justify-start';
            wrap.dataset.typing = 'true';
            wrap.innerHTML = `<div class="flex items-start gap-2">
                <div class="shrink-0 w-7 h-7 rounded-xl bg-gradient-to-br from-[#4ABDAC] to-[#2e7e73] text-white flex items-center justify-center shadow-sm mt-0.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/></svg>
                </div>
                <div class="rounded-2xl rounded-bl-md px-4 py-3 bg-white dark:bg-slate-800 border border-slate-200/80 dark:border-slate-700/80 shadow-sm flex items-center gap-1">
                    <span class="cata-dot w-1.5 h-1.5 rounded-full bg-[#4ABDAC]"></span>
                    <span class="cata-dot w-1.5 h-1.5 rounded-full bg-[#4ABDAC]" style="animation-delay:.15s"></span>
                    <span class="cata-dot w-1.5 h-1.5 rounded-full bg-[#4ABDAC]" style="animation-delay:.3s"></span>
                </div>
            </div>`;
            messagesEl.appendChild(wrap);
            scrollToBottom();
            return wrap;
        }

        function addMessage(role, content, persist = true) {
            bubble(role, renderMarkdown(content));
            if (persist) {
                history.push({ role, content });
                if (history.length > MAX_HISTORY) {
                    history = history.slice(-MAX_HISTORY);
                }
            }
        }

        function saveHistory() {
            try { sessionStorage.setItem(storageKey, JSON.stringify(history)); } catch (e) {}
        }

        function loadHistory() {
            try {
                const saved = JSON.parse(sessionStorage.getItem(storageKey) || '[]');
                if (Array.isArray(saved) && saved.length) {
                    history = saved.slice(-MAX_HISTORY);
                    history.forEach((msg) => addMessage(msg.role, msg.content, false));
                    return true;
                }
            } catch (e) {}
            return false;
        }

        function resetChat() {
            history = [];
            try { sessionStorage.removeItem(storageKey); } catch (e) {}
            messagesEl.innerHTML = '';
            addMessage('assistant', starter, false);
        }

        function openPanel() {
            isOpen = true;
            panel.classList.remove('hidden');
            requestAnimationFrame(() => {
                panel.classList.remove('opacity-0', 'scale-95', 'translate-y-3');
                panel.classList.add('opacity-100', 'scale-100', 'translate-y-0');
            });
            iconChat.classList.add('hidden');
            iconClose.classList.remove('hidden');
            toggleBtn.querySelector('span')?.classList.add('opacity-0');
            setTimeout(() => input.focus(), 300);
        }

        function closePanel() {
            isOpen = false;
            panel.classList.add('opacity-0', 'scale-95', 'translate-y-3');
            panel.classList.remove('opacity-100', 'scale-100', 'translate-y-0');
            iconChat.classList.remove('hidden');
            iconClose.classList.add('hidden');
            toggleBtn.querySelector('span')?.classList.remove('opacity-0');
            setTimeout(() => {
                if (!isOpen) panel.classList.add('hidden');
            }, 300);
        }

        function setSending(state) {
            isSending = state;
            sendBtn.disabled = state;
            input.disabled = state;
        }

        function autoGrow() {
            input.style.height = 'auto';
            input.style.height = Math.min(input.scrollHeight, 96) + 'px';
        }

        async function send(message) {
            const text = (message || input.value).trim();
            if (text === '' || isSending) return;

            input.value = '';
            autoGrow();
            addMessage('user', text);
            saveHistory();
            suggestionsEl.classList.add('hidden');

            const typing = typingIndicator();
            setSending(true);

            try {
                const response = await fetch(endpoint, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({ message: text, history: history.slice(0, -1) }),
                });

                const data = await response.json().catch(() => ({}));
                typing.remove();

                if (!response.ok) {
                    const detail = data.message || 'Asisten sedang tidak bisa dihubungi. Coba lagi ya.';
                    bubble('assistant', renderMarkdown('⚠️ ' + detail));
                    return;
                }

                addMessage('assistant', data.message || 'Maaf, aku belum bisa menjawab itu.');
                saveHistory();
            } catch (error) {
                typing.remove();
                bubble('assistant', renderMarkdown('⚠️ Koneksi terputus. Periksa jaringan lalu coba lagi.'));
            } finally {
                setSending(false);
                input.focus();
            }
        }

        toggleBtn.addEventListener('click', () => (isOpen ? closePanel() : openPanel()));
        closeBtn?.addEventListener('click', closePanel);
        clearBtn?.addEventListener('click', () => { resetChat(); suggestionsEl.classList.remove('hidden'); });

        form.addEventListener('submit', (event) => {
            event.preventDefault();
            send();
        });

        input.addEventListener('input', autoGrow);
        input.addEventListener('keydown', (event) => {
            if (event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault();
                send();
            }
        });

        suggestionsEl.querySelectorAll('[data-suggestion]').forEach((chip) => {
            chip.addEventListener('click', () => {
                suggestionsEl.classList.add('hidden');
                send(chip.dataset.suggestion);
            });
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && isOpen) closePanel();
        });

        if (!loadHistory()) {
            addMessage('assistant', starter, false);
        }
    })();
</script>
@endauth
