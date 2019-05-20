<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;


class Invoice extends Model
{
  protected $table = 'invoice';

  protected $fillable = ['idInvoice', 'car'];

  protected $primaryKey ='idInvoice';



  public static function validateCreate($request)
  {
    $request->validate([
        'license_plate' => ['exists:car,license_plate'],
    ]);
  }


  public static function invoiceCreate($license_plate)
  {
    return self::create([
        'car' => $license_plate,
    ]);
  }


}
