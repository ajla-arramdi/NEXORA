<?php

namespace App\Support;

use App\Models\LogAktivitas;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class ActivityLogger
{
    public static function log(?User $user, string $aktivitas, Model|string|null $subject = null, ?string $deskripsi = null, array $metadata = []): void
    {
        $entitas = null;
        $entitasId = null;

        if ($subject instanceof Model) {
            $entitas = class_basename($subject);
            $entitasId = $subject->getKey();
        }

        if (is_string($subject)) {
            $entitas = $subject;
        }

        LogAktivitas::create([
            'user_id' => $user?->id,
            'aktivitas' => $aktivitas,
            'entitas' => $entitas,
            'entitas_id' => $entitasId,
            'deskripsi' => $deskripsi,
            'metadata' => $metadata,
            'created_at' => now(),
        ]);
    }
}
