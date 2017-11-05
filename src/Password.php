<?php
//----------------------------------------------------------------------------------------------------------------------
namespace SetBased\Abc\Helper;

/**
 * A utility class for hashing and verifying passwords.
 */
class Password
{
  //--------------------------------------------------------------------------------------------------------------------
  /**
   * The algorithmic cost that should be used in [password_hash](http://php.net/manual/function.password-hash.php).
   *
   * @var int
   */
  public static $cost = 14;

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns a hashed password using PHP native [password_hash](http://php.net/manual/function.password-hash.php)
   * function.
   *
   * @param string $password The password (given by the user).
   *
   * @return string The hashed password.
   */
  public static function passwordHash($password)
  {
    $options = ['cost' => self::$cost];

    $hash = password_hash($password, PASSWORD_DEFAULT, $options);
    if ($hash===false)
    {
      throw new \RuntimeException('Function password_hash failed');
    }

    return $hash;
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Checks if the given hash matches the given options using PHP native
   * [password_needs_rehash](http://php.net/manual/function.password-needs-rehash.php) function.
   *
   * @param string $hash The hash (stored in the system).
   *
   * @return bool True if and only if the password matches with the hash value.
   */
  public static function passwordNeedsRehash($hash)
  {
    $options = ['cost' => self::$cost];

    return password_needs_rehash($hash, PASSWORD_DEFAULT, $options);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Verifies that a password matches a hash using PHP native
   * [password_verify](http://php.net/manual/function.password-verify.php) function.
   *
   * @param string $password The password (given by the user).
   * @param string $hash     The hash (stored in the system).
   *
   * @return bool True if and only if the password matches with the hash value.
   */
  public static function passwordVerify($password, $hash)
  {
    return password_verify($password, $hash);
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
