<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class ConcentrationSumOfRatios implements DataAwareRule, ValidationRule
{
    public function __construct(public string $arrayKey = 'receipt_raws')
    {
    }

    /**
     * All of the data under validation.
     *
     * @var array<string, mixed>
     */
    protected $data = [];

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */

    // ...

    /**
     * Set the data under validation.
     *
     * @param  array<string, mixed>  $data
     */
    public function setData(array $data): static
    {
        $this->data = $data;

        return $this;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $sum = round(array_sum(array_column($this->data[$this->arrayKey], 'ratio')), 2);

        if ($value != $sum) {
            $fail("Поле :attribute должен быть равен {$sum}");
        }
    }
}
