<?php namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model{
  protected $table = 'users';
  protected $primaryKey = 'USER_ID';

  protected $returnType     = 'array';
  protected $useSoftDeletes = true;

  protected $allowedFields = ['USER_ID', 'user', 'role', 'pass', 'status', 'akses'];
  protected $beforeInsert = ['beforeInsert'];
  protected $beforeUpdate = ['beforeUpdate'];

  protected function beforeInsert(array $data){
    $data = $this->passwordHash($data);
    $data['data']['created_at'] = date('Y-m-d H:i:s');

    return $data;
  }

  protected function beforeUpdate(array $data){
    $data = $this->passwordHash($data);
    $data['data']['updated_at'] = date('Y-m-d H:i:s');

    return $data;
  }

  protected function passwordHash(array $data){
    if(isset($data['data']['pass']))
      $data['data']['pass'] = password_hash($data['data']['pass'], PASSWORD_DEFAULT);

    return $data;
  }

}
