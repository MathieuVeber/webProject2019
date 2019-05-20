<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Repair extends Model
{
  protected $table = 'repair';

  protected $fillable = ['idrepair', 'type', 'title', 'description'];

  protected $primaryKey ='idrepair';



  public static function validate($currentTitle){
      request()->validate([
        'type' => ['bail','required','string'],
        'title' => ['sometimes','bail','required','string'],//'unique:repair,title,'.$currentTitle],
        'description' => ['bail','required','string'],
        ]);
  }

  public static function repairCreate(){
      return self::create([
        'type' => request('type'),
        'title' => request('title'),
        'description' => request('description'),
      ]);
  }

  public static function repairUpdate($idrepair)
  {
    self::where('idrepair', $idrepair)
        ->update([
          'type' => request('type'),
          'title' => request('title'),
          'description' => request('description'),
        ]);
  }

}
