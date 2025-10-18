<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name','category_id','stock','price','is_active'];
    protected $casts = ['is_active'=>'boolean','price'=>'decimal:2'];

    public function category(){ return $this->belongsTo(Category::class); }
}
