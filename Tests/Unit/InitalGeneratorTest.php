<?php


namespace Unit;

use InitialsGenerator\Generator;
use PHPUnit\Framework\TestCase;

class InitalGeneratorTest extends TestCase
{

    /**
     * @test
     */
    public function canCallGenerator()
    {
        $generator = new Generator();
        $this->assertTrue(is_string($generator->generate('Peter Pan')));
    }

    /**
     * @test
     */
    public function canSeparateNameParts()
    {
        $generator = new Generator();
        $generator->extractNameParts('Bruno Seirup-Thinnesen');
        $this->assertEquals(3, count($generator->nameParts));
    }

    public function runAllNamesInList()
    {

    }

    /**
     * @test
     */
    public function cleanName()
    {
        $generator = new Generator();

        $cleanedName = $generator->cleanupString('Elżbieta');
        $this->assertEquals('elzbieta', $cleanedName);

        $cleanedName = $generator->cleanupString('Søren');
        $this->assertEquals('soren', $cleanedName);

        $cleanedName = $generator->cleanupString('Żaneta');
        $this->assertEquals('zaneta', $cleanedName);
    }

    /**
     * @test
     */
    public function generatesInitials()
    {
        $generator = new Generator();
        $initials = $generator->generate('Peter Pan');
        $this->assertTrue(strlen($initials) == 3);
        $this->assertEquals('ppa', $initials);

        $initials = $generator->generate('Bruno Seirup-Thinnesen');
        $this->assertTrue(strlen($initials) == 3);
        $this->assertEquals('bst', $initials);
    }

    /**
     * @test
     */
    public function suggestDifferentCombinationIfInitialAlreadyUsedForDoubleNames()
    {
        // If first priority is taken, try using first two letters of firstname and first letter of last name
        $generator = new Generator();
        $initials = $generator->generate('Peter Pan', ['ppa']);
        $this->assertTrue(strlen($initials) == 3);
        $this->assertEquals('pep', $initials);
    }

    /**
     * @test
     */
    public function suggestAnotherComboIfthereAreMultipleNamesAndFirstComboWasTaken()
    {
        $generator = new Generator();
        $initials = $generator->generate('Peter Pingo Pan', ['ppa', 'ppe']);
        $this->assertTrue(strlen($initials) == 3);
        $this->assertEquals('ppp', $initials);
    }

    /**
     * @test
     */
    public function ifThereAreThreeNamesTryWithFirstTwoLettersOfMiddle()
    {
        $generator = new Generator();
        $initials = $generator->generate('Peter Pingo Pan', ['ppa', 'ppe', 'ppp', 'pep']);
        $this->assertTrue(strlen($initials) == 3);
        $this->assertEquals('ppi', $initials);
    }

    /**
     * @test
     */
    public function tryUsingFirstAndLastLetterOfLastName()
    {
        $generator = new Generator();
        $initials = $generator->generate('Peter Pingo Pan', ['ppa', 'ppe', 'ppp', 'pep', 'ppi']);
        $this->assertTrue(strlen($initials) == 3);
        $this->assertEquals('ppn', $initials);
    }

}