<?php

namespace MyApp\Exception;

class InvalidTitle extends \Exception{
  protected $message = 'タイトルを入力してください';
}