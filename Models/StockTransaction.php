<?php

namespace Models;

class StockTransaction
{
  const TYPE_INBOUND = 'INBOUND';
  const TYPE_OUTBOUND = 'OUTBOUND';
  const VALID_TYPES = [
    self::TYPE_INBOUND,
    self::TYPE_OUTBOUND,
  ];
}