<?php 
namespace MariaLembeck\Math;


class Basic{

    /**
     * @return int|float
     */
    public function soma(int|float $numero, int|float $numero2) 
    {
        return $numero + $numero2;
    }

    /**
     * @return int|float
     */
    public function subtrai(int|float $numero, int|float $numero2)
    {
        return $numero - $numero2;
    }

     /**
     * @return int|float
     */
    public function multiplica(int|float $numero, int|float $numero2)
    {
        return $numero * $numero2;
    }

     /**
     * @return int|float
     */
    public function divide(int|float $numero, int|float $divisor)
    {
        return $numero / $divisor;
    }

      /**
     * @return int|float
     */
    public function eleva(int|float $numero, int|float $numero2)
    {
        return $numero ** 2;
    }

      /**
     * @return int|float
     */
    public function raiz(int|float $numero)
    {
        return sqrt($numero);
    }
}