<?php


namespace Unit;


use InitialsGenerator\Generator;
use PHPUnit\Framework\TestCase;

class InitalGeneratorTest extends TestCase
{

    public $namesDk = [

    ];

    /**
     * @test
     */
    public function canCallGenerator()
    {
        $generator = new Generator();
        $this->assertTrue($generator->generate('Peter Pan'));
    }

}