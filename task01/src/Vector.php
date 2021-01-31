<?php
    namespace App;

    class Vector {

        private  $xCoordinate;
        private  $yCoordinate;
        private  $zCoordinate;

        public function __construct(int $xCoordinate, int $yCoordinate, int $zCoordinate) {

            if($xCoordinate == 0 &&  $yCoordinate == 0 && $zCoordinate == 0) {
                echo "Одна из координат должна быть ненулевой";
                exit();
            }

            $this->xCoordinate = $xCoordinate;
            $this->yCoordinate = $yCoordinate;
            $this->zCoordinate = $zCoordinate;
        }

        public function add(Vector $vector): Vector {
            $xCoordinate = $this->xCoordinate + $vector->xCoordinate;
            $yCoordinate = $this->yCoordinate + $vector->yCoordinate;
            $zCoordinate = $this->zCoordinate + $vector->zCoordinate;

            return new Vector($xCoordinate, $yCoordinate, $zCoordinate);
        }

        public function sub(Vector $vector): Vector {
            $xCoordinate = $this->xCoordinate - $vector->xCoordinate;
            $yCoordinate = $this->yCoordinate - $vector->yCoordinate;
            $zCoordinate = $this->zCoordinate - $vector->zCoordinate;

            return new Vector($xCoordinate, $yCoordinate, $zCoordinate);
        }

        public function product($number): Vector {
            $xCoordinate = $this->xCoordinate * $number;
            $yCoordinate = $this->yCoordinate * $number;
            $zCoordinate = $this->zCoordinate * $number;

            return new Vector($xCoordinate, $yCoordinate, $zCoordinate);
        }
        
        public function scalarProduct(Vector $vector): int {
            $xCoordinate = $this->xCoordinate * $vector->xCoordinate;
            $yCoordinate = $this->yCoordinate * $vector->yCoordinate;
            $zCoordinate = $this->zCoordinate * $vector->zCoordinate;

            $sumCord = $xCoordinate + $yCoordinate + $zCoordinate;
            return $sumCord;
        }

        public function vectorProduct(Vector $vector): Vector {
            $xCoordinate = $this->yCoordinate * $vector->zCoordinate - $this->zCoordinate * $vector->yCoordinate;
            $yCoordinate = $this->zCoordinate * $vector->xCoordinate - $this->xCoordinate * $vector->zCoordinate;
            $zCoordinate = $this->xCoordinate * $vector->yCoordinate - $this->yCoordinate * $vector->xCoordinate;

            return new Vector($xCoordinate, $yCoordinate, $zCoordinate);
        }

        public function __toString(): string {

            return "(".$this->xCoordinate.";".$this->yCoordinate.";".$this->zCoordinate.")";
        }
        
    }
?>