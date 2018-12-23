<?php

namespace MyApp\Exception;

/**
 * 
 */
class InvalidPassword extends \Exception{
  protected $message = '4文字〜16文字のパスワードを入力してください';
}