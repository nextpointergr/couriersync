<?php
namespace Nextpointer\CourierSync\Models;

use Illuminate\Database\Eloquent\Model;

class CourierProvider extends Model {
    protected $fillable = ['name', 'slug', 'file_type', 'delimiter', 'map_class'];

    public function uploads() {
        return $this->hasMany(CourierUpload::class);
    }
}
