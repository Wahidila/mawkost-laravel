@extends('layouts.app')

@section('title', 'Konsultasi AI - Temukan Kost Ideal | mawkost')
@section('meta_description', 'Konsultasi dengan AI mawkost untuk menemukan kost ideal sesuai kebutuhan dan budget kamu.')
@section('og_title', 'Konsultasi AI - Temukan Kost Ideal | mawkost')
@section('og_description', 'Konsultasi dengan AI mawkost untuk menemukan kost ideal sesuai kebutuhan dan budget kamu.')
@section('hide_footer', true)

@section('content')
<div class="chat-wrapper">
    {{-- Decorative Blobs (consistent with homepage hero) --}}
    <div class="chat-blob chat-blob-1"></div>
    <div class="chat-blob chat-blob-2"></div>

    {{-- Chat Messages Area --}}
    <div class="chat-messages-container" id="chatMessages">
        <div class="container">

            {{-- Welcome State (centered hero-style) --}}
            <div class="chat-welcome" id="welcomeMessage">
                <div class="chat-welcome-icon">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="mawkost AI">
                </div>
                <span class="badge badge-cta chat-welcome-badge fade-in">
                    <i class="fa-solid fa-wand-magic-sparkles"></i> Powered by AI
                </span>
                <h2 class="chat-welcome-title fade-in">Ada yang bisa dibantu?</h2>
                <p class="chat-welcome-subtitle fade-in">Tanya apa saja seputar kost &mdash; rekomendasi, perbandingan harga, fasilitas, lokasi, dan lainnya.</p>

                {{-- Suggested Questions --}}
                <div class="chat-suggestions" id="chatSuggestions">
                    <button class="suggestion-chip fade-in" onclick="sendSuggestion('Rekomendasikan kost murah di Malang')" style="animation-delay:.05s">
                        <i class="fa-solid fa-magnifying-glass-location"></i> Kost murah di Malang
                    </button>
                    <button class="suggestion-chip fade-in" onclick="sendSuggestion('Kost putri yang ada WiFi dan AC')" style="animation-delay:.1s">
                        <i class="fa-solid fa-venus"></i> Kost putri + WiFi & AC
                    </button>
                    <button class="suggestion-chip fade-in" onclick="sendSuggestion('Kost dengan budget di bawah 1 juta')" style="animation-delay:.15s">
                        <i class="fa-solid fa-wallet"></i> Budget di bawah 1 juta
                    </button>
                    <button class="suggestion-chip fade-in" onclick="sendSuggestion('Apa saja kost unggulan yang tersedia?')" style="animation-delay:.2s">
                        <i class="fa-solid fa-star"></i> Kost unggulan
                    </button>
                    <button class="suggestion-chip fade-in" onclick="sendSuggestion('Bandingkan kost di Malang dan Surabaya')" style="animation-delay:.25s">
                        <i class="fa-solid fa-code-compare"></i> Bandingkan kota
                    </button>
                    <button class="suggestion-chip fade-in" onclick="sendSuggestion('Tips memilih kost yang bagus')" style="animation-delay:.3s">
                        <i class="fa-solid fa-lightbulb"></i> Tips cari kost
                    </button>
                </div>
            </div>

        </div>
    </div>

    @if(!$aiEnabled)
    {{-- AI Disabled Notice --}}
    <div class="chat-disabled-notice">
        <div class="container">
            <div class="chat-disabled-card">
                <div class="chat-disabled-icon">
                    <i class="fa-solid fa-plug-circle-xmark"></i>
                </div>
                <div>
                    <strong>Fitur AI Konsultasi sedang tidak aktif</strong>
                    <p>Silakan gunakan <a href="{{ route('kost.search') }}">pencarian kost</a> atau <a href="{{ route('contact.index') }}">hubungi kami</a> untuk bantuan.</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Chat Input Area --}}
    <div class="chat-input-wrapper" id="chatInputWrapper">
        <div class="container">
            <form class="chat-input-form" id="chatForm" onsubmit="handleSend(event)">
                <div class="chat-input-group">
                    <textarea
                        id="chatInput"
                        class="chat-input"
                        placeholder="Tanya tentang kost..."
                        rows="1"
                        maxlength="2000"
                        {{ !$aiEnabled ? 'disabled' : '' }}
                    ></textarea>
                    <button type="button" class="chat-reset-btn" onclick="clearChat()" title="Mulai percakapan baru">
                        <i class="fa-solid fa-rotate-right"></i>
                    </button>
                    <button type="submit" class="chat-send-btn" id="chatSendBtn" {{ !$aiEnabled ? 'disabled' : '' }}>
                        <i class="fa-solid fa-paper-plane"></i>
                    </button>
                </div>
                <p class="chat-input-hint">Tekan Enter untuk kirim &middot; Shift+Enter untuk baris baru</p>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
