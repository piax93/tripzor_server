<?php

class UploadMedia implements Module {

  public static function run() {
    session_start ();
    $user = new User ();
    if($user->selectByEmail(Database::sessionDecrypt($_SESSION['user']))) {

      Logger::var_dump_log('UploadMedia', $_FILES);
      Logger::var_dump_log('UploadMedia', $_REQUEST);

      $userdir = MEDIA_FOLDER . $user->getUserId ();
      if(!is_dir($userdir)) {
        mkdir($userdir);
        chmod($userdir, 0777);
      }
      if(count($_FILES) != 0) {
        $file_id = array_keys($_FILES)[0];
        if (strncmp($_FILES[$file_id]['type'], 'image', 5) == 0) {
          $ext = pathinfo($_FILES[$file_id]['name'], PATHINFO_EXTENSION);
          $target_file = $userdir . '/' . $file_id . '.' . $ext;
          if (move_uploaded_file($_FILES [$file_id]['tmp_name'], $target_file )) {
            chmod($target_file, 0666);
            return ReturnCode::$success;
          }
        }
      }
      return ReturnCode::$error;
    }
    return ReturnCode::$userNotFound;
  }

}
