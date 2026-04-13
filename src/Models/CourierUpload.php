<?php

namespace Nextpointer\CourierSync\Models;

use Illuminate\Database\Eloquent\Model;

class CourierUpload extends Model {
    protected $fillable = ['courier_provider_id', 'filename', 'total_rows', 'status', 'error_message'];
}
