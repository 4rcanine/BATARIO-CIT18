<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Model1 extends Model
{
    protected $table = 'itemlist';
    protected $fillable = [
        'name',
        'description'
    ];

    public function addItem($record) {
        return DB::transaction(function() use ($record) {
            return self::create($record);
        });
    }

    public function updateItem($id, $record) {
        $updatedRecord = DB::transaction(function() use ($record, $id) {
            return $this->where('id', $id)->update([
                'name' => $record['name'],
                'description' => $record['description'],
            ]);
        });
    }

    public function deleteItem($id) {
        return DB::transaction(function() use ($id) {
            return $this->where('id', $id)->delete();
        });
    }
    
}