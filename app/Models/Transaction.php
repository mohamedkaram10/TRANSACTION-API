<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function calculateStatus()
    {
        $currentDateTime = Carbon::parse('2022-01-10 10:00:00'); // Use the current date and time

        if ($this->due_on < $currentDateTime) {
            // Transaction is overdue
            return 'Overdue';
        }

        if ($this->total_paid >= $this->amount) {
            // Transaction is fully paid
            return 'Paid';
        }

        // Transaction is outstanding
        return 'Outstanding';
    }
}
