<?php
declare(strict_types=1);

namespace Plaisio\Helper;

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
  public static int $cost = 14;

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Returns a hashed password using PHP native [password_hash](http://php.net/manual/function.password-hash.php)
   * function.
   *
   * @param string $password The password (given by the user).
   *
   * @return string The hashed password.
   *
   * @api
   * @since 1.0.0
   */
  public static function passwordHash(string $password): string
  {
    return password_hash($password, PASSWORD_DEFAULT, ['cost' => self::$cost]);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Checks if the given hash matches the given options using PHP native
   * [password_needs_rehash](http://php.net/manual/function.password-needs-rehash.php) function.
   *
   * @param string $hash The hash (stored in the system).
   *
   * @return bool True if and only if the password matches with the hash value.
   *
   * @api
   * @since 1.0.0
   */
  public static function passwordNeedsRehash(string $hash): bool
  {
    return password_needs_rehash($hash, PASSWORD_DEFAULT, ['cost' => self::$cost]);
  }

  //--------------------------------------------------------------------------------------------------------------------
  /**
   * Verifies that a password matches a hash using PHP native
   * [password_verify](http://php.net/manual/function.password-verify.php) function. However, when invoked with an empty
   * password or empty hash will return false.
   *
   * @param string|null $password The password (given by the user).
   * @param string|null $hash     The hash (stored in the system).
   *
   * @return bool True if and only if the password matches with the hash value.
   *
   * @api
   * @since 1.0.0
   */
  public static function passwordVerify(?string $password, ?string $hash): bool
  {
    $password = $password ?? '';
    $hash     = $hash ?? '';

    if ($password==='' || $hash==='') return false;

    return password_verify($password, $hash);
  }

  //--------------------------------------------------------------------------------------------------------------------
}

//----------------------------------------------------------------------------------------------------------------------
