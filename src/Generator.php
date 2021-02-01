<?php


namespace InitialsGenerator;


class Generator
{

    /**
     * @var array
     */
    private $takenInitials = [];

    public function __construct()
    {
    }

    public function generate(string $name): string
    {
        return '';
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

}