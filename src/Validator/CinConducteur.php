<?php
namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class CinConducteur extends Constraint
{
    public $message = 'Invalid value for CIN. It should be an 8-digit number starting with 0, 1 or 00.';
}
