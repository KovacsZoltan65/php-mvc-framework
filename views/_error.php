<?php

/**
 * _error.php.
 * User: kzoltan
 * Date: 2022-03-03
 * Time: 07:31
 */

/** @var $exception \Exception */

?>

<h1><?php echo $exception->getCode() ?> - <?php echo $exception->getMessage() ?></h1>