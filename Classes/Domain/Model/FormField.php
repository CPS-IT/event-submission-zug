<?php

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 *
 */

namespace Cpsit\EventSubmission\Domain\Model;

class FormField
{
    protected string $id = '';
    protected string $type = '';
    protected string $name = '';
    protected string $validation = '';
    protected string $lengthMin = '';
    protected string $lengthMax = '';
    protected string $label = '';
    protected string $help = '';
    protected bool $multiple = false;
    protected array $options = [];

    public function __toString(): string
    {
        $properties = get_object_vars($this);
        return json_encode($properties);
    }

    public function __toArray(): array
    {
        $properties = get_object_vars($this);
        return $properties;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getValidation(): string
    {
        return $this->validation;
    }

    public function setValidation(string $validation): void
    {
        $this->validation = $validation;
    }

    public function getLengthMin(): string
    {
        return $this->lengthMin;
    }

    public function setLengthMin(string $lengthMin): void
    {
        $this->lengthMin = $lengthMin;
    }

    public function getLengthMax(): string
    {
        return $this->lengthMax;
    }

    public function setLengthMax(string $lengthMax): void
    {
        $this->lengthMax = $lengthMax;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    public function getHelp(): string
    {
        return $this->help;
    }

    public function setHelp(string $help): void
    {
        $this->help = $help;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function setOptions(array $options): void
    {
        $this->options = $options;
    }

    public function isMultiple(): bool
    {
        return $this->multiple;
    }

    public function setMultiple(bool $multiple): void
    {
        $this->multiple = $multiple;
    }
}
