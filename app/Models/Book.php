<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Book extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function path()
    {

        return '/books/' . $this->id;
    }

    /**
     * @param  \App\Models\User  $user
     */

    public function checkout(User $user)
    {

        $this->reservations()->create([
            'user_id' => $user->id,
            'checked_out_at' => now()
        ]);
    }

    /**
     * @param  \App\Models\User  $user
     */

    public function checkin(User $user)
    {
        $reservation =  $this->reservations->where('user_id', $user->id)
            ->whereNull('checked_in_at')
            ->whereNotNull('checked_out_at')
            ->first();

            if(is_null($reservation)){
                throw new \Exception();
            }

        $reservation->update([
            'checked_in_at' => now()
        ]);
    }

    public function setAuthorIdAttribute($author)
    {
        $this->attributes['author_id'] = (Author::firstOrCreate([
            'name' => $author // create/find author by name
        ]))->id;
    }

    public function reservations()
    {

        return $this->hasMany(Reservation::class);
    }
}
