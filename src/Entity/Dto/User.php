<?php

namespace App\Entity\Dto;

class User
{
  /**
   * @var int
   */
  public $page = 1;

  /**
   * @var int
   */
  public $limit;

  /**
   * @var string
   */
  public $compte;

  /**
   * @var string
   */
  public $query = null;

  /**
   * @var DateTimeInterface|null
   */
  public $minDate = null;

  /**
   * @var DateTimeInterface|null
   */
  public $maxDate = null;

  /**
   * @var bool
   */
  public $isVerified;

  /**
   * Get the value of query
   *
   * @return  string
   */
  public function getQuery()
  {
    return $this->query;
  }

  /**
   * Set the value of query
   *
   * @param  string  $query
   *
   * @return  self
   */
  public function setQuery(?string $query)
  {
    $this->query = $query;

    return $this;
  }

  /**
   * Get the value of minDate
   *
   * @return  DateTimeInterface|null
   */
  public function getMinDate()
  {
    return $this->minDate;
  }

  /**
   * Set the value of minDate
   *
   * @param  DateTimeInterface|null  $minDate
   *
   * @return  self
   */
  public function setMinDate($minDate)
  {
    $this->minDate = $minDate;

    return $this;
  }

  /**
   * Get the value of maxDate
   *
   * @return  DateTimeInterface|null
   */
  public function getMaxDate()
  {
    return $this->maxDate;
  }

  /**
   * Set the value of maxDate
   *
   * @param  DateTimeInterface|null  $maxDate
   *
   * @return  self
   */
  public function setMaxDate($maxDate)
  {
    $this->maxDate = $maxDate;

    return $this;
  }

  /**
   * Get the value of limit
   *
   * @return  int
   */
  public function getLimit()
  {
    return $this->limit;
  }

  /**
   * Set the value of limit
   *
   * @param  int  $limit
   *
   * @return  self
   */
  public function setLimit(int $limit)
  {
    $this->limit = $limit;

    return $this;
  }

  /**
   * Get the value of isVerified
   *
   * @return  bool
   */
  public function getIsVerified()
  {
    return $this->isVerified;
  }

  /**
   * Set the value of isVerified
   *
   * @param  bool  $isVerified
   *
   * @return  self
   */
  public function setIsVerified(bool $isVerified)
  {
    $this->isVerified = $isVerified;

    return $this;
  }

  /**
   * Get the value of compte
   *
   * @return  string
   */
  public function getCompte()
  {
    return $this->compte;
  }

  /**
   * Set the value of compte
   *
   * @param  string  $compte
   *
   * @return  self
   */
  public function setCompte(string $compte)
  {
    $this->compte = $compte;

    return $this;
  }
}
