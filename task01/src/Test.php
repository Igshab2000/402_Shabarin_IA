<?php
    namespace App\Test;

    use App\Vector;

    function runTest() {
        $firstVector = new Vector(5, 6, 7);
        echo $firstVector."\n";

        $secondVector = new Vector(8, 9, 10);
        echo $firstVector."\n";

        $vectorAddition = $firstVector->add($secondVector);
        echo $vectorAddition."\n";

        $vectorDifference = $firstVector->sub($secondVector);
        echo $vectorDifference."\n";

        $multiplyingVectorByANumber = $firstVector->product(5);
        echo $multiplyingVectorByANumber."\n";

        $scalarProduct = $firstVector->scalarProduct($secondVector);
        echo $scalarProduct."\n";

        $vectorProduct = $firstVector->vectorProduct($secondVector);
        echo $vectorProduct."\n";
    }
?>