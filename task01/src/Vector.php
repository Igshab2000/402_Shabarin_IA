<?php
    namespace App;

    class Vector {

        private  $xCord;
        private  $yCord;
        private  $zCord;

        public function __construct(int $xCord, int $yCord, int $zCord) {

            if($xCord == 0 &&  $yCord == 0 && $zCord == 0) {
                echo "Одна из координат должна быть ненулевой";
                exit();
            }

            $this->xCord = $xCord;
            $this->yCord = $yCord;
            $this->zCord = $zCord;
        }

        public function add(Vector $vector): Vector {
            $xCord = $this->xCord + $vector->xCord;
            $yCord = $this->yCord + $vector->yCord;
            $zCord = $this->zCord + $vector->zCord;

            return new Vector($xCord, $yCord, $zCord);
        }

        public function sub(Vector $vector): Vector {
            $xCord = $this->xCord - $vector->xCord;
            $yCord = $this->yCord - $vector->yCord;
            $zCord = $this->zCord - $vector->zCord;

            return new Vector($xCord, $yCord, $zCord);
        }

        public function product($number): Vector {
            $xCord = $this->xCord * $number;
            $yCord = $this->yCord * $number;
            $zCord = $this->zCord * $number;

            return new Vector($xCord, $yCord, $zCord);
        }
        
        public function scalarProduct(Vector $vector): int {
            $xCord = $this->xCord * $vector->xCord;
            $yCord = $this->yCord * $vector->yCord;
            $zCord = $this->zCord * $vector->zCord;

            $sumCord = $xCord + $yCord + $zCord;
            return $sumCord;
        }

        public function vectorProduct(Vector $vector): Vector {
            $xCord = $this->yCord * $vector->zCord - $this->zCord * $vector->yCord;
            $yCord = $this->zCord * $vector->xCord - $this->xCord * $vector->zCord;
            $zCord = $this->xCord * $vector->yCord - $this->yCord * $vector->xCord;

            return new Vector($xCord, $yCord, $zCord);
        }

        public function __toString(): string {

            return "(".$this->xCord.";".$this->yCord.";".$this->zCord.")";
        }
        
    }
?>