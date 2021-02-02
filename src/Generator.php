<?php


namespace InitialsGenerator;


use Illuminate\Support\Str;

class Generator
{

    /**
     * @var array
     */
    private $takenInitials = [];

    private $letters = [];
    /**
     * @var array|string[]
     */
    public $nameParts;
    /**
     * @var array|mixed|string[]
     */
    public $lastName;
    /**
     * @var mixed|string
     */
    public $firstName;

    public function __construct()
    {
    }

    public function extractNameParts($name)
    {
        // split name at -
        $name = str_replace('-', ' ', $name);

        // split name to array of parts
        $nameParts = explode(' ', $name);
        // Make sure there are no empty parts (when people add too many spaces by mistake)
        $nameParts = array_filter($nameParts);

        // Replace crazy characters
        $this->nameParts = array_map(function($namePart) {
            return $this->cleanupString($namePart);
        }, $nameParts);

        // specifically extract first and last name
        $this->firstName = $this->nameParts[0];
        $this->lastName = last($this->nameParts);
    }

    public function cleanupString($name)
    {
        return Str::slug($name);
    }

    public function generate(string $name, $cantBeIn = [], $priority = 0): string
    {
        $this->extractNameParts($name);

        // We have a problem, lets prioritize solutions:
        switch ($priority) {
            case 0: // Try using first two letters from first name, and first from last
                $this->primarySolution();
                break;
            case 1:
                $this->secondarySolution();
                break;
            case 2:
                $this->thirdSolution();
                break;
            case 3:
                $this->fourthSolution();
                break;
            default:
                return 'err';
        }

        // check if valid and return.
        if(!in_array(implode($this->letters), $cantBeIn)) {
            return implode('', $this->letters);
        }

        // Up the priority and call yourself to try something different.
        $priority++;
        return self::generate($name, $cantBeIn, $priority);
    }

    public function batchGenerate(array $names): array
    {
        return [];
    }

    /**
     * Add list of initials that are not available.
     * @param array $takenInitials
     * @return $this
     */
    public function setTakenInitials(array $takenInitials): self
    {
        $this->takenInitials = [];
        return $this;
    }

    public function solutionPriority()
    {
    }

    /**
     * if name has > 2 parts, use first letter from first two and first from last.
     * Else we use first letter of first name and two first letters of last name
     * @param array $nameParts
     */
    private function primarySolution()
    {
        // Select 3 letters
        $this->letters = array_fill(0,3,'');

        // Use first letter from first namepart
        $this->letters[0] = substr($this->firstName, 0, 1);

        // If name has more than two parts, use first letter from first, second and last part
        if (count($this->nameParts) > 2) {
            $this->letters[1] = substr($this->nameParts[1], 0, 1);
            $this->letters[2] = substr($this->lastName, 0, 1);
        }

        // If we are still missing a part, we take first and second letter from last part.
        if(empty($this->letters[1])) {
            $this->letters[1] = substr($this->lastName, 0, 1);
            $this->letters[2] = substr($this->lastName, 1, 1);
        }
    }

    private function secondarySolution()
    {
        // Lets try the same as the first solution, but using the first two letters from first name
        $this->letters[1] = substr($this->firstName, 1, 1);
        $this->letters[2] = substr($this->lastName, 0, 1);
    }

    private function thirdSolution()
    {
        // if there is a middlename, try using the first two letters from that
        if (count($this->nameParts) > 2) {
            $this->letters[1] = substr($this->nameParts[1], 0, 1);
            $this->letters[2] = substr($this->nameParts[1], 1, 1);
        }
    }

    private function fourthSolution()
    {
        // try using the first last letter of last name
        $this->letters[1] = substr($this->lastName, 0, 1);
        $this->letters[2] = substr($this->lastName, -1, 1);
    }

}