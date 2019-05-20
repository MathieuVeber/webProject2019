<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
  protected $table = 'car';

  protected $fillable = ['license_plate', 'owner', 'make', 'model', 'year', 'forSale', 'firstRegistration', 'problem_type', 'problem_request', 'problem_description', 'problem_picture'];

  public $timestamps = false; // to avoid updated_at column
  protected $primaryKey ='license_plate';
  protected $keyType = 'string';



  public static function validateCreate()
  {
    request()->validate([
        'license_plate' => ['bail','required','unique:car,license_plate','string'],
        'make' => ['bail','required','string'],
        'model' => ['bail','required','string'],
        'year' => ['bail','required','digits:4'],
        'firstRegistration' => ['bail','required','digits:4'],
    ]);
  }


  public static function carCreate($userId)
  {
      return self::create([
          'license_plate' => request('license_plate'),
          'owner' => $userId,
          'make' => request('make'),
          'model' => request('model'),
          'year' => request('year'),
          'firstRegistration' => request('firstRegistration'),
      ]);
  }


  public static function problemUpdate($license_plate,$problem_type,$problem_request,$problem_description,$problem_picture)
  {
    self::where('license_plate',$license_plate)
        ->update([
            'problem_type' => $problem_type,
            'problem_request' => $problem_request,
            'problem_description' => $problem_description,
            'problem_picture' => $problem_picture,
        ]);
  }


  public static function saleUpdate($license_plate,$newForSale)
  {
    self::where('license_plate',$license_plate)
        ->update([
            'forSale' => $newForSale,
        ]);
  }


  public static function soldUpdate($license_plate,$newOwnerId)
  {
    self::where('license_plate',$license_plate)
        ->update([
          'forSale' => false,
          'owner' => $newOwnerId,
        ]);
  }


  public static function getUserCars($userId)
  {
    return self::where('owner',$userId)->get();
  }

}
