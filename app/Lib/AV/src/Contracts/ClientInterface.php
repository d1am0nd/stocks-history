<?php

namespace AV\Contracts;

interface ClientInterface {
  public function request($method, $uri = '', array $options = []);
}
