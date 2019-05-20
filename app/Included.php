<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;


class Included extends Model
{
  protected $table = 'include';

  protected $fillable = ['idInvoice', 'idrepair', 'laborCost', 'technicalCost'];

  public $timestamps = false; // to avoid updated_at column
  protected $primaryKey = ['idInvoice', 'idrepair'];


  public static function validateCreate(){
      request()->validate([
        'title' => ['exists:repair,title'],
        'laborCost' => ['numeric'],
        'technicalCost' => ['numeric'],
        ]);
  }


  public static function includeCreate($idInvoice, $idrepair, $i){
      self::create([
        'idInvoice' => $idInvoice,
        'idrepair' => $idrepair,
        'laborCost' => doubleval(request('laborCost'.$i)),
        'technicalCost' => doubleval(request('technicalCost'.$i)),
      ]);
  }


  public static function getCarInvoices($invoices)
  {
    $results = [];
    foreach ($invoices as $invoice) {
      $res = self::where('idInvoice', $invoice->idInvoice)
                 ->join('repair', 'include.idrepair', '=', 'repair.idrepair')
                 ->get();
      $results = Arr::add($results, $invoice->idInvoice, $res);
    }
    return $results;
  }

}
