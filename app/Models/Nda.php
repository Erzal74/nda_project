<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Nda extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_name',
        'start_date',
        'end_date',
        'nda_signature_date',
        'description',
        'token',
        'user_id',
        'members'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'members' => 'array', // Cast members ke array
    ];

    protected $appends = ['formatted_duration', 'members_with_files'];

    // Accessor untuk members dengan file info
    public function getMembersWithFilesAttribute()
    {
        $members = $this->members ?? [];
        $result = [];

        foreach ($members as $index => $member) {
            $file = null;
            if (isset($member['file_id'])) {
                $file = $this->files->firstWhere('id', $member['file_id']);
            }

            $result[] = [
                'name' => $member['name'] ?? '',
                'file' => $file,
                'file_id' => $member['file_id'] ?? null,
                'signature_date' => $file ? $file->signature_date : null, // Tambah accessor untuk tanggal per member
            ];
        }

        return $result;
    }

    // Accessor untuk durasi yang diformat
    public function getFormattedDurationAttribute()
    {
        if (!$this->start_date || !$this->end_date) {
            return 'Tidak tersedia';
        }

        $diff = $this->start_date->diff($this->end_date);
        $days = $diff->days;

        $months = floor($days / 30);
        $weeks = floor(($days % 30) / 7);
        $remainingDays = $days % 7;

        $parts = [];
        if ($months > 0) $parts[] = "{$months} bulan";
        if ($weeks > 0) $parts[] = "{$weeks} minggu";
        if ($remainingDays > 0 || empty($parts)) $parts[] = "{$remainingDays} hari";

        return implode(' ', $parts) . " ({$days} hari total)";
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'no');
    }

    public function files()
    {
        return $this->hasMany(NdaFile::class);
    }
}
