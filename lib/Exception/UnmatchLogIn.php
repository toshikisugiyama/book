<?php

namespace MyApp\Exception;

class UnmatchLogIn extends \Exception{
  protected $message = 'Name/Email/Password do not match!';
}