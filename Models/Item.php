<?php 

namespace Models;

use Core\Sanitizer;
use DateTime;

class Item
{
  const UNIT_PCS = 'PCS';
  const UNIT_PACK = 'PACK';
  const VALID_UNITS = [
    self::UNIT_PCS,
    self::UNIT_PACK,
  ];

  public ?int $id;
  public string $name;
  public int $categoryId;
  public string $unit;
  public ?int $pcsPerPack; // Nullable
  public int $pcsStock;
  public int $packStock;
  public ?string $created_at;
  public ?string $updated_at;

  // Konstruktor untuk menginisialisasi properti dari array data
  public function __construct(array $data)
  {
    $this->id = Sanitizer::emptyToDefault($data['id'] ?? null);
    $this->name = Sanitizer::emptyToDefault($data['name'] ?? '', '');
    $this->categoryId = Sanitizer::emptyToDefault($data['category_id'] ?? 0, 0);
    $this->unit = Sanitizer::emptyToDefault($data['unit'] ?? self::UNIT_PCS, self::UNIT_PCS);
    $this->pcsPerPack = Sanitizer::emptyToDefault($data['pcs_per_pack'] ?? null, null);
    $this->pcsStock = Sanitizer::emptyToDefault($data['pcs_stock'] ?? 0, 0);
    $this->packStock = Sanitizer::emptyToDefault($data['pack_stock'] ?? 0, 0);
    $this->created_at = Sanitizer::emptyToDefault($data['created_at'] ?? null, null);
    $this->updated_at = Sanitizer::emptyToDefault($data['updated_at'] ?? null, null);
  }

  public function markAsUpdated(): void
  {
    $this->updated_at = DateTime::createFromFormat('U.u', microtime(true))->format('Y-m-d H:i:s.u');
  }

  public function toArray(): array
  {
    $now = DateTime::createFromFormat('U.u', microtime(true))->format('Y-m-d H:i:s.u');
    return [
      'id' => $this->id,
      'name' => $this->name,
      'category_id' => $this->categoryId,
      'unit' => $this->unit,
      'pcs_per_pack' => $this->pcsPerPack,
      'pcs_stock' => $this->pcsStock,
      'pack_stock' => $this->packStock,
      'created_at' => $this->created_at ?? $now,
      'updated_at' => $this->updated_at ?? $now,
    ];
  }

  public function isPcsUnit(): bool
  {
    return $this->pcsPerPack === null;
  }

  public static function isValidUnit(string $unit): bool
  {
    return in_array($unit, self::VALID_UNITS);
  }

   /**
   * Increase or decrease PCS stock and optionally convert to PACK.
   *
   * @param int $qPcs
   * @param bool $isIncrease
   * @return bool
   */
  public function adjustPcsStock(int $qPcs, bool $isIncrease = true): bool
  {
    if ($qPcs < 0) {
      throw new \InvalidArgumentException("PCS value must be a non-negative integer.");
    }
    $isSuportPack = ( ($this->unit  === self::UNIT_PACK) && ($this->pcsPerPack > 0));
    
    if ($isSuportPack) {
      $this->pcsStock += $this->packStock * $this->pcsPerPack; // Update pcsStock based on packStock
      $this->packStock = 0; // Reset packStock to 0
    }

    if ($isIncrease) {
      $this->pcsStock += $qPcs;
    } else {
      $this->pcsStock -= $qPcs;
    }
    if ($this->pcsStock < 0) {
      return false; // Not enough PCS stock to decrease
    }
    // dd([
    //   "qPcs" => $qPcs,
    //   "isSuportPack" => $isSuportPack,
    //   "unit" => $this->unit,
    //   "pcsPerPack" => $this->pcsPerPack,
    //   "pcsStock" => $this->pcsStock,
    // ]);

    // adjust pack stock and pcs stock if unit is PACK
    $currentPcsStock = $this->pcsStock;
    if ($isSuportPack) {
      $this->packStock = intdiv($currentPcsStock, $this->pcsPerPack);// to floor rounding integer division // 20 / 12 = 1
      $this->pcsStock = $currentPcsStock % $this->pcsPerPack; // 20 % 12 = 8
    }

    // dd([
    //   "qPcs" => $qPcs,
    //   "currenItem" => $this,
    // ]);
    
    return true;
  }

  /**
   * Increase or decrease PACK stock.
   *
   * @param int $packs
   * @param bool $isIncrease
   * @return bool
   */
  public function adjustPackStock(int $packs, bool $isIncrease = true): bool
  {
    if ($packs < 0) {
      throw new \InvalidArgumentException("PACK value must be a non-negative integer.");
    }

    if ($isIncrease) {
      $this->packStock += $packs;
    } else {
      $this->packStock -= $packs;
      if ($this->packStock < 0) {
        return false; // Not enough PACK stock to decrease
      }
    }

    return true;
  }  
}