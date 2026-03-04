<?php
declare(strict_types=1);

namespace Plaisio\Helper\Test;

use PHPUnit\Framework\TestCase;
use Plaisio\Helper\Password;

/**
 * Test cases for class Password.
 */
class PasswordTest extends TestCase
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test the computation cost of password hashing.
   */
  public function testComputationCost(): void
  {
    $time1 = microtime(true);
    $hash  = Password::passwordHash('qwerty123');
    $time2 = microtime(true);
    Password::passwordVerify('qwerty123', $hash);
    $time3 = microtime(true);

    echo sprintf("Duration Password::passwordHash:   %.3f seconds.\n", ($time2 - $time1));
    echo sprintf("Duration Password::passwordVerify: %.3f seconds.\n", ($time3 - $time2));

    self::assertGreaterThanOrEqual(0.25, $time2 - $time1);
    self::assertGreaterThanOrEqual(0.25, $time3 - $time2);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test cases for method passwordHash.
   */
  public function testPasswordHash1(): void
  {
    $hash = Password::passwordHash('qwerty');

    self::assertTrue(is_string($hash));
    self::assertGreaterThanOrEqual(60, strlen($hash));
    self::assertLessThanOrEqual(120, strlen($hash));
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test cases for method passwordHash with equal cost.
   */
  public function testPasswordNeedsRehash1(): void
  {
    $hash        = Password::passwordHash('qwerty');
    $needsRehash = Password::passwordNeedsRehash($hash);

    self::assertFalse($needsRehash);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test cases for method passwordHash with higher cost.
   */
  public function testPasswordNeedsRehash2(): void
  {
    Password::$options['memory_cost'] = (int)(Password::$options['memory_cost'] / 2);
    $hash                             = Password::passwordHash('qwerty');

    Password::$options['memory_cost'] = (int)(2 * Password::$options['memory_cost']);
    $needsRehash                      = Password::passwordNeedsRehash($hash);

    self::assertTrue($needsRehash);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test cases for method passwordHash with lower cost.
   */
  public function testPasswordNeedsRehash3(): void
  {
    $hash = Password::passwordHash('qwerty');

    Password::$options['time_cost']--;
    $needsRehash = Password::passwordNeedsRehash($hash);

    self::assertTrue($needsRehash);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test cases for method passwordVerify.
   */
  public function testPasswordVerify1(): void
  {
    $hash = Password::passwordHash('qwerty');
    $pass = Password::passwordVerify('qwerty', $hash);
    self::assertTrue($pass);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test cases for method passwordVerify.
   */
  public function testPasswordVerify2(): void
  {
    $hash = Password::passwordHash('abc123');
    $pass = Password::passwordVerify('qwerty', $hash);
    self::assertFalse($pass);

    $hash = Password::passwordHash('');
    $pass = Password::passwordVerify('', $hash);
    self::assertFalse($pass);

    $pass = Password::passwordVerify('', '');
    self::assertFalse($pass);

    $pass = Password::passwordVerify('qwerty', null);
    self::assertFalse($pass);

    $pass = Password::passwordVerify(null, null);
    self::assertFalse($pass);
  }
  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
