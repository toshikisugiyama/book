<?php

namespace MyApp\Exception;

class InvalidName extends \Exception{
  protected $message = '名前を入力してください';
}