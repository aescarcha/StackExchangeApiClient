<?php

/**
 * This file is part of the StackExchangeApiClient library.
 *
 * @author  benatespina <benatespina@gmail.com>
 *
 * @license MIT
 */

namespace BenatEspina\StackExchangeApiClient\Model;

use BenatEspina\StackExchangeApiClient\Model\Interfaces\BadgeCountInterface;
use BenatEspina\StackExchangeApiClient\Util\Util;

/**
 * Class BadgeCount.
 *
 * @package BenatEspina\StackExchangeApiClient\Model\Traits
 */
class BadgeCount implements BadgeCountInterface
{
    /**
     * Number of bronze badges.
     *
     * @var int
     */
    protected $bronze;

    /**
     * Number of gold badges.
     *
     * @var int
     */
    protected $gold;

    /**
     * Number of silver badges.
     *
     * @var int
     */
    protected $silver;

    /**
     * Constructor.
     *
     * @param null|mixed[] $json The json string being decoded
     */
    public function __construct($json = null)
    {
        $this->bronze = Util::setIfIntegerExists($json, 'bronze');
        $this->gold = Util::setIfIntegerExists($json, 'gold');
        $this->silver = Util::setIfIntegerExists($json, 'silver');
    }

    /**
     * {@inheritdoc}
     */
    public function setBronze($bronze)
    {
        $this->bronze = $bronze;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBronze()
    {
        return $this->bronze;
    }

    /**
     * {@inheritdoc}
     */
    public function setGold($gold)
    {
        $this->gold = $gold;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getGold()
    {
        return $this->gold;
    }

    /**
     * {@inheritdoc}
     */
    public function setSilver($silver)
    {
        $this->silver = $silver;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSilver()
    {
        return $this->silver;
    }
}
