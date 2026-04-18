<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $fillable = [
        'session_id',
        'role',
        'content',
    ];

    /**
     * Scope: filter by session ID.
     */
    public function scopeBySession($query, string $sessionId)
    {
        return $query->where('session_id', $sessionId);
    }

    /**
     * Get recent messages for a session (for AI context window).
     * Limited to 10 messages, assistant responses truncated to save tokens.
     */
    public static function getConversationHistory(string $sessionId, int $limit = 10): array
    {
        return static::bySession($sessionId)
            ->orderBy('created_at', 'asc')
            ->latest()
            ->take($limit)
            ->get()
            ->sortBy('created_at')
            ->map(fn($msg) => [
                'role' => $msg->role,
                'content' => $msg->role === 'assistant' && mb_strlen($msg->content) > 500
                    ? mb_substr($msg->content, 0, 500) . '...'
                    : $msg->content,
            ])
            ->values()
            ->toArray();
    }
}
