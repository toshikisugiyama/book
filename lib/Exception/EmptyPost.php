<?php

namespace MyApp\Exception;

class EmptyPost extends \Exception{
  protected $message = '名前、メールアドレス、パスワードを入力してください。';
}