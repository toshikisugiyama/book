<?php

namespace MyApp\Exception;

class DuplicateEmail extends \Exception{
  protected $message = 'すでに登録されたメールアドレスです';
}