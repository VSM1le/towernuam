<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InvoiceHeader extends Model
{
    use HasFactory;
    protected $table = 'invoice_headers';
    protected $fillable  = ['inv_no','inv_date','ps_group_id','inv_status','created_by','updated_by','customer_rental_id','inv_tower','customer_id'];

    public function invoicedetail():HasMany
    {
        return $this->hasMany(InvoiceDetail::class, 'invoice_header_id', 'id');
    }
    public function customerrental(): BelongsTo{
        return $this->belongsTo(CustomerRental::class);
    }
    public function psgroup():BelongsTo{
        return $this->belongsTo(PsGroup::class);
    }
}
