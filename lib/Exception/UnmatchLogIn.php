<?php

namespace MyApp\Exception;

class UnmatchLogIn extends \Exception{
  protected $message = '名前、メールアドレス、パスワードが一致しません';
}