(function() {
    'use strict';

    // ===== Configuration =====
    const API_BASE = '/api/chat';
    const AI_ENABLED = @json($aiEnabled);
    const AVATAR_SRC = '{{ asset('assets/img/logo.png') }}';

    // CJK Unicode ranges for stripping
    const CJK_REGEX = /[\u4E00-\u9FFF\u3400-\u4DBF\u3000-\u303F\uFF00-\uFFEF\u2E80-\u2EFF\u31C0-\u31EF\u2FF0-\u2FFF]/g;

    // ===== State =====
    let sessionId = localStorage.getItem('mawkost_chat_session');
    let isStreaming = false;

    if (!sessionId) {
        sessionId = generateUUID();
        localStorage.setItem('mawkost_chat_session', sessionId);
    }

    // ===== Init =====
    document.addEventListener('DOMContentLoaded', function() {
        if (!AI_ENABLED) return;
        setupTextarea();
        loadHistory();
    });

    // ===== UUID Generator =====
    function generateUUID() {
        return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
            const r = Math.random() * 16 | 0;
            const v = c === 'x' ? r : (r & 0x3 | 0x8);
            return v.toString(16);
        });
    }

    // ================================================================
    //  SANITIZE — strip <think>, CJK chars, normalize whitespace
    // ================================================================
    function sanitizeAiText(text) {
        if (!text) return '';

        // 1. Strip <think>...</think> blocks (multiline, greedy-safe)
        text = text.replace(/<think>[\s\S]*?<\/think>/gi, '');

        // 2. Strip orphaned <think> or </think> tags
        text = text.replace(/<\/?think>/gi, '');

        // 3. Strip CJK characters
        text = text.replace(CJK_REGEX, '');

        // 4. Normalize excessive blank lines (max 2 newlines)
        text = text.replace(/\n{3,}/g, '\n\n');

        // 5. Remove lines that are only whitespace
        text = text.replace(/^\s+$/gm, '');

        // 6. Trim
        text = text.trim();

        return text;
    }

    // ================================================================
    //  MARKDOWN RENDERER — robust, handles all common patterns
    // ================================================================
    function renderMarkdown(raw) {
        if (!raw) return '';

        // Sanitize first
        let text = sanitizeAiText(raw);
        if (!text) return '';

        // Escape HTML entities
        text = escapeHtml(text);

        // Split into lines for block-level processing
        const lines = text.split('\n');
        const blocks = [];
        let i = 0;

        while (i < lines.length) {
            const line = lines[i];

            // --- Horizontal rule ---
            if (/^(\-{3,}|\*{3,}|_{3,})$/.test(line.trim())) {
                blocks.push('<hr>');
                i++;
                continue;
            }

            // --- Headers ---
            const headerMatch = line.match(/^(#{1,3})\s+(.+)$/);
            if (headerMatch) {
                const level = headerMatch[1].length;
                const content = inlineFormat(headerMatch[2]);
                blocks.push('<h' + level + '>' + content + '</h' + level + '>');
                i++;
                continue;
            }

            // --- Unordered list block ---
            if (/^\s*[\-\*]\s+/.test(line)) {
                let listHtml = '<ul>';
                while (i < lines.length && /^\s*[\-\*]\s+/.test(lines[i])) {
                    const itemText = lines[i].replace(/^\s*[\-\*]\s+/, '');
                    listHtml += '<li>' + inlineFormat(itemText) + '</li>';
                    i++;
                }
                listHtml += '</ul>';
                blocks.push(listHtml);
                continue;
            }

            // --- Ordered list block ---
            if (/^\s*\d+[\.\)]\s+/.test(line)) {
                let listHtml = '<ol>';
                while (i < lines.length && /^\s*\d+[\.\)]\s+/.test(lines[i])) {
                    const itemText = lines[i].replace(/^\s*\d+[\.\)]\s+/, '');
                    listHtml += '<li>' + inlineFormat(itemText) + '</li>';
                    i++;
                }
                listHtml += '</ol>';
                blocks.push(listHtml);
                continue;
            }

            // --- Markdown table block ---
            if (/^\|.+\|/.test(line.trim()) && i + 1 < lines.length && /^\|[\s\-\:]+\|/.test(lines[i + 1].trim())) {
                blocks.push(parseTable(lines, i));
                // Advance past all table rows
                while (i < lines.length && /^\|.+\|/.test(lines[i].trim())) { i++; }
                continue;
            }

            // --- Empty line (paragraph break) ---
            if (line.trim() === '') {
                i++;
                continue;
            }

            // --- Paragraph: collect consecutive non-empty, non-special lines ---
            let paraLines = [];
            while (i < lines.length) {
                const l = lines[i];
                if (l.trim() === '') break;
                if (/^#{1,3}\s+/.test(l)) break;
                if (/^\s*[\-\*]\s+/.test(l)) break;
                if (/^\s*\d+[\.\)]\s+/.test(l)) break;
                if (/^(\-{3,}|\*{3,}|_{3,})$/.test(l.trim())) break;
                if (/^\|.+\|/.test(l.trim())) break;
                paraLines.push(l);
                i++;
            }
            if (paraLines.length > 0) {
                const paraContent = paraLines.map(l => inlineFormat(l)).join('<br>');
                blocks.push('<p>' + paraContent + '</p>');
            }
        }

        return blocks.join('');
    }

    // ================================================================
    //  INLINE FORMATTING — bold, italic, links, code, emoji spacing
    // ================================================================
    function inlineFormat(text) {
        // Bold: **text** or __text__
        text = text.replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>');
        text = text.replace(/__(.+?)__/g, '<strong>$1</strong>');

        // Italic: *text* (not inside bold)
        text = text.replace(/(?<!\*)\*(?!\*)(.+?)(?<!\*)\*(?!\*)/g, '<em>$1</em>');
        text = text.replace(/(?<!_)_(?!_)(.+?)(?<!_)_(?!_)/g, '<em>$1</em>');

        // Inline code: `code`
        text = text.replace(/`([^`]+)`/g, '<code>$1</code>');

        // Links: [text](url)
        text = text.replace(/\[([^\]]+)\]\(([^)]+)\)/g, function(match, label, url) {
            // Make internal links open in same tab, external in new tab
            if (url.startsWith('/') || url.startsWith(window.location.origin)) {
                return '<a href="' + url + '">' + label + '</a>';
            }
            return '<a href="' + url + '" target="_blank" rel="noopener">' + label + '</a>';
        });

        return text;
    }

    // ================================================================
    //  TABLE PARSER — converts markdown table to HTML
    // ================================================================
    function parseTable(lines, startIdx) {
        let idx = startIdx;

        // Parse header row
        const headerCells = splitTableRow(lines[idx]);
        idx++;

        // Parse separator row (|---|---|) — skip it, but detect alignment
        const alignments = [];
        if (idx < lines.length && /^\|[\s\-\:]+\|/.test(lines[idx].trim())) {
            const sepCells = splitTableRow(lines[idx]);
            sepCells.forEach(function(cell) {
                const trimmed = cell.trim();
                if (trimmed.startsWith(':') && trimmed.endsWith(':')) {
                    alignments.push('center');
                } else if (trimmed.endsWith(':')) {
                    alignments.push('right');
                } else {
                    alignments.push('left');
                }
            });
            idx++;
        }

        // Parse body rows
        const bodyRows = [];
        while (idx < lines.length && /^\|.+\|/.test(lines[idx].trim())) {
            bodyRows.push(splitTableRow(lines[idx]));
            idx++;
        }

        // Build HTML
        let html = '<div class="chat-table-wrap"><table>';

        // Thead
        html += '<thead><tr>';
        headerCells.forEach(function(cell, ci) {
            const align = alignments[ci] || 'left';
            html += '<th style="text-align:' + align + '">' + inlineFormat(cell.trim()) + '</th>';
        });
        html += '</tr></thead>';

        // Tbody
        if (bodyRows.length > 0) {
            html += '<tbody>';
            bodyRows.forEach(function(row) {
                html += '<tr>';
                row.forEach(function(cell, ci) {
                    const align = alignments[ci] || 'left';
                    html += '<td style="text-align:' + align + '">' + inlineFormat(cell.trim()) + '</td>';
                });
                // Fill missing cells if row is shorter than header
                for (let fi = row.length; fi < headerCells.length; fi++) {
                    html += '<td></td>';
                }
                html += '</tr>';
            });
            html += '</tbody>';
        }

        html += '</table></div>';
        return html;
    }

    function splitTableRow(line) {
        // Remove leading/trailing pipe and split by pipe
        let trimmed = line.trim();
        if (trimmed.startsWith('|')) trimmed = trimmed.substring(1);
        if (trimmed.endsWith('|')) trimmed = trimmed.substring(0, trimmed.length - 1);
        return trimmed.split('|');
    }

    // ================================================================
    //  HTML ESCAPE
    // ================================================================
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // ===== Textarea Auto-resize & Enter handling =====
    function setupTextarea() {
        const textarea = document.getElementById('chatInput');
        if (!textarea) return;

        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = Math.min(this.scrollHeight, 150) + 'px';
        });

        textarea.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                handleSend(e);
            }
        });
    }

    // ===== Load Chat History =====
    function loadHistory() {
        fetch(API_BASE + '/history/' + sessionId)
            .then(r => r.json())
            .then(data => {
                if (data.messages && data.messages.length > 0) {
                    hideSuggestions();
                    data.messages.forEach(msg => {
                        appendMessage(msg.role, msg.content, false);
                    });
                    scrollToBottom();
                }
            })
            .catch(() => {});
    }

    // ===== Send Message =====
    window.handleSend = function(e) {
        if (e) e.preventDefault();
        if (isStreaming || !AI_ENABLED) return;

        const input = document.getElementById('chatInput');
        const message = input.value.trim();
        if (!message) return;

        input.value = '';
        input.style.height = 'auto';
        hideSuggestions();
        appendMessage('user', message, false);
        scrollToBottom();
        sendToAI(message);
    };

    window.sendSuggestion = function(text) {
        const input = document.getElementById('chatInput');
        input.value = text;
        handleSend(null);
    };

    // ===== Streaming (throttled plain-text preview) =====
    function sendToAI(message) {
        isStreaming = true;
        toggleSendButton(false);

        const aiBubble = appendMessage('assistant', '', true);
        const textEl = aiBubble.querySelector('.chat-bubble-text');
        scrollToBottom();

        fetch(API_BASE + '/send', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ session_id: sessionId, message: message })
        })
        .then(r => {
            if (!r.ok) return r.json().then(d => { throw new Error(d.error || 'Gagal mengirim pesan'); });
            return r.json();
        })
        .then(data => {
            const eventSource = new EventSource(API_BASE + '/stream/' + data.message_id);
            let rawContent = '';
            let needsRender = false;

            // Throttled preview: update plain text every 150ms (very lightweight)
            const previewInterval = setInterval(function() {
                if (needsRender) {
                    needsRender = false;
                    const cleaned = sanitizeAiText(rawContent);
                    if (cleaned) {
                        textEl.textContent = cleaned;
                    }
                    scrollToBottom();
                }
            }, 150);

            eventSource.onmessage = function(event) {
                if (event.data === '[DONE]') {
                    eventSource.close();
                    clearInterval(previewInterval);
                    finishStreaming(textEl, rawContent);
                    return;
                }
                try {
                    const parsed = JSON.parse(event.data);
                    if (parsed.error) {
                        rawContent = parsed.content;
                        eventSource.close();
                        clearInterval(previewInterval);
                        finishStreaming(textEl, rawContent);
                        return;
                    }
                    rawContent += parsed.content;
                    needsRender = true;
                } catch (e) {}
            };

            eventSource.onerror = function() {
                eventSource.close();
                clearInterval(previewInterval);
                if (!rawContent) {
                    rawContent = 'Maaf, terjadi kesalahan koneksi. Silakan coba lagi.';
                }
                finishStreaming(textEl, rawContent);
            };
        })
        .catch(err => {
            textEl.innerHTML = renderMarkdown(err.message || 'Maaf, terjadi kesalahan. Silakan coba lagi.');
            finishStreaming(textEl, '');
        });
    }

    function finishStreaming(textEl, rawContent) {
        isStreaming = false;
        toggleSendButton(true);

        // Final render: full markdown formatting (called only once)
        if (rawContent) {
            textEl.innerHTML = renderMarkdown(rawContent);
        }
        scrollToBottom();
    }

    // ===== UI Helpers =====
    function appendMessage(role, content, isPlaceholder) {
        const container = document.getElementById('chatMessages').querySelector('.container');
        const bubble = document.createElement('div');
        bubble.className = 'chat-bubble chat-bubble-' + (role === 'user' ? 'user' : 'ai');

        if (role === 'assistant' || role === 'ai') {
            bubble.innerHTML =
                '<div class="chat-bubble-avatar"><img src="' + AVATAR_SRC + '" alt="AI"></div>' +
                '<div class="chat-bubble-content"><div class="chat-bubble-text">' +
                (isPlaceholder
                    ? '<div class="typing-indicator"><span></span><span></span><span></span></div>'
                    : renderMarkdown(content)) +
                '</div></div>';
        } else {
            bubble.innerHTML =
                '<div class="chat-bubble-content"><div class="chat-bubble-text">' +
                escapeHtml(content) +
                '</div></div>';
        }

        container.appendChild(bubble);
        return bubble;
    }

    function hideSuggestions() {
        const welcome = document.getElementById('welcomeMessage');
        if (welcome) welcome.style.display = 'none';
    }

    function scrollToBottom() {
        const container = document.getElementById('chatMessages');
        requestAnimationFrame(() => { container.scrollTop = container.scrollHeight; });
    }

    function toggleSendButton(enabled) {
        const btn = document.getElementById('chatSendBtn');
        const input = document.getElementById('chatInput');
        if (btn) btn.disabled = !enabled;
        if (input) input.disabled = !enabled;
    }

    // ===== Clear Chat =====
    window.clearChat = function() {
        sessionId = generateUUID();
        localStorage.setItem('mawkost_chat_session', sessionId);

        const container = document.getElementById('chatMessages').querySelector('.container');
        const welcome = document.getElementById('welcomeMessage');

        // Remove all chat bubbles
        container.querySelectorAll('.chat-bubble').forEach(b => b.remove());

        // Show welcome state again
        if (welcome) welcome.style.display = '';
        scrollToBottom();
    };

})();
</script>
@endpush
