<div id="cn-chatbot" class="fixed bottom-5 right-5 z-[60] font-sans" aria-live="polite">
    {{-- Panel --}}
    <div id="cn-chatbot-panel"
        class="mb-3 hidden w-[min(100vw-2rem,22rem)] flex-col overflow-hidden rounded-3xl border border-stone-200/80 bg-white shadow-craft-lg dark:border-stone-700 dark:bg-stone-900"
        role="dialog" aria-label="CraftNest help assistant">
        <div class="flex items-center justify-between border-b border-stone-100 bg-gradient-to-r from-craft-700 to-craft-800 px-4 py-3 dark:border-stone-700">
            <div class="flex items-center gap-2">
                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-white/20 text-lg">🤖</span>
                <div>
                    <p class="text-sm font-semibold text-white">CraftNest Assistant</p>
                    <p class="text-[10px] text-craft-100">Orders, shipping &amp; shop help</p>
                </div>
            </div>
            <button type="button" data-chatbot-close class="rounded-lg p-1 text-white/80 transition hover:bg-white/10 hover:text-white" aria-label="Close chatbot">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <div id="cn-chatbot-messages" class="flex max-h-72 flex-col gap-3 overflow-y-auto px-4 py-4 text-sm">
            <div class="rounded-2xl rounded-bl-md bg-stone-100 px-3 py-2 text-stone-700 dark:bg-stone-800 dark:text-stone-200">
                Hi! I'm the CraftNest assistant. Ask about orders, shipping, payments, or selling on the marketplace.
            </div>
        </div>

        <div id="cn-chatbot-suggestions" class="flex flex-wrap gap-1.5 border-t border-stone-100 px-3 py-2 dark:border-stone-700"></div>

        <form id="cn-chatbot-form" class="flex gap-2 border-t border-stone-100 p-3 dark:border-stone-700">
            @csrf
            <input type="text" id="cn-chatbot-input" name="message" maxlength="500" autocomplete="off"
                placeholder="Ask a question..."
                class="cn-input !rounded-xl !py-2 !text-sm flex-1">
            <button type="submit" class="cn-btn-primary !rounded-xl !px-4 !py-2 shrink-0" aria-label="Send message">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
            </button>
        </form>
    </div>

    {{-- Toggle --}}
    <button type="button" id="cn-chatbot-toggle"
        class="flex h-14 w-14 items-center justify-center rounded-full bg-gradient-to-br from-craft-600 to-craft-800 text-white shadow-craft-lg transition hover:scale-105 hover:from-craft-700 hover:to-craft-900 focus:outline-none focus:ring-4 focus:ring-craft-200 dark:focus:ring-craft-900"
        aria-expanded="false" aria-controls="cn-chatbot-panel" aria-label="Open help chatbot">
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
    </button>
</div>

@push('scripts')
<script>
(function () {
    const root = document.getElementById('cn-chatbot');
    if (!root) return;

    const panel = document.getElementById('cn-chatbot-panel');
    const toggle = document.getElementById('cn-chatbot-toggle');
    const form = document.getElementById('cn-chatbot-form');
    const input = document.getElementById('cn-chatbot-input');
    const messages = document.getElementById('cn-chatbot-messages');
    const suggestionsEl = document.getElementById('cn-chatbot-suggestions');
    const csrf = document.querySelector('meta[name="csrf-token"]')?.content;
    const replyUrl = @json(route('chatbot.reply'));

    const defaultSuggestions = ['Track my order', 'How do I checkout?', 'Become a seller'];

    function appendBubble(text, role) {
        const el = document.createElement('div');
        el.className = role === 'user'
            ? 'ml-8 rounded-2xl rounded-br-md bg-craft-600 px-3 py-2 text-white'
            : 'mr-4 rounded-2xl rounded-bl-md bg-stone-100 px-3 py-2 text-stone-700 dark:bg-stone-800 dark:text-stone-200';
        el.textContent = text;
        messages.appendChild(el);
        messages.scrollTop = messages.scrollHeight;
    }

    function renderSuggestions(list) {
        suggestionsEl.innerHTML = '';
        (list || defaultSuggestions).forEach((label) => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'rounded-full bg-craft-50 px-2.5 py-1 text-[11px] font-medium text-craft-800 transition hover:bg-craft-100 dark:bg-stone-800 dark:text-craft-300 dark:hover:bg-stone-700';
            btn.textContent = label;
            btn.addEventListener('click', () => {
                input.value = label;
                form.requestSubmit();
            });
            suggestionsEl.appendChild(btn);
        });
    }

    function setOpen(open) {
        panel.classList.toggle('hidden', !open);
        panel.classList.toggle('flex', open);
        toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        if (open) {
            input.focus();
            renderSuggestions(defaultSuggestions);
        }
    }

    toggle.addEventListener('click', () => setOpen(panel.classList.contains('hidden')));
    root.querySelector('[data-chatbot-close]')?.addEventListener('click', () => setOpen(false));

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const text = input.value.trim();
        if (!text) return;

        appendBubble(text, 'user');
        input.value = '';
        input.disabled = true;

        try {
            const res = await fetch(replyUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                },
                body: JSON.stringify({ message: text }),
            });
            const data = await res.json();
            appendBubble(data.reply || 'Sorry, something went wrong. Please try again.', 'bot');
            renderSuggestions(data.suggestions);
        } catch {
            appendBubble('Connection issue — please try again in a moment.', 'bot');
        } finally {
            input.disabled = false;
            input.focus();
        }
    });

    renderSuggestions(defaultSuggestions);
})();
</script>
@endpush
