<?php

class AvatarGenerator
{
    private string $background;
    private string $color;
    private int $size;

    public function __construct(string $background = '5469d4', string $color = 'fff', int $size = 128)
    {
        $this->background = $background;
        $this->color = $color;
        $this->size = $size;
    }

    public function generate(string $name): string
    {
        $encodedName = urlencode($name);
        return "https://ui-avatars.com/api/?name={$encodedName}&background={$this->background}&color={$this->color}&size={$this->size}";
    }
}
