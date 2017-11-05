<?php
//----------------------------------------------------------------------------------------------------------------------
namespace SetBased\Abc\Helper\Test;

use PHPUnit\Framework\TestCase;
use SetBased\Abc\Helper\Password;

/**
 * Test cases for class Password.
 */
class PasswordTest extends TestCase
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test cases for method passwordHash.
   */
  public function testPasswordHash1()
  {
    $hash = Password::passwordHash('qwerty');

    self::assertTrue(is_string($hash));
    self::assertGreaterThanOrEqual(60, strlen($hash));
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test cases for method passwordHash with equal cost.
   */
  public function testPasswordNeedsRehash1()
  {
    $hash        = Password::passwordHash('qwerty');
    $needsRehash = Password::passwordNeedsRehash($hash);

    self::assertFalse($needsRehash);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test cases for method passwordHash with higher cost.
   */
  public function testPasswordNeedsRehash2()
  {
    Password::$cost--;
    $hash = Password::passwordHash('qwerty');

    Password::$cost++;
    $needsRehash = Password::passwordNeedsRehash($hash);

    self::assertTrue($needsRehash);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test cases for method passwordHash with lower cost.
   */
  public function testPasswordNeedsRehash3()
  {
    $hash = Password::passwordHash('qwerty');

    Password::$cost--;
    $needsRehash = Password::passwordNeedsRehash($hash);

    self::assertTrue($needsRehash);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Test cases for method passwordVerify.
   */
  public function testPasswordVerify()
  {
    $hash = Password::passwordHash('qwerty');
    $pass = Password::passwordVerify('qwerty', $hash);
    self::assertTrue($pass);

    $hash = Password::passwordHash('abc123');
    $pass = Password::passwordVerify('qwerty', $hash);
    self::assertFalse($pass);
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
